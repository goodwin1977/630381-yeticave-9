<?php
define('ROOT_DIR', __DIR__);
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
        JOIN categories ON categories.id = lots.id
        ORDER BY lots.finish_date DESC;';
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
        JOIN categories ON categories.id = lots.id
        ORDER BY lots.finish_date DESC;';
    $get_lot = mysqli_query($link, $get_lot_sql);
    $lot = mysqli_fetch_all($get_lot, MYSQLI_ASSOC);
    return $lot;
  }
  return [];
}

function add_lot ($new_lot)
{
        $link = get_link();
        $sql = "INSERT INTO lots (creation_date, title, category_id, description, start_price, "
            . "bet_step, finish_date, image_url, owner_id) VALUES "
            . "(NOW(), ?, ?, ?, ?, ?, ?, ?, 2)";
        $stmt = db_get_prepare_stmt($link, $sql, [
            $new_lot['lot-name'],
            $new_lot['category'],
            $new_lot['message'],
            $new_lot['lot-rate'],
            $new_lot['lot-step'],
            $new_lot['lot-date'],
            $new_lot['lot-img'],
        ]);
        return insert($stmt);
}
/**
 * Проверяет заполнены ли необходимые поля
 * @param array $required
 * @return array
 */
function check_in_data (array $required)
{
    $errors = [];
    $current_array = [];
    foreach ($required as $field) {
        if (isset($_POST[$field]) && !empty(trim($_POST[$field]))) {
            $current_array[$field] = trim($_POST[$field]);
        } else {
            $errors[$field] = 'Это поле необходимо заполнить';
        }
    }
    return [$errors, $current_array];
}
function check_value_more_then($faild_name, $value, &$errors)
{
    if (!isset($errors[$faild_name])) {
        if (!(intval($_POST[$faild_name]) > $value)) {
            $errors[$faild_name] = "Значение должно быть больше {$value}";
        }
    }
}
function check_date(string $key, array &$errors, array &$lot)
{
    if (isset($errors[$key])) {
        return;
    }
    if (!is_date_valid($lot[$key])) {
        $errors[$key] = 'Пожалуйста, введите дату в формате ГГГГ-ММ-ДД';
        return;
    }
    $lot_date = strtotime($lot[$key]);
    $now = strtotime('now');
    $diff = floor(($lot_date - $now) / 86400);
    if ($diff < 0) {
        $errors[$key] = 'Минимальная продолжительность обьявления - 1 день!';
    }
}
function validate_img(string $key, array &$errors)
{
    if (isset($_FILES[$key]) && isset($_FILES[$key]['name']) && !empty($_FILES[$key]['name'])) {
        $tmp_name = $_FILES[$key]['tmp_name'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_type = finfo_file($finfo, $tmp_name);
        if ($file_type !== "image/png" AND $file_type !== "image/jpeg" AND $file_type !== "image/jpg") {
            $errors[$key] = 'Загрузите картинку в формате png, jpeg или jpg.';
        }
    } else {
        $errors[$key] = 'Это поле необходимо заполнить';
    }
}
/**
 * Проверка достоверности данных, для формы добавления лота
 * @param array $lot
 * @param array $errors
 */
function validate_form_add (array $lot, array &$errors)
{
    // Проверяем указал ли пользователь стоимость лота
    check_value_more_then('lot-rate', 0, $errors);
    //Проверяем указал ли пользователь минимальный шаг лота
    check_value_more_then('lot-step', 0, $errors);
    //Проверяем корректность введёной даты
    check_date('lot-date', $errors, $lot);
    //Validate image
    validate_img('lot-img', $errors);
}
/**
 * Меняет имя файла на набор уникальных символов
 * @param $key string ключ, имя поля с выбранным файлом
 * @param $file_dir string дирректория
 * @return string
 */
function change_filename($key, $file_dir)
{
    $tmp_name = $_FILES[$key]['tmp_name'];
    $path = $_FILES[$key]['name'];
    $filename = uniqid() . '.' . pathinfo($path, PATHINFO_EXTENSION);
    move_uploaded_file($tmp_name, ROOT_DIR . $file_dir . DIRECTORY_SEPARATOR . $filename);
    return $file_dir . DIRECTORY_SEPARATOR . $filename;
}
// Отображение формы Добавления ЛОТА
function show_form_add ($errors = []) {
    //Если переданы ошибки выводим их на экран
    if ($errors) {
        print 'Пожалуйста, исправьте ошибки в форме: <ul><li>';
        print implode('</li><li>', $errors);
        print '</li></ul>';
    }
}
/*
 *  Вставляем SQL запросы , возвращаем id
 */
function insert(mysqli_stmt $stmt): int
{
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_affected_rows($stmt);
    if ($result !== 0) {
        /*возвращаем id добавленной записи*/
        return mysqli_stmt_insert_id($stmt);
    }
    die('MYSQL error!');
}

//добавление нового пользователя
function add_user($new_user)
{
    $link = get_link();
    $sql = "INSERT INTO users (reg_date, email, name, password, contacts) VALUES "
        . "(NOW(), ?, ?, ?, ?)";
    $stmt = db_get_prepare_stmt($link, $sql, [
        $new_user['email'],
        $new_user['name'],
        $new_user ['password'],
        $new_user['message'],
    ]);
    return insert($stmt);
}

?>