<?php
  function format_price(float $price_float): string
  {
      $price = ceil($price_float);
      return number_format($price, 0, "", " ") . '<b class="rub">₽</b>';
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
?>