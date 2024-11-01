<?php
use Firebase\JWT\MeuTokenJWT;

require_once ("modelo/Banco.php");
require_once ("modelo/MeuTokenJWT.php");
require_once("modelo/Usuario.php");

$textoRecebido = file_get_contents("php://input");
$objJson = json_decode($textoRecebido) or die ('{"msg": "formato incorreto!"}');

$objResposta = new stdClass();
$objToken = new MeuTokenJWT();

try{
    $objUsuario = new Usuario();
    $objUsuario->setEmail($objJson->emailUsuario);
    $objUsuario->setSenha($objJson->senhaUsuario);
    if ($objUsuario->verificarEmail() == true){
        if ($objUsuario->updateSenha()==true){
            $objResposta->status =  true;
            $objResposta->msg = 'sucesso ao trocar a senha!';
        }else {
            $objResposta->status = false;
            $objResposta->msg = 'erro ao trocar';
        }
    }else {
         $objResposta->status = false;
            $objResposta->msg = 'email invalido';
    }
}catch (Exception $e){
    $objResposta-> status = false;
    $objResposta->error =$e->getMessage();
    die(json_encode($objResposta));
}

echo json_encode($objResposta);