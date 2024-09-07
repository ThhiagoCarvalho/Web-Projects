<?php
require_once ("modelo/Banco.php");
require_once("modelo/Usuario.php");

$objResposta = new stdClass();
$objUsuario = new Usuario();

try{
    $nomeArquivo = $_FILES["variavelArquivo"]["tmp_name"];

    $ponteiroArquivo= fopen($nomeArquivo,"r");
    $i=0; 
    $objUsuario = array();
    $qtdUsuariosDuplicados = 0;
    $usuariosDuplicados = array();

    while  ( ($linhaArquivo = fgetcsv($ponteiroArquivo,1000,";")) !== false) {
        $objUsuario[$i] = new Usuario();
        
        $objUsuario[$i]->setNomeUsuario($linhaArquivo[0]);
        $objUsuario[$i]->setEmail($linhaArquivo[1]);
        $objUsuario[$i]->setSenha($linhaArquivo[2]);
        $objUsuario[$i]->setIdade($linhaArquivo[3]);
        $objUsuario[$i]->setData($linhaArquivo[4]);
        $objUsuario[$i]->setCategoriaID($linhaArquivo[5]);

        if ($objUsuario[$i]->verificarEmail() === false) {
            if ($objUsuario[$i]->createFromCsv()==true){
                $i++;
            }
        }else if ($objUsuario[$i]->verificarEmail() === true) {

            $qtdUsuariosDuplicados = $qtdUsuariosDuplicados + 1;
            $usuariosDuplicados[] = $linhaArquivo[1];
        }
    }

    if ($i== 0 && $qtdUsuariosDuplicados > 0) {
        $objResposta->codigo = 1;
        $objResposta->status = false;
        $objResposta->msg = "Nenhum cadastro feito. Os seguintes usuários já estão cadastrados: " . implode(", ", $usuariosDuplicados);

    } else if ($i > 0 && $qtdUsuariosDuplicados > 0) {
        $objResposta->codigo = 2;
        $objResposta->status = true;
        $objResposta->msg = "Alguns usuários foram cadastrados. No entanto, os seguintes usuarios já estão cadastrados: " . implode(", ", $usuariosDuplicados);
        
    } else  if ($i >0 && $qtdUsuariosDuplicados == 0) {
        $objResposta->codigo = 3;
        $objResposta->status = true;
        $objResposta->msg = "Todos os usuarios foram cadastrados com sucesso";
        $objResposta->objUsuarios = $objUsuario;
        $objResposta->totalUsuarios = $i;
    }
    echo json_encode($objResposta);
    
}catch(Exception $e){
    $objResposta->codigo = 1;
    $objResposta->status = false;
    $objResposta->erro = $e->getMessage();
    die(json_encode($objResposta));
}