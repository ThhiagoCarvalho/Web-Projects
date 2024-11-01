<?php
use Firebase\JWT\MeuTokenJWT;

require_once("modelo/Banco.php");
require_once("modelo/Categoria.php");
require_once("modelo/MeuTokenJWT.php");


$objToken = new MeuTokenJWT();
$objResposta = new stdClass();
$headers = apache_request_headers();
try{
    if ($objToken->validarToken($headers['Authorization']) == true){

        $objCategoria = new Categoria();
        $objCategoria->setNomeCategoria($frase);  
        if ($objCategoria->readById()== true){
            $objResposta->status = true;
            $objResposta->dados = $objCategoria->readById();
        }else{
            $objResposta->codigo = 1;
            $objResposta-> status = false;
            $objResposta->msg = "Erro ao processar a leitura!";
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