
CREATE TABLE products(id INT AUTO_INCREMENT PRIMARY KEY,title VARCHAR(150),description TEXT,url VARCHAR(255),tech VARCHAR(255),created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP);
CREATE TABLE features(id INT AUTO_INCREMENT PRIMARY KEY,title VARCHAR(150),description TEXT);
CREATE TABLE sources(id INT AUTO_INCREMENT PRIMARY KEY,title VARCHAR(150),link VARCHAR(255),category VARCHAR(80),note TEXT);
CREATE TABLE at_topics(id INT AUTO_INCREMENT PRIMARY KEY,title VARCHAR(150),details TEXT,learnings TEXT,duration VARCHAR(60));
CREATE TABLE messages(id INT AUTO_INCREMENT PRIMARY KEY,name VARCHAR(100),email VARCHAR(150),message TEXT,created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP);
CREATE TABLE feedback(id INT AUTO_INCREMENT PRIMARY KEY,name VARCHAR(100) NULL,rating TINYINT UNSIGNED NOT NULL,feedback TEXT NOT NULL,created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP);
INSERT INTO products(title,description,url,tech) VALUES('Sample Website','Replace this from the Admin panel with your first real website.','#','HTML, CSS, JS, PHP');
INSERT INTO features(title,description) VALUES('Responsive websites','Every site works on phone, tablet and desktop.'),('Dark and light themes','Visitors pick the look they prefer.'),('Tested before launch','Automation tests run on each release.');
INSERT INTO sources(title,link,category,note) VALUES('Selenium Docs','https://www.selenium.dev/documentation/','Automation Testing','Official WebDriver guide'),('MDN Web Docs','https://developer.mozilla.org/','Web','HTML, CSS, JS reference'),('PHP Manual','https://www.php.net/manual/en/','Backend','Official PHP reference');
INSERT INTO at_topics(title,details,learnings,duration) VALUES
('Test basics','Manual vs automation, test cases, test pyramid.','Know what to automate and what to keep manual.','1 week'),
('Selenium WebDriver','Locators, waits, page object model, cross-browser runs.','Stable UI tests with explicit waits.','3 weeks'),
('API testing','Postman and REST checks for status, schema, auth.','Catch backend bugs before the UI.','2 weeks'),
('CI/CD integration','Run tests on every commit with reports.','Fast feedback on each release.','1 week');
