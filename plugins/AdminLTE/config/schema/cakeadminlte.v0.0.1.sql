
CREATE TABLE contact(id int AUTO_INCREMENT PRIMARY KEY, user_id int REFERENCES users, subject varchar(2056), message text, created DATETIME, modified datetime, completed datetime);