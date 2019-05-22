<?php
$is_auth = rand(0, 1);
$user_name = 'Максим'; // укажите здесь ваше имя

require_once('helpers.php');
require_once('functions.php');
require_once('data_function.php');


$categories = get_categories();

$lot = [];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    list($errors, $lot) = check_in_data(['lot-name', 'category', 'message', 'lot-rate', 'lot-step', 'lot-date']);
    validate_form_add($lot, $errors);
    if (!count($errors)) {
        $lot['lot-img'] = change_filename('lot-img', DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'lots');
        $lot_id = add_lot($lot);
        header("Location: /lot.php?id={$lot_id}");
    }
}
$content = include_template('add.php', [
    'categories' => $categories,
    'lot' => $lot,
    'errors' => $errors,
]);

$layout_content = include_template('layout.php', [
  'content' => $content,
  'categories' => $categories,
  'is_auth' => $is_auth,
  'user_name' => $user_name,
  'title' => $lot_title
]);

print($layout_content);

?>
