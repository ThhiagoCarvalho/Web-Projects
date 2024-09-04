<?php
require_once ("modelo/Banco.php");
require_once("modelo/Opcao.php");

$objResposta = new stdClass();
$objOpcao = new Opcao();

try{
    $nomeArquivo = $_FILES["variavelArquivo"]["tmp_name"];

    $ponteiroArquivo= fopen($nomeArquivo,"r");
    $i=0; $objOpcao = array();


    while  ( ($linhaArquivo = fgetcsv($ponteiroArquivo,1000,";")) !== false) {
        $objOpcao[$i] = new Opcao();
        $objOpcao[$i]->setNomeOpcao($linhaArquivo[0]);
        $objOpcao[$i]->setlocalizacao($linhaArquivo[1]);
        $objOpcao[$i]->setCusto($linhaArquivo[2]);
        $objOpcao[$i]->setHorario($linhaArquivo[3]);
        $objOpcao[$i]->setIdCategoria($linhaArquivo[4]);
        $objOpcao[$i]->setDescricao($linhaArquivo[5]);


        if ($objOpcao[$i]->createFromCsv()==true){
             $i++;
        }
    }

    $objResposta->status = true;
    $objResposta->msg = "Opcoes cadastradas com sucesso";
    $objResposta->Opcoes = $objOpcao;
    $objResposta->totalOpcao = $i;
    echo json_encode($objResposta);
    


}catch(Exception $e){
    $objResposta->codigo = 1;
    $objResposta->status = false;
    $objResposta->erro = $e->getMessage();
    die(json_encode($objResposta));
}