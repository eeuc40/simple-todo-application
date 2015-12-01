CREATE TABLE account(
    uid int NOT NULL AUTO_INCREMENT,
    PRIMARY KEY(uid),
    name varchar(255)
);
-- Add a user called Richie to the db
INSERT INTO account(name) VALUES('Richie');