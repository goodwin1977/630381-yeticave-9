CREATE DATABASE yeticave
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;

  USE yeticave;

-- Таблица категорий

CREATE TABLE categories (
  id TINYINT UNSIGNED AUTO_INCREMENT PRIMARY KEY   NOT NULL,
  name VARCHAR(128) UNIQUE                         NOT NULL,
  code VARCHAR(64) UNIQUE                          NOT NULL
);

-- таблица пользователей

CREATE TABLE users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY    NOT NULL,
  reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP  NOT NULL,
  email VARCHAR(256) UNIQUE                     NOT NULL,
  name VARCHAR(128)                             NOT NULL,
  password VARCHAR(128)                         NOT NULL,
  avatar VARCHAR(512),
  contacts VARCHAR(256)
);

-- таблица лотов

CREATE TABLE lots (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY    NOT NULL,
  creation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
  title VARCHAR(256)                            NOT NULL,
  description text                              NOT NULL,
  image_url VARCHAR(512)                        NOT NULL,
  start_price INT UNSIGNED                      NOT NULL,
  finish_date TIMESTAMP                         NOT NULL,
  bet_step INT UNSIGNED                         NOT NULL,
  owner_id INT UNSIGNED                         NOT NULL,
  winner_id INT UNSIGNED,
  category_id TINYINT UNSIGNED                  NOT NULL,
  FOREIGN KEY (owner_id) REFERENCES users(id),
  FOREIGN KEY (winner_id) REFERENCES users(id),
  FOREIGN KEY (category_id) REFERENCES categories(id),
  INDEX lot_index (title, category_id)
);

-- таблица ставок

CREATE TABLE bets (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY    NOT NULL,
  bet_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP  NOT NULL,
  cost INT UNSIGNED NOT NULL,
  user_id INT UNSIGNED NOT NULL,
  lot_id INT UNSIGNED NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (lot_id) REFERENCES lots(id),
  INDEX user_lot (user_id, lot_id)
);


CREATE INDEX lot_name ON lots(title);
CREATE INDEX user_email ON users(email);