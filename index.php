<?php
$is_auth = rand(0, 1);
$user_name = 'Максим'; // укажите здесь ваше имя

// Массив категорий
$categories = ['Доски и лыжи', 'Крепления', 'Ботинки', 'Одежда', 'Инструменты', 'Разное'];

// Массив объявлений

$lots = [
    [
        'lot_title' => '2014 Rossignol District Snowboard',
        'cat' => 'Доски и лыжи',
        'price' => '10999',
        'url' => 'img/lot-1.jpg'
    ],
    [
        'lot_title' => 'DC Ply Mens 2016/2017 Snowboard',
        'cat' => 'Доски и лыжи',
        'price' => '159999',
        'url' => 'img/lot-2.jpg'
    ],
    [
        'lot_title' => 'Крепления Union Contact Pro 2015 года размер L/XL',
        'cat' => 'Крепления',
        'price' => '8000',
        'url' => 'img/lot-3.jpg'
    ],
    [
        'lot_title' => 'Ботинки для сноуборда DC Mutiny Charoca',
        'cat' => 'Ботинки',
        'price' => '10999',
        'url' => 'img/lot-4.jpg'
    ],
    [
        'lot_title' => 'Куртка для сноуборда DC Mutiny Charocal',
        'cat' => 'Одежда',
        'price' => '7500',
        'url' => 'img/lot-5.jpg'
    ],
    [
        'lot_title' => 'Маска Oakley Canopy',
        'cat' => 'Разное',
        'price' => '5400',
        'url' => 'img/lot-6.jpg'
    ]
];

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