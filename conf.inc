<?php
/**
 * Created by PhpStorm.
 * User: musaatalay
 * Date: 27.04.2015
 * Time: 14:50
 */

ob_start();
session_start();

# private key group name, it can be related with more than one private keys
# Секретный ключ имя группы, оно может быть связано с более чем одним из закрытых ключей
const BASIC_JSON_API_NAME = "";

# private key group key, it can be related with more than one private keys
# Секретный ключ имя группы, оно может быть связано с более чем одним из закрытых ключей
const BASIC_JSON_API_KEY = "";

# Permissions NOT:Car Listing, Reservation Listing, Reservation Recording and Editing, General Permissions Key(Without Reservation Deleting Permission).
# Разрешения нет: авто Объявление, Бронирование Листинг, Бронирование Запись и редактирование, генеральные права Ключей (без бронирования Удаление разрешения).
const BASIC_JSON_API_PUBLIC_KEY = "";

# related to domain name without http://, www. and / (fastrentacar.nl) and to BASIC_JSON_API_NAME and BASIC_JSON_API_KEY map
# связанные с именем без домена  http://, www. and / (fastrentacar.nl) и BASIC_JSON_API_NAME и BASIC_JSON_API_KEY карта
const BASIC_JSON_API_PRIVATE_KEY = "";

const BASIC_JSON_API_HOST = "www.gointapi.com";
const BASIC_JSON_API_PORT = 80;

# Api version v1.1
# Api версия v1.1
const BASIC_JSON_API_PATH = "/bja-v1.1";

if(!$_SESSION["BASIC_JSON_API_SESSION"][BASIC_JSON_API_NAME]){

    $_SESSION["BASIC_JSON_API_SESSION"][BASIC_JSON_API_NAME] = null;

}