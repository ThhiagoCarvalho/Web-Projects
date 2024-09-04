<?php
require_once("modelo/Banco.php");
require_once("modelo/Opcao.php");

$objResposta = new stdClass();
try{
    $objOpcao = new Opcao();
    if ($objOpcao->readALL()== true){
            $objResposta->status = true;
            $objResposta->opcao = $objOpcao->readALL() ;
        }else{
            $objResposta-> status = false;
            $objResposta->msg = "Erro ao ler!";
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