<?php
$is_auth = rand(0, 1);
$user_name = 'Максим'; // укажите здесь ваше имя

require_once('helpers.php');
require_once('functions.php');
require_once('data_function.php');


//get_link();
$categories = get_categories();
$lots = get_all_lots();

$page_content = include_template('index.php', [
    'lots' => $lots,
    'categories' => $categories
    ]);
$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'title' => 'YetiCave - Главная страница'
]);

print($layout_content);
?>