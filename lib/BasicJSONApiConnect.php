<?php
/**
 * Created by PhpStorm.
 * User: musaatalay
 * Date: 27.04.2015
 * Time: 15:03
 */

namespace BasicJSONAPI;

class BasicJSONApiSession{

    public $SESSION;

    public function __construct(\stdClass $Session){

        $this->SESSION = $Session->session;

    }

}

class BasicJSONApiConnect extends BasicJSONApiSocket{

    private $API_OPTIONS = array();

    public function __construct(Array $OPTIONS = null){

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

    public function register(){

        $this->open(array(
            "host" => BASIC_JSON_API_HOST,
            "port" => BASIC_JSON_API_PORT,
            "target" => "register",
            "timeout" => 60
        ));

        $this->pushData($this->API_OPTIONS);
        //$this->pushData(array("API_SESSION_KEY" => @$_SESSION["BASIC_JSON_API_SESSION"][$this->API_OPTIONS["API_NAME"]]));

        $Exec = $this->execute();

        if($Exec->status===false){

            throw new BasicJSONApiException(array(
                "code" => EXC_CODE_REGISTER_FAIL,
                "message" => @$Exec->text
            ));

            return false;

        }

        @$_SESSION["BASIC_JSON_API_SESSION"] = array(
            $this->API_OPTIONS["API_NAME"] => $Exec->session->key
        );

        return new BasicJSONApiSession($Exec);

    }

    public function isRegistered(){

        $this->open(array(
            "host" => BASIC_JSON_API_HOST,
            "port" => BASIC_JSON_API_PORT,
            "target" => "is_registered", # or isRegistered
            "timeout" => 60
        ));

        $this->pushData($this->API_OPTIONS);
        $this->pushData(array("API_SESSION_KEY" => @$_SESSION["BASIC_JSON_API_SESSION"][$this->API_OPTIONS["API_NAME"]]));

        $Exec = $this->execute();

        if($Exec->status===false){

            throw new BasicJSONApiException(array(
                "code" => EXC_CODE_NOT_REGISTERED,
                "message" => @$Exec->text
            ));

            return false;

        }

        return new BasicJSONApiSession($Exec);

    }

}