SETUP (XAMPP/WAMP or any PHP 8+ host)
1. Copy this folder to htdocs (or your web root).
2. In phpMyAdmin, import database.sql.
3. Edit config.php: DB_USER, DB_PASS, and ADMIN_PASS (change it!).
4. Open http://localhost/tech_source/ ; add content at /admin.php.
If the database was already imported before adding Feedback, run `CREATE TABLE feedback(id INT AUTO_INCREMENT PRIMARY KEY,name VARCHAR(100) NULL,rating TINYINT UNSIGNED NOT NULL,feedback TEXT NOT NULL,created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP);` once in phpMyAdmin.
Contact form submissions are saved to the messages table and can be reviewed in the Admin panel.

AI Learning Agent
- Set OPENAI_API_KEY as an environment variable for the Apache/PHP process. Never put the key in browser code or a public file.
- On Windows, you can run `setx OPENAI_API_KEY "your-openai-api-key"` in PowerShell, then fully restart XAMPP/Apache so it can read the variable. Use your actual key in your own terminal; do not commit it.
- The default model is gpt-4o-mini. Optionally set OPENAI_MODEL to another model available to your API account.
- The chat uses the OpenAI API and requires internet access, an API key with API billing enabled, and the PHP cURL extension.
