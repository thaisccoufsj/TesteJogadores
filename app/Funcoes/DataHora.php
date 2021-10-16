<?php

    function DataUS2BR($data){
        $vData = explode("-",$data);
        if(count($vData) != 3) return $data;
        return $vData[2] . "/" . $vData[1] . "/" . $vData[0];
    }

    function DataBR2US($data){
        $vData = explode("/",$data);
        if(count($vData) != 3) return $data;
        return $vData[2] . "-" . $vData[1] . "-" . $vData[0];
    }

    function validarData($data){
        $vData = explode("-",$data);
        if(count($vData) != 3) return false;
        return checkdate($vData[1],$vData[2],$vData[0]);
    }

    function validarHora($hora){
        return preg_match("/^(?:2[0-3]|[01][0-9]):[0-5][0-9]:[0-5][0-9]$/", $hora);
    }

?>