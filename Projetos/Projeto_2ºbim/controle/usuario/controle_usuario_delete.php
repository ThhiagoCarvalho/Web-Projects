<?php
use Firebase\JWT\MeuTokenJWT;

require_once ("modelo/Banco.php");
require_once ("modelo/MeuTokenJWT.php");
require_once("modelo/Usuario.php");

$headers = apache_request_headers();

$objResposta = new stdClass();
$objToken = new MeuTokenJWT();


try{
    if  ($objToken->validarToken($headers['Authorization']) == true){

        $objUsuario = new Usuario();
        $objUsuario->setIdUsuario($parametro_idusuario);


        if ($objUsuario->delete()==true){
            header('HTTP/1.1 204');
        }else{
            header('HTTP/1.1 200');
            header('content-type : application/json');
        }
    }   
}catch (Exception $e){
    $objResposta->status = false;
    $objResposta->error =$e->getMessage();
    die(json_encode($objResposta));
}

echo json_encode($objResposta);
