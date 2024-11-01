<?php
use Firebase\JWT\MeuTokenJWT;

require_once("modelo/Banco.php");
require_once("modelo/MeuTokenJWT.php");
require_once("modelo/Opcao.php");

$objToken = new MeuTokenJWT();
$objResposta = new stdClass();

$headers = apache_request_headers();

try{
    if ($objToken->validarToken($headers['Authorization']) == true){
        $objOpcao = new Opcao();

        if ($objOpcao->readByPage($pagina)==true){
            $objResposta->status = true;
            $objResposta->msg = 'executado com sucesso!';

            $objResposta->dados = $objOpcao->readByPage($pagina);
        }else{
            $objResposta->status = false;
            $objResposta->msg = 'erro a leitura';
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
if( $objResposta->status == true) {
    header('HTTP/1.1 201');

}else {
    header('HTTP/1.1 200');

}
echo json_encode($objResposta);