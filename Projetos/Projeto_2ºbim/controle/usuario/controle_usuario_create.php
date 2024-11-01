<?php

require_once ("modelo/Banco.php");
require_once ("modelo/MeuTokenJWT.php");
require_once("modelo/Usuario.php");

$textoRecebido = file_get_contents("php://input");
$objJson = json_decode($textoRecebido) or die ('{"msg": "formato incorreot!"}');

$objResposta = new stdClass();
$objUsuario = new Usuario();


$objUsuario->setNomeUsuario($objJson->nomeUsuario);
$objUsuario->setEmail($objJson->emailUsuario);
$objUsuario->setSenha($objJson->senhaUsuario);
$objUsuario->setData($objJson->dataDate);
$objUsuario->setIdade($objJson->idade);
$objUsuario->setCategoriaID($objJson->idCategoria);

try{


    if ($objUsuario->getNomeUsuario()==''){
        $objResposta->status =  false;
        $objResposta->msg = 'Nome esta em branco!';
    } else  if ($objUsuario->verificarEmail()== true){
        $objResposta->cod =  1;
        $objResposta->status =  false;
        $objResposta->msg = 'Este email ja esta cadastrado!';

    }else if (strlen($objUsuario->getNomeUsuario())  < 4){
        $objResposta->status =  false;
        $objResposta->msg = 'o nome nao pode ser menor que 4 caracterees!';
        
    }else if ($objUsuario->getEmail()==''){
        $objResposta->status =  false;
        $objResposta->msg = 'o email nao pode estar vazio!';

 
    }else if ($objUsuario->create()==true){
        $objResposta->status =  true;
        $objResposta->msg = 'sucesso!';

    }else{
        $objResposta-> status = false;
        $objResposta->msg = "Erro ao cadastrar!";
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