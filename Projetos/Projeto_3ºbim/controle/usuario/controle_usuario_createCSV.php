<?php
require_once ("modelo/Banco.php");
require_once("modelo/Usuario.php");

$objResposta = new stdClass();
$objUsuario = new Usuario();

try{
    $nomeArquivo = $_FILES["variavelArquivo"]["tmp_name"];

    $ponteiroArquivo= fopen($nomeArquivo,"r");
    $i=0; $objUsuario = array();


    while  ( ($linhaArquivo = fgetcsv($ponteiroArquivo,1000,";")) !== false) {
        $objUsuario[$i] = new Usuario();
        $objUsuario[$i]->setNomeUsuario($linhaArquivo[0]);
        $objUsuario[$i]->setEmail($linhaArquivo[1]);
        $objUsuario[$i]->setSenha($linhaArquivo[2]);
        $objUsuario[$i]->setIdade($linhaArquivo[3]);
        $objUsuario[$i]->setData($linhaArquivo[4]);
        $objUsuario[$i]->setCategoriaID($linhaArquivo[5]);

        if ($objUsuario[$i]->createFromCsv()==true){
             $i++;
        }
    }

    $objResposta->status = true;
    $objResposta->msg = "Cargos cadastrados com sucesso";
    $objResposta->usuarios = $objUsuario;
    $objResposta->totalUsuarios = $i;
    echo json_encode($objResposta);
    


}catch(Exception $e){
    $objResposta->codigo = 1;
    $objResposta->status = false;
    $objResposta->erro = $e->getMessage();
    die(json_encode($objResposta));
}