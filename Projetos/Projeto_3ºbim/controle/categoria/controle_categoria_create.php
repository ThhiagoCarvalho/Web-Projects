<?php
use Firebase\JWT\MeuTokenJWT;

require_once("modelo/Banco.php");
require_once("modelo/Categoria.php");
require_once("modelo/MeuTokenJWT.php");

$texto = file_get_contents("php://input");
$objJson = json_decode($texto) or die ('{"msg: formato incorreto"}');

$objResposta = new stdClass();
$objToken = new MeuTokenJWT();
$headers = apache_request_headers();


try{
    if ($objToken->validarToken($headers['Authorization']) == true){
        $objCategoria = new Categoria();
        $objCategoria->setNomeCategoria($objJson->nomeCategoria);
        if ($objCategoria->getNomeCategoria()== ''){
            $objResposta->status = false;
            $objResposta->msg = 'nome da categoria vazia';

        }else if (strlen($objCategoria->getNomeCategoria())  < 4){
            echo $objCategoria->getNomeCategoria();
            $objResposta->cod = 3;
            $objResposta->status = false;
            $objResposta->msg = 'nome muito curto';

        }else if ($objCategoria->verificarCategoria() == true) {
            $objResposta->cod =  1;
            $objResposta->status = false;
            $objResposta->msg = "Essa categoria já existe";

        }else if ($objCategoria->create()== true){
            $objResposta->status=true;
            $objResposta->msg = 'sucesso!';
        }else{
            $objResposta-> status = false;
            $objResposta->msg = "Erro ao cadastrar!";
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