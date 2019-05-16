<?php
$is_auth = rand(0, 1);
$user_name = 'Максим'; // укажите здесь ваше имя

require_once('helpers.php');
require_once('functions.php');
require_once('data_function.php');

$categories = get_categories();

$id = $_GET['id'];
if ((!$id) || empty($id)) {
  print_error('Идентификатор лота не передан');
  die();
}

$lot = get_lot_by_id(intval($id));

$lot_content = include_template('lot.php', [
  'title' => $lot[0]['title'],
  'categories' => $lot[0]['category_name'],
  'description' => $lot[0]['description'],
  'price' => $lot[0]['start_price'],
  'bet_step' => $lot[0]['bet_step'],
  'image_url' => $lot[0]['image_url'],
  'finish_date' => $lot[0]['finish_date']
]);

$layout_content = include_template('layout.php', [
  'content' => $lot_content,
  'categories' => $categories,
  'is_auth' => $is_auth,
  'user_name' => $user_name,
  'title' => $lot[0]['title']
]);

print($layout_content);

?>