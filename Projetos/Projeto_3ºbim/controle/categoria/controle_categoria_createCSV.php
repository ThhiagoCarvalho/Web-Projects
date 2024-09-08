<?php
require_once ("modelo/Banco.php");
require_once("modelo/Categoria.php");

$objResposta = new stdClass();
$objCategoria = new Categoria();

try{
    $nomeArquivo = $_FILES["variavelArquivo"]["tmp_name"];

    $ponteiroArquivo= fopen($nomeArquivo,"r");
    $i=0;
    $objCategoria = array();
    $qtdCategoriasDuplicadas = 0;
    $categoriasDuplicadas = array();


    while  ( ($linhaArquivo = fgetcsv($ponteiroArquivo,1000,";")) !== false) {
        $objCategoria[$i] = new Categoria();
        $objCategoria[$i]->setNomeCategoria($linhaArquivo[0]);

        if ($objCategoria[$i]->verificarCategoria() == false){
            if ($objCategoria[$i]->createFromCsv()==true){
                $i++;
            }
        }else {
           $qtdCategoriasDuplicadas = $qtdCategoriasDuplicadas + 1;
           $categoriasDuplicadas[] = $linhaArquivo[0];

        }
    }
    if ($i== 0 && $qtdCategoriasDuplicadas > 0) {
        $objResposta->codigo = 1;
        $objResposta->status = false;
        $objResposta->msg = "Nenhum cadastro feito. As seguintes categorias já estão cadastradas: "  . implode(", ", $categoriasDuplicadas);

    } else if ($i > 0 && $qtdCategoriasDuplicadas > 0) {
        $objResposta->codigo = 2;
        $objResposta->status = true;
        $objResposta->msg = "Algumas categorias foram cadastradas. No entanto, as seguintes categorias já estão cadastradas: " . implode(", ", $categoriasDuplicadas);
    
    } else {
        $objResposta->codigo = 3;
        $objResposta->status = true;
        $objResposta->msg = "Todas as categorias foram cadastradas com sucesso!";
        $objResposta->objCategorias = $objCategoria;
        $objResposta->totalCategorias = $i;
    }
    echo json_encode($objResposta);

}catch(Exception $e){
    $objResposta->codigo = 1;
    $objResposta->status = false;
    $objResposta->erro = $e->getMessage();
    die(json_encode($objResposta));
}