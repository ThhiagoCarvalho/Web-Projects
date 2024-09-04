<?php
use Firebase\JWT\MeuTokenJWT;

require_once ("modelo/Banco.php");
require_once ("modelo/MeuTokenJWT.php");
require_once("modelo/Usuario.php");

$headers = apache_request_headers();
$objResposta = new stdClass();
$objToken = new MeuTokenJWT();
try{
    if ($objToken->validarToken($headers['Authorization'])== true){
        $objUsuario = new Usuario();
        $objResposta->status = true;
        $objResposta->msg = 'executado com sucesso!';
        $objResposta->dados = $objUsuario->ReadbyPage($pagina) ;

    }else {
        $objResposta->status = false;
        $objResposta->msg = 'token invalido';
    }


}catch (Exception $e){

    $objResposta->status = true;
    $objResposta->msg = 'executado com sucesso!';
    $objResposta->erro = $e->getMessage();

}
echo json_encode($objResposta);

header("HTTP/1.1 200");
// Define o tipo de conteúdo da resposta como JSON
header("Content-Type: application/json");