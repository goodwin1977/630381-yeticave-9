<?php

function get_link()
{
  $link = mysqli_connect('localhost', 'root', '', 'yeticave');
  if ($link == false) {
    print("Ошибка: Невозможно подключиться к MySQL " . mysqli_connect_error());
    die();
    } 
      mysqli_set_charset($link, "utf8");
      return $link;
}

function get_categories(): array
{
  $link = get_link();
  $get_categories_sql = 'SELECT * FROM categories';
  $get_categories = mysqli_query($link, $get_categories_sql);
  $categories = mysqli_fetch_all($get_categories, MYSQLI_ASSOC);
  return $categories;
}

function get_all_lots(): array
{
    $link = get_link();
    $get_lots_sql =
        'SELECT
            lots.id,
            lots.title as lot_title,
            lots.description,
            lots.start_price,
            lots.image_url,
            lots.finish_date,
            categories.name as category_name
        FROM lots
        JOIN categories ON lots.category_id = categories.id';
    $get_lots = mysqli_query($link, $get_lots_sql);
    $lots = mysqli_fetch_all($get_lots, MYSQLI_ASSOC);
    return $lots;
  
}

// функция вызова лота по id
function get_lot_by_id(int $id): array
{
  if (isset($id))
  {
    $link = get_link();
    $get_lot_sql =
        'SELECT
            lots.id,
            lots.title,
            lots.description,
            lots.start_price,
            lots.image_url,
            lots.finish_date,
            categories.name as category_name
        FROM lots
        JOIN categories ON categories.id = lots.id WHERE lots.id ='. $id;
    $get_lot = mysqli_query($link, $get_lot_sql);
    $lot = mysqli_fetch_all($get_lot, MYSQLI_ASSOC);
    return $lot;
  }
  return [];
  
}

?>