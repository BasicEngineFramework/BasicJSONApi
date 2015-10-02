<?php
/**
 * Created by PhpStorm.
 * User: Musa ATALAY
 * Date: 3.09.2015
 * Time: 15:09
 */

require_once "conf.inc"; # Including API´S required configurations (required for all)
require_once "lib/BasicJSONApiException.php"; # Including Exception Library (required for all)
require_once "lib/BasicJSONApiSocket.php"; # Including Socket Library (required for all)
require_once "lib/BasicJSONApiConnect.php"; # Including Connection Library (required for all)
require_once "lib/BasicJSONApiProcessor.php"; # Including Connection Library (required for processors)

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
         * @ If push return false then it throws an exception instance of BasicJSONApiException class
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
     * @ update(Array: $UpdateData, Array: $QueryData) works for update a reservation in our database,
     * @ It takes two parameters as Array data,
     *      the first parameter contains new values of reservation,
     *      the second parameter contains related informations of reservation,
     *      @ You should be careful of you set data and these data´s index name in the parameter Array,
     *      because all column indexes in parameter must to match to column names
     *      in reference table wich we gave you for use it as a reference,
     *      example : array("id" => 10000) defines id column´s value to 10000
     *
     * @Important: You can´t update id and related api key of reservations,
     *      if you try that, you will get an error as response
     *
     * @@ Russian
     * @ update(Array: $UpdateData, Array: $QueryData) работает для обновления бронирования в нашей базе данных,
     * @Она принимает два параметра, как Array data,
     *      Первый параметр содержит новые значения бронирования,
          * Второй параметр содержит соответствующую информацию резервирования,
     * @Вы должны быть осторожны установить данные и эти имена данные индекс в параметре Array,
     *      потому что все индексы столбцов в параметре должен соответствовать именам столбцов,
          * В справочной таблице которым мы дали вам для использования его в качестве ссылки,
     *      пример : array("id" => 10000) Опредиляет идентификационный номер значение колонки 10000
     *
     * @Важно: вы не можете обновить идентификатор и соответствующей клавиши апи бронирования,
          * Если вы попытаетесь, то вы получите ошибку, как ответ
     */
    // @ Using way 1
    // @ Использование пути 1
    #$Update = $APIProcessor->table("basic_json_api_test")->update(array("context" => "ATALAY"), array("id" => 7));

    // @ Using way 2
    // @ Использование пути 2
    /*$Update = $APIProcessor->table("basic_json_api_test")->update(array("context" => "Musa"), array(
        "query" => array("id" => 7)
    ));*/

    // @ Using way 3
    // @ Использование пути 3
    $Update = $APIProcessor->update(array("context" => "Musa"), array(
        "table" => "basic_json_api_test",
        "query" => array("id" => 7)
    ));

    var_dump($Update);


    /**
     * @@ English
     * @ If update return false then it throws an exception instance of BasicJSONApiException class
     *      and then it returns false
     *      you can use the exception datas if you want to resolve problems or you can report exception datas to us(recommended)
     *
     * @@ Russian
     * @  update Если возвращение false, то он бросает экземпляр исключением класса BasicJSONApiException
     *      А затем возвращает false
     *      Вы можете использовать ДАННЫЕ исключение, если вы хотите, чтобы решить проблемы, или вы можете сообщить об исключениях ДАННЫХ к нам (рекомендуется)
     */
}catch (\BasicJSONAPI\BasicJSONApiException $Exception){

    exit($Exception->getCode()." : ".$Exception->getMessage());

}