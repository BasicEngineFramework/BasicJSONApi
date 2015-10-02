<?php
/**
 * Created by PhpStorm.
 * User: Musa ATALAY
 * Date: 3.09.2015
 * Time: 12:57
 */

require_once "conf.inc"; # Including API´S required configurations (required for all)
require_once "lib/BasicJSONApiExceptionCodes.inc"; # Including Exception Codes (required for all)
require_once "lib/BasicJSONApiException.php"; # Including Exception Library (required for all)
require_once "lib/BasicJSONApiSocket.php"; # Including Socket Library (required for all)
require_once "lib/BasicJSONApiConnect.php"; # Including Connection Library (required for all)
require_once "lib/BasicJSONApiProcessor.php"; # Including Processor Library (required for processors)

error_reporting(E_ALL);

/**
 * @ Api connection and session registering
 * @ Api Подключение и регистрация сессии
 */
$APIConnection = new BasicJSONAPI\BasicJSONApiConnect;

$ApiConnection = false;

try{

    /**
     * @@ English
     * @ Controlling session register created first
     *      if it´s true then it returns an object instance of BasicJSONApiSession with some properties,
     *      which one you will use it with any api process after successfully connected
     *      but if it´s false then BasicJSONApiConnect throws an object instance of BasicJSONApiException
     *      with error code and some string returned by webservice to inform about problem
     *      and then it returns false
     *
     * @@ Russian
     * @ Управление регистром сессия создана первой
     *      Если Вы можете сделать то возвращает экземпляр объекта BasicJSONApiSession с некоторыми свойствами,
     *      Какой из них вы будете использовать его с любым процессом апи после успешного подключения
     *      Вы можете сделать, но если false, то BasicJSONApiConnect бросает экземпляр объекта BasicJSONApiException
     *      С кодом ошибки и некоторые строки, возвращаемой веб-сервиса, чтобы сообщить о проблеме
     *      А затем возвращает false
     */
    $ApiConnection = $APIConnection->isRegistered();


}catch (BasicJSONAPI\BasicJSONApiException $Exception){

    try{

        # @ Registering a clean session for api connection
        # @ Регистрация чистой сессии для апи связи
        $ApiConnection = $APIConnection->register();

        $_SESSION["BASIC_JSON_API_SESSION"][BASIC_JSON_API_NAME] = $ApiConnection->SESSION->key;

    }
        /**
         * @@ English
         * @ If registering session return false then it throws an exception instance of BasicJSONApiException class
         *      and then it returns false
         *      you can use the exception datas if you want to resolve problems or you can report exception datas to us(recommended)
         *
         * @@ Russian
         * @  регистрация сессии Если возвращение false, то он бросает экземпляр исключением класса BasicJSONApiException
         *      А затем возвращает false
         *      Вы можете использовать ДАННЫЕ исключение, если вы хотите, чтобы решить проблемы, или вы можете сообщить об исключениях ДАННЫХ к нам (рекомендуется)
         */
    catch (BasicJSONAPI\BasicJSONApiException $Exception){

        exit($Exception->getCode()." : ".$Exception->getMessage());

    }

}

/**
 * @ Using api processor
 * @ С помощью программного интерфейса процессора
 */
$APIProcessor = new BasicJSONAPI\BasicJSONApiProcessor($ApiConnection);

try{

    /**
     * @@ English
     * @ push(Array: $QueryData) works for send data to our webservice,
     * @ It takes just one parameter as an Array data, this parameter contains informations of new reservations,
     *      you should be careful of you set data and these data´s index name in the parameter Array,
     *      because all column indexes in parameter must to match to column names
     *      in reference table wich we gave you for use it as a reference,
     *      example : array("id" => 10000) defines id column´s value to 10000
     *
     * @@ Russian
     * @ push(Array: $QueryData) работает для отправки данных нашим вебсервисом,
     * @ Это займет всего один параметр в качестве массива данных, этот параметр содержит информацию о новых заказах,
     *      Вы должны быть осторожны установить эти имена данные индексы данные и в параметре массива,
     *      Потому, что все индексы столбцов в параметре должен соответствовать именам столбцов,
     *      В справочной таблице которым мы даем вам для использования его в качестве ссылки,
     *      пример : array("id" => 10000) Опредиляет идентификационный номер значение колонки 10000
     */
    $Push = $APIProcessor->push(array(
        "table" => "basic_json_api_test",
        "query" => array("context" => "Hello World!")
    ));

    var_dump($Push);


    /**
     * @@ English
     * @ If push return false then it throws an exception instance of BasicJSONApiException class
     *      and then it returns false
     *      you can use the exception datas if you want to resolve problems or you can report exception datas to us(recommended)
     *
     * @@ Russian
     * @  push Если возвращение false, то он бросает экземпляр исключением класса BasicJSONApiException
     *      А затем возвращает false
     *      Вы можете использовать ДАННЫЕ исключение, если вы хотите, чтобы решить проблемы, или вы можете сообщить об исключениях ДАННЫХ к нам (рекомендуется)
     */
}catch (\BasicJSONAPI\BasicJSONApiException $Exception){

    exit($Exception->getCode()." : ".$Exception->getMessage());

}