<?php
use Firebase\JWT\MeuTokenJWT;

require_once("modelo/Banco.php");
require_once("modelo/Categoria.php");
require_once("modelo/MeuTokenJWT.php");

$objResposta = new stdClass();
$objToken = new MeuTokenJWT();
$headers = apache_request_headers();

try{
    if ($objToken->validarToken($headers['Authorization']) == true){
    $objCategoria = new Categoria();

    if ($objCategoria->readALL()== true){
            $objResposta->status = true;
            $objResposta->categoria = $objCategoria->readALL() ;
        }else{
            $objResposta-> status = false;
            $objResposta->msg = "Erro ao ler!";
        }
    }else{
        $objResposta-> status = false;
        $objResposta->msg = "Token invalido";
    }

}catch (Exception $e){
    $objResposta->status = false;
    $objResposta->error = $e->getMessage();
    die(json_encode($objResposta));

}

if( $objResposta->status == true) {
    header('HTTP/1.1 201');

}else {
    header('HTTP/1.1 200');

}
echo json_encode($objResposta);