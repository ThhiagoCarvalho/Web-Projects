<?php
use Firebase\JWT\MeuTokenJWT;

require_once("modelo/Banco.php");
require_once("modelo/MeuTokenJWT.php");
require_once("modelo/Opcao.php");

$textoRecebido = file_get_contents("php://input");
$objJson = json_decode($textoRecebido) or die ('{"msg": "texto em formato incorreto}');

$objToken = new MeuTokenJWT();
$objResposta = new stdClass();
$headers = apache_request_headers();


try{
    if ($objToken->validarToken($headers['Authorization']) == true){
        
        $objOpcao = new Opcao();

        $objOpcao->setIdOpcao($parametro_idOpcao);
        $objOpcao->setNomeOpcao($objJson->nomeOpcao);
        $objOpcao->setlocalizacao($objJson->localizacao);
        $objOpcao->setCusto($objJson->custo);
        $objOpcao->setHorario($objJson->horarioFuncionamento);
        $objOpcao->setIdCategoria($objJson->categoria_idCategoria);
        $objOpcao->setDescricao($objJson->descricao);


        if ($objOpcao->getNomeOpcao()==''){
            $objResposta->status = false;
            $objResposta->msg = "nome da opcao esta vaziaa!";

        }else if ($objOpcao->getlocalizacao()==''){
            $objResposta->status = false;
            $objResposta->msg = "localizacao da opcao esta vaziaa!";
        }else if ($objOpcao->getIdCategoria()==''){
            $objResposta->status = false;
            $objResposta->msg = "nao foi identificado o tipo da categoria da opcao!";

        }else if ($objOpcao->update()== true){
            $objResposta->status = true;
            $objResposta->msg = "sucesso ao atualizar!";
        }else {
            $objResposta->status = false;
            $objResposta->msg = "erro ao atualizar os dados da opcao";
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