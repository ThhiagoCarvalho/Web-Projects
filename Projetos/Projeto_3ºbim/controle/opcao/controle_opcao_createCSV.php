<?php
require_once ("modelo/Banco.php");
require_once("modelo/Opcao.php");

$objResposta = new stdClass();
$objOpcao = new Opcao();

try{
    $nomeArquivo = $_FILES["variavelArquivo"]["tmp_name"];

    $ponteiroArquivo= fopen($nomeArquivo,"r");
    $i=0; $objOpcao = array();
    $qtdOpcoesDuplicadas = 0;
    $opcoesDuplicadas = array();
    
    while  ( ($linhaArquivo = fgetcsv($ponteiroArquivo,1000,";")) !== false) {
        $objOpcao[$i] = new Opcao();
        $objOpcao[$i]->setNomeOpcao($linhaArquivo[0]);
        $objOpcao[$i]->setlocalizacao($linhaArquivo[1]);
        $objOpcao[$i]->setCusto($linhaArquivo[2]);
        $objOpcao[$i]->setHorario($linhaArquivo[3]);
        $objOpcao[$i]->setIdCategoria($linhaArquivo[4]);
        $objOpcao[$i]->setDescricao($linhaArquivo[5]);


        if ($objOpcao[$i]->verificarOpcao() == false){
            if ($objOpcao[$i]->createFromCsv()==true){
                $i++;
           }
        }else {
           $qtdOpcoesDuplicadas = $qtdOpcoesDuplicadas + 1;
           $opcoesDuplicadas[] = $linhaArquivo[0];
        }
    }

    
    if ($i== 0 && $qtdOpcoesDuplicadas > 0) {
        $objResposta->codigo = 1;
        $objResposta->status = false;
        $objResposta->msg = "Nenhum cadastro feito. As seguintes opções já estão cadastradas: " . implode(", ", $opcoesDuplicadas);
    
    } else if ($i > 0 && $qtdOpcoesDuplicadas > 0) {
        $objResposta->codigo = 2;
        $objResposta->status = true;
        $objResposta->msg = "Algumas opções foram cadastradas. No entanto, as seguintes opções já estão cadastradas: " . implode(", ", $opcoesDuplicadas);
    
    } else  if ($i >0 && $qtdOpcoesDuplicadas == 0) {
        $objResposta->codigo = 3;
        $objResposta->status = true;
        $objResposta->msg = "Todas as opções foram cadastradas com sucesso";
        $objResposta->objOpcao = $objOpcao;
        $objResposta->totalOpcoes = $i;
    }

    echo json_encode($objResposta);
    
}catch(Exception $e){
    $objResposta->codigo = 1;
    $objResposta->status = false;
    $objResposta->erro = $e->getMessage();
    die(json_encode($objResposta));
}