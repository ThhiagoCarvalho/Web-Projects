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

        $objResposta->status = true;
        $objResposta->msg = 'executado com sucesso!';
        $objResposta->dados = $objUsuario->ReadById();
    }else{
        $objResposta->status = false;
        $objResposta->msg = 'token invalido';
    }
}catch (Exception $e){
    $objResposta->status = false;
    $objResposta->erro  = $e->getMessage();
    die(json_encode($objResposta));


}
echo json_encode($objResposta);

header("HTTP/1.1 200");
// Define o tipo de conteúdo da resposta como JSON
header("Content-Type: application/json");