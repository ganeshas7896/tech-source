<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

function respond($status, $data)
{
    http_response_code($status);
    echo json_encode($data, JSON_INVALID_UTF8_SUBSTITUTE);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respond(405, ['error' => 'Use POST to send a chat message.']);
}

$body = file_get_contents('php://input');
if ($body === false || strlen($body) > 20000) {
    respond(413, ['error' => 'This chat message is too long.']);
}

$apiKey = trim(getenv('OPENAI_API_KEY') ?: '');
if (!$apiKey) {
    respond(503, ['error' => 'The AI assistant is not configured yet. Set OPENAI_API_KEY on the web server and restart it.']);
}

if (!function_exists('curl_init')) {
    respond(503, ['error' => 'The AI assistant requires the PHP cURL extension. Enable it and restart the web server.']);
}

$input = json_decode($body, true);
$messages = $input['messages'] ?? null;
if (!is_array($messages) || count($messages) < 1 || count($messages) > 10) {
    respond(400, ['error' => 'Send a chat with up to 10 recent messages.']);
}

$validated = [];
$totalLength = 0;
foreach ($messages as $message) {
    if (!is_array($message)
        || !in_array($message['role'] ?? '', ['user', 'assistant'], true)
        || !is_string($message['content'] ?? null)
        || trim($message['content']) === ''
        || strlen($message['content']) > 4000) {
        respond(400, ['error' => 'One of the chat messages is invalid or too long.']);
    }

    $totalLength += strlen($message['content']);
    if ($totalLength > 12000) {
        respond(400, ['error' => 'This conversation is too long. Start a new chat and try again.']);
    }

    $validated[] = [
        'role' => $message['role'],
        'content' => $message['content'],
    ];
}

if (end($validated)['role'] !== 'user') {
    respond(400, ['error' => 'Send a user message to continue.']);
}

$now = time();
$recentRequests = array_values(array_filter(
    $_SESSION['ai_chat_requests'] ?? [],
    static fn($timestamp) => is_int($timestamp) && $timestamp > $now - 60
));
if (count($recentRequests) >= 10) {
    respond(429, ['error' => 'You have sent several messages recently. Please wait a minute and try again.']);
}
$recentRequests[] = $now;
$_SESSION['ai_chat_requests'] = $recentRequests;

$systemMessage = <<<'PROMPT'
You are Tech Source's friendly AI Learning Agent. Answer questions across software and technology, including programming languages, web development, frameworks, databases, APIs, cloud, DevOps, AI, cybersecurity fundamentals, and software testing.
Explain concepts at the user's level, include short practical examples when useful, and create clear step-by-step learning paths when asked. Give realistic time estimates and distinguish prerequisites from optional topics. For coding questions, provide safe, readable examples and explain how to test them.
For questions about Tech Source's own pages or offerings, do not invent facts; say when the site does not provide that information. Do not claim to browse the internet, run code, or perform actions. Be transparent when advice may be version-dependent, and encourage checking official documentation for current details. Keep answers focused and invite one relevant follow-up question when helpful.
PROMPT;

$payload = [
    'model' => getenv('OPENAI_MODEL') ?: 'gpt-4o-mini',
    'messages' => array_merge(
        [['role' => 'system', 'content' => $systemMessage]],
        $validated
    ),
    'max_completion_tokens' => 700,
];

$curl = curl_init('https://api.openai.com/v1/chat/completions');
curl_setopt_array($curl, [
    CURLOPT_POST => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CONNECTTIMEOUT => 10,
    CURLOPT_TIMEOUT => 60,
    CURLOPT_HTTPHEADER => [
        'Authorization: Bearer '.$apiKey,
        'Content-Type: application/json',
    ],
    CURLOPT_POSTFIELDS => json_encode($payload, JSON_INVALID_UTF8_SUBSTITUTE),
]);

$body = curl_exec($curl);
$status = (int)curl_getinfo($curl, CURLINFO_HTTP_CODE);
$curlError = curl_error($curl);
curl_close($curl);

if ($body === false) {
    error_log('AI chat request failed: '.$curlError);
    respond(502, ['error' => 'The AI service could not be reached. Please try again.']);
}

$result = json_decode($body, true);
if ($status < 200 || $status >= 300) {
    if ($status === 401 || $status === 403) {
        respond(502, ['error' => 'The AI service rejected its server credentials. Check OPENAI_API_KEY.']);
    }
    if ($status === 429) {
        respond(503, ['error' => 'The AI service is busy or its usage limit was reached. Please try again later.']);
    }
    error_log('AI chat service returned HTTP '.$status.'.');
    respond(502, ['error' => 'The AI service could not answer right now. Please try again.']);
}

$answer = $result['choices'][0]['message']['content'] ?? null;
if (!is_string($answer) || trim($answer) === '') {
    error_log('AI chat service returned no message content.');
    respond(502, ['error' => 'The AI service returned an empty answer. Please try again.']);
}

respond(200, ['a' => trim($answer)]);
