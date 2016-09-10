<?php
ini_set("display_errors", true); // режим ошибок в браузере (после разрааботки отключить)
date_default_timezone_set("Europe/Moscow"); //устанавливаем временную зону
define("DB_DSN", "mysql:host=localhost;dbname=cms"); // путь в бд
define("DB_USERNAME", "root"); // логин бд
define("DB_PASSWORD", ""); // пароль к бд
define("CLASS_PATH", "classes"); // путь к папке класса
define("TEMPLATE_PATH", "templates"); // путь к папке с шаблонами
define("HOMEPAGE_NUM_ARTICLES", 5); // максимум статей на главной
define("ADMIN_USERNAME", "admin"); // логин админа
define("ADMIN_PASSWORD", "password"); // пароль админа
require (CLASS_PATH . "/Article.php"); // класс статей

// функция обработке исключенных ситуаций
function handleException($exception) {
    echo "Пожалуйсто попробуйте пойзже";
    error_log($exception->getMessage());
}
set_exception_handler('handleException'); // запись ошибок в лог сервера
?>