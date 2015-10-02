<?php
/**
 * Created by PhpStorm.
 * User: Musa ATALAY
 * Date: 3.09.2015
 * Time: 12:48
 */

namespace BasicJSONAPI;


class BasicJSONApiProcessor extends BasicJSONApiSocket{

    private $API_SESSION;
    private $API_OPTIONS = array();
    private $TABLE;

    public function __construct(BasicJSONApiSession $Session, Array $OPTIONS = null){

        $this->API_SESSION = $Session;

        $this->API_OPTIONS = ($OPTIONS)
            ? $OPTIONS
            : array(
                "API_NAME" => BASIC_JSON_API_NAME,
                "API_KEY" => BASIC_JSON_API_KEY,
                "PRIVATE_NAME" => str_replace(array("http://", "www.", "/"), null, $_SERVER["SERVER_NAME"]),
                "PRIVATE_KEY" => BASIC_JSON_API_PRIVATE_KEY,
                "PUBLIC_KEY" => BASIC_JSON_API_PUBLIC_KEY
            );

    }

    /**
     * @throws BasicJSONApiException, returns an object tree instance of stdClass() with reservations´s properties,
     * if it fails then it will throw an exception instance of BasicJSONApiException with error code and
     * some string returned by webservice to inform about problem
     * and then it returns false
     */
    public function pull(Array $QueryData){

        $Query = array();

        if(isset($QueryData["table"])&&isset($QueryData["query"])){

            $this->TABLE = $QueryData["table"];

            $Query = $QueryData["query"];

        }

        if(isset($QueryData["query"])){

            $Query = $QueryData["query"];

        }else{

            $Query = $QueryData;

        }

        try{

            $this->open(array(
                "host" => BASIC_JSON_API_HOST,
                "port" => BASIC_JSON_API_PORT,
                "target" => "pull",
                "timeout" => 60
            ));

            $this->pushData($this->API_OPTIONS);
            $this->pushData(array("API_SESSION_KEY" => $this->API_SESSION->SESSION->key));
            $this->pushData(array("table" => $this->TABLE));
            $this->pushData(array("query" => $Query));

            $Exec = $this->execute();

            if(!$Exec->status){

                throw new BasicJSONApiException(array(
                    "code" => EXC_CODE_RESERVATIONS_PULL_FAIL,
                    "message" => @$Exec->text
                ));

                return false;

            }

        }catch (BasicJSONApiException $Exception){

            throw new BasicJSONApiException(array(
                "code" => $Exception->getCode(),
                "message" => $Exception->getMessage()
            ));

        }

        return $Exec;

    }

    /**
     * @throws BasicJSONApiException, returns an object tree instance of stdClass() with new reservation´s ID,
     * if it fails then it will throw an exception instance of BasicJSONApiException with error code and
     * some string returned by webservice to inform about problem
     * and then it returns false
     */
    public function push(Array $QueryData){

        $Query = array();

        if(isset($QueryData["table"])&&isset($QueryData["query"])){

            $this->TABLE = $QueryData["table"];

            $Query = $QueryData["query"];

        }

        if(isset($QueryData["query"])){

            $Query = $QueryData["query"];

        }else{

            $Query = $QueryData;

        }

        try{

            $this->open(array(
                "host" => BASIC_JSON_API_HOST,
                "port" => BASIC_JSON_API_PORT,
                "target" => "push",
                "timeout" => 60
            ));

            $this->pushData($this->API_OPTIONS);
            $this->pushData(array("API_SESSION_KEY" => $this->API_SESSION->SESSION->key));
            $this->pushData(array("table" => $this->TABLE));
            $this->pushData(array("query" => $Query));

            $Exec = $this->execute();

            if(!$Exec->status){

                throw new BasicJSONApiException(array(
                    "code" => EXC_CODE_RESERVATIONS_PUSH_FAIL,
                    "message" => @$Exec->text
                ));

                return false;

            }

        }catch (BasicJSONApiException $Exception){

            throw new BasicJSONApiException(array(
                "code" => $Exception->getCode(),
                "message" => $Exception->getMessage()
            ));

        }

        return $Exec;

    }

    /**
     * @throws BasicJSONApiException, returns an object tree instance of stdClass(),
     * if it fails then it will throw an exception instance of BasicJSONApiException with error code and
     * some string returned by webservice to inform about problem
     * and then it returns false
     */
    public function update(Array $UpdateData, Array $QueryData){

        $Query = array();

        if(isset($QueryData["table"])&&isset($QueryData["query"])){

            $this->TABLE = $QueryData["table"];

            $Query = $QueryData["query"];

        }

        if(isset($QueryData["query"])){

            $Query = $QueryData["query"];

        }else{

            $Query = $QueryData;

        }

        try{

            $this->open(array(
                "host" => BASIC_JSON_API_HOST,
                "port" => BASIC_JSON_API_PORT,
                "target" => "update",
                "timeout" => 60
            ));

            $this->pushData($this->API_OPTIONS);
            $this->pushData(array("API_SESSION_KEY" => $this->API_SESSION->SESSION->key));
            $this->pushData(array("table" => $this->TABLE));
            $this->pushData(array("query" => array("update" => $UpdateData, "where" => $Query)));

            $Exec = $this->execute();

            if(!$Exec->status){

                throw new BasicJSONApiException(array(
                    "code" => EXC_CODE_RESERVATIONS_UPDATE_FAIL,
                    "message" => @$Exec->text
                ));

                return false;

            }

        }catch (BasicJSONApiException $Exception){

            throw new BasicJSONApiException(array(
                "code" => $Exception->getCode(),
                "message" => $Exception->getMessage()
            ));

        }

        return $Exec;

    }

    /**
     * @throws BasicJSONApiException, returns an object tree instance of stdClass() with reservations´s properties,
     * if it fails then it will throw an exception instance of BasicJSONApiException with error code and
     * some string returned by webservice to inform about problem
     * and then it returns false
     */
    public function delete(Array $QueryData){

        try{

            $this->open(array(
                "host" => BASIC_JSON_API_HOST,
                "port" => BASIC_JSON_API_PORT,
                "target" => "delete",
                "timeout" => 60
            ));

            $this->pushData($this->API_OPTIONS);
            $this->pushData(array("API_SESSION_KEY" => $this->API_SESSION->SESSION->key));
            $this->pushData(array("query" => $QueryData));

            $Exec = $this->execute();

            if(!$Exec->status){

                throw new BasicJSONApiException(array(
                    "code" => EXC_CODE_RESERVATIONS_PULL_FAIL,
                    "message" => @$Exec->text
                ));

                return false;

            }

        }catch (BasicJSONApiException $Exception){

            throw new BasicJSONApiException(array(
                "code" => $Exception->getCode(),
                "message" => $Exception->getMessage()
            ));

        }

        return $Exec;

    }

    public function table($Table){

        $this->TABLE = $Table;

        return $this;

    }

}