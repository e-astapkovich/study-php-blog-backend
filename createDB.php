<?php

$pdo = new PDO('sqlite:blog.sqlite', null, null, [
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);

// Создание таблицы users
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


// Создание таблицы posts
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

// Создание таблицы comments
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

// Добавление тестовых записей в таблицу users
$pdo->query("INSERT INTO users (uuid, login, first_name, last_name) VALUES ('3bed1a29-6737-45ff-81f2-7366f56498a7', 'pirate', 'Billy', 'Bons');");
$pdo->query("INSERT INTO users (uuid, login, first_name, last_name) VALUES ('28a69607-72b3-476c-bd2c-08b4a6b82e93', 'ben', 'Ben', 'Gann');");
$pdo->query("INSERT INTO users (uuid, login, first_name, last_name) VALUES ('02f07d60-2548-4342-85f5-65f2a7c3be4b', 'kok', 'John', 'Silver');");

// Добавление тестовых записей в таблицу posts
$pdo->query("INSERT INTO posts (uuid, author_uuid, title, text) VALUES ('881a75e6-5db9-4106-bb1c-94a84058594f', '28a69607-72b3-476c-bd2c-08b4a6b82e93', 'sos', 'Help me!');");

// Добавление тестовых записей в таблицу comments
$pdo->query("INSERT INTO comments (uuid, post_uuid, author_uuid, text) VALUES ('616f7121-89d0-4f38-b356-31746394d41a', '881a75e6-5db9-4106-bb1c-94a84058594f', '02f07d60-2548-4342-85f5-65f2a7c3be4b', 'Dont worry');");
