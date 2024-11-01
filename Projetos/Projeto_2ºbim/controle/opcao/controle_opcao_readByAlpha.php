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
        $objOpcao->setNomeOpcao($frase);
        if ($objOpcao->readNome()==true){
            $objResposta->status = true;
            $objResposta->msg = 'executado com sucesso!';
            $objResposta->dados = $objOpcao->readNome();    
            
        }else{
            $objResposta->codigo = 1;
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