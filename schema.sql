CREATE DATABASE yeticave
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;

  USE yeticave;

-- Таблица категорий

CREATE TABLE categories (
  id    INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  name  VARCHAR(50) UNIQUE                      NOT NULL
);

-- таблица пользователей

CREATE TABLE users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY    NOT NULL,
  reg_date TIMESTAMP DEFAULT NOW()              NOT NULL,
  email VARCHAR(80) UNIQUE                      NOT NULL,
  name VARCHAR(80)                              NOT NULL,
  password VARCHAR(120)                         NOT NULL,
  avatar VARCHAR(255),
  contacts VARCHAR(255)
);

-- таблица лотов

CREATE TABLE lots (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY    NOT NULL,
  creation_date TIMESTAMP DEFAULT NOW()         NOT NULL,
  title VARCHAR(100)                            NOT NULL,
  description VARCHAR(1000)                     NOT NULL,
  image VARCHAR(100)                            NOT NULL,
  start_price INT(10) UNSIGNED                  NOT NULL,
  finish_date TIMESTAMP DEFAULT NOW()           NOT NULL,
  bet_step INT UNSIGNED                         NOT NULL,
);

-- таблица ставок

CREATE TABLE bets (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY    NOT NULL,
  bet_date TIMESTAMP DEFAULT NOW()              NOT NULL
);

CREATE INDEX category_name ON categories(name);
CREATE INDEX lot_name ON lots(title);
CREATE INDEX user_email ON users(email);