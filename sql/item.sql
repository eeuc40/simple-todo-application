CREATE TABLE item(
    id int NOT NULL AUTO_INCREMENT,
    PRIMARY KEY(id),
    uid int, 
    FOREIGN KEY(uid) REFERENCES account(uid),
    todo text,
    complete TINYINT(1) DEFAULT '0'
);
