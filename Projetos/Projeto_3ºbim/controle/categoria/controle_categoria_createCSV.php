<?php
require_once ("modelo/Banco.php");
require_once("modelo/Categoria.php");

$objResposta = new stdClass();
$objCategoria = new Categoria();

try{
    $nomeArquivo = $_FILES["variavelArquivo"]["tmp_name"];

    $ponteiroArquivo= fopen($nomeArquivo,"r");
    $i=0; $objCategoria = array();


    while  ( ($linhaArquivo = fgetcsv($ponteiroArquivo,1000,";")) !== false) {
        $objCategoria[$i] = new Categoria();
        $objCategoria[$i]->setNomeCategoria($linhaArquivo[0]);


        if ($objCategoria[$i]->createFromCsv()==true){
             $i++;
        }
    }

    $objResposta->status = true;
    $objResposta->msg = "Categorias cadastradas com sucesso";
    $objResposta->objCategorias = $objCategoria;
    $objResposta->totalCategorias = $i;
    echo json_encode($objResposta);
    


}catch(Exception $e){
    $objResposta->codigo = 1;
    $objResposta->status = false;
    $objResposta->erro = $e->getMessage();
    die(json_encode($objResposta));
}