<?php
    # Запуск сессии
    session_start();
    ini_set("display_errors", 'on');
    # Служит для отладки, показывает все ошибки, предупреждения и т.д.
    error_reporting(E_ALL);
    # Подключение файлов с функциями
    include_once("functions.php");
    # В этом массиве далее мы будем хранить сообщения системы, т.е. ошибки.
    $messages=array();
    # Данные для подключения к БД
    $dbhost="localhost";
    $dbuser="root";
    $dbpass="gifted";
    $dbname="first_test";
    # Вызываем функцию подключения к БД
    connectToDB();
    date_default_timezone_set('Europe/Kiev');
