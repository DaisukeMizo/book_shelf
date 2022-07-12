USE booklist_db;

DROP TABLE IF EXISTS booklist;

CREATE TABLE booklist (
    id INT(11) AUTO_INCREMENT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    image VARCHAR(255),
    score INT(1),
    mediums VARCHAR(15),
    status VARCHAR(10))
    DEFAULT CHARACTER SET=utf8;
