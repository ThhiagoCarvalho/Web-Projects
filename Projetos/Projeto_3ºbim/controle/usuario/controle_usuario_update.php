<?php
use Firebase\JWT\MeuTokenJWT;

require_once ("modelo/Banco.php");
require_once ("modelo/MeuTokenJWT.php");
require_once("modelo/Usuario.php");

$textoRecebido = file_get_contents("php://input");
$objJson = json_decode($textoRecebido) or die ('{"msg": "formato incorreto!"}');
$headers = apache_request_headers();

$objResposta = new stdClass();
$objToken = new MeuTokenJWT();

try{
    if ($objToken->validarToken($headers['Authorization'])== true){
        $objUsuario = new Usuario();
        $objUsuario->setIdUsuario($parametro_idusuario);
        $objUsuario->setNomeUsuario($objJson->nomeUsuario);
        $objUsuario->setEmail($objJson->emailUsuario);
        $objUsuario->setSenha($objJson->senhaUsuario);
        $objUsuario->setData($objJson->dataDate);
        $objUsuario->setIdade($objJson->idade);
        $objUsuario->setCategoriaID($objJson->idCategoria);

        if ($objUsuario->getNomeUsuario()==''){
            $objResposta->status =  false;
            $objResposta->msg = 'Nome esta em branco!';

        }else if (strlen($objUsuario->getNomeUsuario()  < 4)){
            $objResposta->status =  false;
            $objResposta->msg = 'o nome nao pode ser menor que 4 caracterees!';
            
        }else if ($objUsuario->Update()==true){
            $objResposta->status =  true;
            $objResposta->msg = 'sucesso!';

        }else{
            $objResposta-> status = false;
            $objResposta->msg = "Erro ao atualizar!";
        }

    }else{
        $objResposta->status = false;
        $objResposta->msg = 'token invalido';
    }
}catch (Exception $e){
    $objResposta-> status = false;
    $objResposta->error =$e->getMessage();
    die(json_encode($objResposta));

}

if( $objResposta->status == true) {
    header('HTTP/1.1 201');

}else {
    header('HTTP/1.1 200');

}

echo json_encode($objResposta);

?>