<?php
$is_auth = rand(0, 1);
$user_name = 'Максим'; // укажите здесь ваше имя

// Массив категорий
// $categories = ['Доски и лыжи', 'Крепления', 'Ботинки', 'Одежда', 'Инструменты', 'Разное'];

// Массив объявлений

// $lots = [
//     [
//         'lot_title' => '2014 Rossignol District Snowboard',
//         'cat' => 'Доски и лыжи',
//         'price' => '10999',
//         'url' => 'img/lot-1.jpg'
//     ],
//     [
//         'lot_title' => 'DC Ply Mens 2016/2017 Snowboard',
//         'cat' => 'Доски и лыжи',
//         'price' => '159999',
//         'url' => 'img/lot-2.jpg'
//     ],
//     [
//         'lot_title' => 'Крепления Union Contact Pro 2015 года размер L/XL',
//         'cat' => 'Крепления',
//         'price' => '8000',
//         'url' => 'img/lot-3.jpg'
//     ],
//     [
//         'lot_title' => 'Ботинки для сноуборда DC Mutiny Charoca',
//         'cat' => 'Ботинки',
//         'price' => '10999',
//         'url' => 'img/lot-4.jpg'
//     ],
//     [
//         'lot_title' => 'Куртка для сноуборда DC Mutiny Charocal',
//         'cat' => 'Одежда',
//         'price' => '7500',
//         'url' => 'img/lot-5.jpg'
//     ],
//     [
//         'lot_title' => 'Маска Oakley Canopy',
//         'cat' => 'Разное',
//         'price' => '5400',
//         'url' => 'img/lot-6.jpg'
//     ]
// ];

function format_price(float $price_float): string
{
    $price = ceil($price_float);
    return number_format($price, 0, "", " ") . ' ₽';
} 
// вычисление времени до полуночи
function get_time_in_hours_minutes(string $time) : array
{
    $diff_time = strtotime($time) - time();
    if ($diff_time <= 0) {
        return [0, 0];
    }
        return [floor($diff_time / 3600), floor($diff_time % 3600 / 60)];
}

// форматируе часы и минуты
function get_time_to_lot(string $lot_time) : string
{
    list($hours, $minutes) = get_time_in_hours_minutes($lot_time);
    return sprintf("%02d:%02d", $hours, $minutes);
}
// проверка на последний час
function is_last_hour(string $lot_time) : bool
{
    list($hours, $minutes) = get_time_in_hours_minutes($lot_time);
    return $hours < 1;
}

require_once('helpers.php');

$link = mysqli_connect('localhost', 'root', '', 'yeticave');

if ($link == false) {
    print("Ошибка: Невозможно подключиться к MySQL " . mysqli_connect_error());
} else {

    mysqli_set_charset($link, "utf8");

    $get_categories_sql = 'SELECT * FROM categories';
    $get_categories = mysqli_query($link, $get_categories_sql);
    $categories = mysqli_fetch_all($get_categories, MYSQLI_ASSOC);

    $get_lots_sql =
        'SELECT
            lots.id,
            lots.title as lot_title,
            lots.start_price,
            lots.image_url,
            lots.finish_date,
            categories.name as category_name
        FROM lots
        JOIN categories ON categories.id = lots.id
        ORDER BY lots.finish_date DESC;';
    $get_lots = mysqli_query($link, $get_lots_sql);
    $lots = mysqli_fetch_all($get_lots, MYSQLI_ASSOC);



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
}
?>