<?php
require_once("modelo/Banco.php");
require_once("modelo/Categoria.php");

$objResposta = new stdClass();
try{
    $objCategoria = new Categoria();
    if ($objCategoria->readALL()== true){
            $objResposta->status = true;
            $objResposta->categoria = $objCategoria->readALL() ;
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