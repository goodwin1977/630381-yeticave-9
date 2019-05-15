<?php
$is_auth = rand(0, 1);
$user_name = 'Максим'; // укажите здесь ваше имя

require_once('helpers.php');
require_once('functions.php');
require_once('data_function.php');

$categories = get_categories();


if (!isset($_GET['id']) || empty($_GET['id'])) {
  print_error('Идентификатор лота не передан');
  die();
}

$lot = get_lot_by_id(intval($_GET['id']));

$lot_content = include_template('lot.php', [
  'lot_title' => $lot['title'],
  'categories' => $lot['category_name'],
  'description' => $lot['description'],
  'price' => $lot['start_price'],
  'bet_step' => $lot['bet_step'],
  'img_url' => $lot['image_url'],
  'finish_date' => $lot['finish_date']
]);

$layout_content = include_template('layout.php', [
  'content' => $lot_content,
  'categories' => $categories,
  'is_auth' => $is_auth,
  'user_name' => $user_name,
  'title' => $lot_title
]);

print($layout_content);

?>