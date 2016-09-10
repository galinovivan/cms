DROP TABLE IF EXISTS articles;
CREATE TABLE articles
(
id              SMALLINT unsignet NOT NULL auto_increment,
publicationDate DATE NOT NULL,
title           VARCHAR(255) NOT NULL,
summary         TEXT NOT NULL,
content         MEDIUMTEXT NOT NULL,

PRIMARY KEY     (id)
);