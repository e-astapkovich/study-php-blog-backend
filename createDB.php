<?php

$pdo = new PDO('sqlite:blog.sqlite', null, null, [
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);

$pdo->query("
CREATE TABLE users (
  uuid       TEXT PRIMARY KEY
                  UNIQUE
                  NOT NULL,
  login      TEXT UNIQUE
                  NOT NULL,
  first_name TEXT NOT NULL,
  last_name  TEXT
);");

$pdo->query("
CREATE TABLE posts (
  uuid        TEXT PRIMARY KEY
                   UNIQUE
                   NOT NULL,
  author_uuid TEXT NOT NULL,
  title       TEXT,
  text        TEXT NOT NULL,
  FOREIGN KEY (
    author_uuid
  )
  REFERENCES users (uuid) ON DELETE NO ACTION
                          ON UPDATE CASCADE
);");

$pdo->query("
CREATE TABLE comments (
  uuid        TEXT PRIMARY KEY
                   UNIQUE
                   NOT NULL,
  post_uuid   TEXT REFERENCES posts (uuid) ON DELETE CASCADE
                                           ON UPDATE NO ACTION
                   NOT NULL,
  author_uuid TEXT REFERENCES users (uuid) ON DELETE NO ACTION
                                           ON UPDATE CASCADE
                   NOT NULL,
  text        TEXT NOT NULL
);");
