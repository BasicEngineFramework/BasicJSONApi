<?php
/**
 * Created by PhpStorm.
 * User: Musa ATALAY
 * Date: 3.09.2015
 * Time: 14:34
 */

require_once "conf.inc"; # Including API´S required configurations (required for all)
require_once "lib/BasicJSONApiExceptionCodes.inc"; # Including Exception Codes (required for all)
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
         *-
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
     * @ pull() returns all datas as a tree of stdClass() instances which you filtered in our database with your query parameter,
     * @ If it fail becasue of any reason then it will throw an exception instance of BasicJSONApiException before return false,
     * @ If you want to use exception datas, you can use this method in a try-catch scope
     * Example Using:
     *
     *  try{
     *
     *      $Pull = $APIProcessor->table("basic_json_api_test")->pull(array(
     *          "query" => array("id" => 7)
     *      ));
     *
     *  }catch(\BasicJSONAPI\BasicJSONApiException $Exception){
     *
     *      echo $Exception->getCode()." : ".$Exception->getMessage();
     *
     *  }
     *
     * @@ Russian
     * @ pull() возвращает все ДАННЫЕ в виде дерева stdClass() случаи, которые отфильтрованные в нашей базе с параметром запроса,
     * @ Если она не сделается по любой причине, то он будет бросать экземпляр исключением BasicJSONApiException перед возвращением false,
     * @ Если вы хотите использовать исключения ДАННЫХ, вы можете использовать этот метод в Try-Catch сфере
     * Пример использования:
     *
     *  try{
     *
     *      $Pull = $APIProcessor->table("basic_json_api_test")->pull(array(
     *          "query" => array("id" => 7)
     *      ));
     *
     *  }catch(\BasicJSONAPI\BasicJSONApiException $Exception){
     *
     *      echo $Exception->getCode()." : ".$Exception->getMessage();
     *
     *  }
     */
    $Pull = $APIProcessor->table("basic_json_api_test")->pull(array(
        "query" => array("id" => 7)
    ));

    var_dump($Pull);


    /**
     * @@ English
     * @ If pull return false then it throws an exception instance of BasicJSONApiException class
     *      and then it returns false
     *      you can use the exception datas if you want to resolve problems or you can report exception datas to us(recommended)
     *
     * @@ Russian
     * @ pull Если возвращение false, то он бросает экземпляр исключением класса BasicJSONApiException
     *      А затем возвращает false
     *      Вы можете использовать ДАННЫЕ исключение, если вы хотите, чтобы решить проблемы, или вы можете сообщить об исключениях ДАННЫХ к нам (рекомендуется)
     */
}catch (\BasicJSONAPI\BasicJSONApiException $Exception){

    exit($Exception->getCode()." : ".$Exception->getMessage());

}