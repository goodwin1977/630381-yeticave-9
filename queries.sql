INSERT INTO categories (name, code) VALUES
  ('Доски и лыжи', 'boards'),
  ('Крепления', 'attachment'),
  ('Ботинки', 'boots'),
  ('Одежда', 'clothing'),
  ('Инструменты', 'tools'),
  ('Разное', 'other');

INSERT INTO users (email, name, password, avatar, contacts) VALUES
  ('appolon@mail.ru',
   'Апполинарий',
   'qwertyuiop',
   'img/avatar1.jpg',
   '+79122403330'),

  ('leo@ya.ru',
   'Леопольд',
   'asdfghjkl',
   'img/avatar2.jpg',
   '+79998765432'),

  ('sima@mail.ru',
   'Серафима',
   'zxcvbnmzxcvb',
   'img/avatar3.jpg',
   '+79122403816');

INSERT INTO lots (title, description, image_url, start_price, finish_date, bet_step, owner_id, category_id) VALUES (
  '2014 Rossignol District Snowboard',
  'Чумовая доска',
  'img/lot-1.jpg',
  '10999',
  '20190731',
  '500',
  '1',
  '1'),

  ('DC Ply Mens 2016/2017 Snowboard',
  'Модная коллекция',
  'img/lot-2.jpg',
  '159999',
  '20190720',
  '1000',
  '1',
  '1'),

  ('Крепления Union Contact Pro 2015 года размер L/XL',
  'супер крепления',
  'img/lot-3.jpg',
  '8000',
  '20190630',
  '200',
  '2',
  '2'),

  ('Ботинки для сноуборда DC Mutiny Charocal',
  'удобные ботинки',
  'img/lot-4.jpg',
  '10999',
  '20190615',
  '500',
  '2',
  '3'),

  ('Куртка для сноуборда DC Mutiny Charocal',
  'удобная куртка',
  'img/lot-5.jpg',
  '7500',
  '20190730',
  '100',
  '2',
  '4'),

  ('Маска Oakley Canopy',
  'всевидящее око',
  'img/lot-6.jpg',
  '5400',
  '20190720',
  '100',
  '2',
  '6');

INSERT INTO bets (cost, user_id, lot_id) VALUES 
('11900', '1', '1'),
('17000', '2', '3');

-- получить все категории
SELECT * FROM categories;

-- получить список самых свежих ставок для лота по его идентификатору
SELECT * FROM bets WHERE lot_id = 1 ORDER BY bet_date DESC;

-- обновить название лота по его идентификатору
UPDATE lots SET title = 'UPDATE. 2014 Rossignol District Snowboard' WHERE id = 1;

-- показать лот по его id. Получите также название категории, к которой принадлежит лот
SELECT lots.title as lot_title, categories.name as category_name FROM lots JOIN categories ON categories.id = lots.category_id WHERE lots.id = 1;

-- получить самые новые, открытые лоты. Каждый лот должен включать название, стартовую цену, ссылку на изображение, цену, название категории
SELECT title, start_price, image_url, bet_step, owner_id, categories.name as category_name, MAX(bets.cost) FROM lots RIGHT JOIN categories ON categories.id = category_id JOIN bets ON bets.lot_id = lots.id WHERE finish_date > NOW() GROUP BY lots.id DESC;