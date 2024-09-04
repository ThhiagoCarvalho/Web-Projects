<?php
use Firebase\JWT\MeuTokenJWT;

require_once("modelo/Banco.php");
require_once("modelo/MeuTokenJWT.php");
require_once("modelo/Opcao.php");


$objResposta = new stdClass();
$objToken = new MeuTokenJWT();
$headers = apache_request_headers();

try{
    if ($objToken->validarToken($headers['Authorization']) == true){
        $objOpcao = new Opcao();
        $objOpcao->setIdOpcao($parametro_idOpcao);
        if ($objOpcao->delete()==true){
            header('HTTP/1.1 204');
        }else{
            header('HTTP/1.1 200');
            header('content-type : application/json');
        }
    }else{
        $objResposta-> status = false;
        $objResposta->msg = "Token invalido";
    }
}catch (Exception $e ){
    $objResposta->status = false;
    $objResposta->error = $e->getMessage();
    die(json_encode($objResposta));

}


echo json_encode($objResposta);