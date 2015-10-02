<?php
/**
 * Created by PhpStorm.
 * User: musaatalay
 * Date: 27.04.2015
 * Time: 16:58
 */

namespace BasicJSONAPI;

abstract class BasicJSONApiSocket{

    protected $Socket;
    protected $Target;
    protected $Warn;
    protected $Errno;
    protected $Errstr;
    protected $QueryData;

    protected function open(Array $SocketData){

        $SocketData["timeout"] = ($SocketData["timeout"]) ? $SocketData["timeout"] : 30;

        $this->Target = $SocketData["target"];

        $Socket = fsockopen($SocketData["host"], $SocketData["port"], $errno, $errstr, $SocketData["timeout"]);

        if(!$Socket){

            $this->Warn = "Soket bağlantısı oluşturulurken hata oluştu!";
            $this->Errno = $errno;
            $this->Errstr = $errstr;

            throw new BasicJSONApiException(array(
                "code" => EXC_CODE_SOCKET_API_CONNECTION_FAIL,
                "message" => "Soket bağlantısı oluşturulurken hata oluştu! ::<br /> <strong>Hata Kodu => Mesajı ;</strong> <b style='color: blue;'>".$errno."</b> => <font style='color: red;'>".$errstr."</font>"
            ));

            return false;

        }

        $this->Socket = $Socket;

        $this->QueryData = array(
            "API" => true,
            "API_NAME" => BASIC_JSON_API_NAME,
            "API_KEY" => BASIC_JSON_API_KEY,
            "PRIVATE_NAME" => str_replace(array("http://", "www.", "/"), null, $_SERVER["SERVER_NAME"]),
            "PRIVATE_KEY" => BASIC_JSON_API_PRIVATE_KEY,
            "PUBLIC_KEY" => BASIC_JSON_API_PUBLIC_KEY
        );

        return true;

    }

    protected function pushData(Array $Data){

        $this->QueryData = array_merge($this->QueryData, $Data);

    }

    protected function pullData(){

        return http_build_query($this->QueryData);

    }

    protected function execute(){

        $Header = "POST /".BASIC_JSON_API_PATH."/".$this->Target." HTTP/1.0\r\n"
            ."Host: ".BASIC_JSON_API_HOST."\r\n"
            ."Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8\r\n"
            ."Accept-language: tr-TR,tr;q=0.8,en-US;q=0.6,en;q=0.4\r\n"
            ."Content-Length: ".strlen($this->pullData())."\r\n"
            ."Content-type: application/x-www-form-urlencoded\r\n"
            ."Cookie: ".$this->getCookiesContext()."\r\n"
            ."User-Agent: ".$_SERVER["HTTP_USER_AGENT"]
            ."Connection: Close\r\n\r\n";

        fwrite($this->Socket, $Header);
        fwrite($this->Socket, $this->pullData());

        $fGet = null;

        while (!feof($this->Socket)) {
            $fGet .= fgets($this->Socket, 128);
        }

        fclose($this->Socket);

        preg_match("/\{.*\}/i", $fGet, $SocketResponseContent);

        $ResponseContent = json_decode(@$SocketResponseContent[0]);

        return $ResponseContent;

    }

    protected function getCookiesContext(){
        return null;
        $r = null;
        foreach($_COOKIE as $i => $v){
            $r.=$i."=".$v."; ";
        }
        return rtrim($r, "; ");
    }

}