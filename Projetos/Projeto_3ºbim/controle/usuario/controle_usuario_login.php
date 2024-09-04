<?php
use Firebase\JWT\MeuTokenJWT;
require_once ("modelo/Banco.php");
require_once ("modelo/MeuTokenJWT.php");
require_once("modelo/Usuario.php");

$textoRecebido = file_get_contents("php://input");
$objJson = json_decode($textoRecebido) or die ('{"msg": "formato incorreto!"}');

$objResposta = new stdClass();
$objUsuario = new Usuario();


$objUsuario->setEmail($objJson->emailUsuario);
$objUsuario->setSenha($objJson->senha);


try{
    if ($objUsuario->verficarUsuarioSenha() == true){
   
        $tokenjwt = new MeuTokenJWT();
        $objClaimsToken = new stdClass();
        $objClaimsToken->emailUsuario =  $objUsuario->getEmail();
        $objClaimsToken->senhaUsuario = $objUsuario->getSenha();

        $novoToken = $tokenjwt->gerarToken($objClaimsToken);

        $objResposta->status =  true;
        $objResposta->msg = 'Login efetuado com sucesso!';
        $objResposta->token = $novoToken;
        $objResposta->usuario = $objUsuario;
        


    }else{
        
        $objResposta->status =  false;
        $objResposta->msg = 'Usuario inexistente!';
    }


}catch (Exception $e){
    
    $objResposta-> status = false;
    $objResposta->error =$e->getMessage();
    die(json_encode($objResposta));
}

if( $objResposta->status == true) {
    header('HTTP/1.1 200');

}else {
    header('HTTP/1.1 401');

}
echo json_encode($objResposta);