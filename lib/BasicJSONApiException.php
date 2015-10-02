<?php
/**
 * Created by PhpStorm.
 * User: musaatalay
 * Date: 27.04.2015
 * Time: 18:05
 */

namespace BasicJSONAPI;

require_once "lib/BasicJSONApiExceptionCodes.inc";
#require_once "lib/ApiExceptions.inc";

class BasicJSONApiException extends \Exception{

    private $function, $class, $object, $method;

    public function __construct(Array $ExceptionData){

        $Debug = debug_backtrace();
        $Debug = $Debug[count($Debug)-1];
        $this->code = @$ExceptionData["code"];
        $this->file = (@$ExceptionData["file"]) ? @$ExceptionData["file"] : $Debug["file"];
        $this->line = (@$ExceptionData["line"]) ? @$ExceptionData["line"] : $Debug["line"];
        $this->function = (@$ExceptionData["function"]) ? @$ExceptionData["function"] : $Debug["function"];
        $this->class = (@$ExceptionData["class"]) ? @$ExceptionData["class"] : $Debug["class"];
        $this->method = (@$ExceptionData["method"]) ? @$ExceptionData["method"] : $Debug["class"]."::".$Debug["function"]."()";
        $this->object = (@$ExceptionData["object"]) ? @$ExceptionData["object"] : $Debug["object"];
        $this->message = @$ExceptionData["message"];

    }

    public function getFunction(){

        return $this->function;

    }

    public function getClass(){

        return $this->class;

    }

    public function getMethod(){

        return $this->method;

    }

    public function getObject(){

        return $this->object;

    }

}