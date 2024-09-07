<?php

class Categoria implements JsonSerializable{


    private $idCategoria;


    private $nomeCategoria;

    public function jsonSerialize():mixed
    {

        $objJson = new stdClass();
        $objJson->idCategoria = $this->getIdCategoria();
        $objJson->nomeCategoria = $this->getNomeCategoria();
        return $objJson;
    }

    public function create (){
        $conexao = Banco::getConexao();
        if (!$conexao) {
            die("Erro na conexão com o banco de dados");
        }
        $sql = "insert into categoria (nomeCategoria) values  (?)";
        $prepararSql = $conexao->prepare($sql);
        $prepararSql->bind_param("s",$this->nomeCategoria);
        $executou =$prepararSql->execute();

        $idCadastrado = $conexao->insert_id;
        $this->setIdCategoria($idCadastrado);
        return $executou;
    }

    public function verificarCategoria () {
        $conexao = Banco::getConexao();
    
        $sql =  "SELECT count(*) AS qtd, nomeCategoria FROM categoria WHERE nomeCategoria = ?   GROUP BY nomeCategoria";
    
        $prepararsql = $conexao->prepare($sql);
        $prepararsql->bind_param("s", $this->nomeCategoria);
        $prepararsql ->execute();
        $matriz = $prepararsql -> get_result();
        $objTupla = $matriz -> fetch_object();
        return $objTupla->qtd > 0;  
    }

    

    public function createFromCsv (){
        $conexao = Banco::getConexao();
        if (!$conexao) {
            die("Erro na conexão com o banco de dados");
        }
        $sql = "insert into categoria (nomeCategoria) values  (?)";
        $prepararSql = $conexao->prepare($sql);
        $prepararSql->bind_param("s",$this->nomeCategoria);
        $executou =$prepararSql->execute();

        $idCadastrado = $conexao->insert_id;
        $this->setIdCategoria($idCadastrado);
        return $executou;
    }
    
    public function update (){
        $conexao = Banco::getConexao();
        $sql = "update categoria set nomeCategoria =? where idCategoria = ?";
        $prepararSql = $conexao->prepare($sql);
        $prepararSql->bind_param("si",$this->nomeCategoria,$this->idCategoria);
        $executou =$prepararSql->execute();
        return $executou;

    }
    public function delete (){
        $conexao = Banco::getConexao();
        $sql = "delete from categoria where idCategoria = ?";

        $prepararSql = $conexao->prepare($sql);


        $prepararSql->bind_param("i",$this->idCategoria);
        $executou =$prepararSql->execute();
        return $executou;

    }

    public function readById (){
        $conexao = Banco::getConexao();
        $sql = "select * from categoria where nomeCategoria = ?";

        $prepararSql = $conexao->prepare($sql);

        $prepararSql->bind_param("s",$this->nomeCategoria);
        $prepararSql->execute();
        $matriz = $prepararSql->get_result();
        $matrizTuplas = $matriz ->fetch_all(MYSQLI_ASSOC);
        return $matrizTuplas;

    }

    public function readALL (){
        $conexao = Banco::getConexao();
        $sql = "select * from categoria";

        $prepararSql = $conexao->prepare($sql);

        $prepararSql->execute();
        $matriz = $prepararSql->get_result();
        $matrizTuplas = $matriz ->fetch_all(MYSQLI_ASSOC);
        return $matrizTuplas;

    }

    public function readByPage ($pagina){
        $itensPagina = 5;
        $inicio = ($pagina-1) * $itensPagina;
        $conexao = Banco::getConexao();
        $sql = "select  * from categoria limit ?,?";

        $prepararSql = $conexao->prepare($sql);
        $prepararSql->bind_param("ii",$inicio,$itensPagina);
        $prepararSql->execute();
        $matriz = $prepararSql->get_result();
        $matrizTuplas = $matriz ->fetch_all(MYSQLI_ASSOC);
        return $matrizTuplas;

    }

    public function IsCategoria (){
        $conexao = Banco::getConexao();
        $sql = "select count(*) as qtd,nomeCategoria from categoria where nomeCategoria = ?  GROUP BY nomeCategoria";
        $prepararSql = $conexao->prepare($sql);
        $prepararSql->bind_param("i",$this->nomeCategoria);
        $executou =$prepararSql->execute();
        $matriz = $executou->get_result();
        $tupla = $matriz->fetch_object();
        return $tupla->qtd > 0;
    }

    public function setIdCategoria ($id){
        $this->idCategoria = $id;
    }
    public function getIdCategoria (){
        return $this->idCategoria;
    }
    public function setNomeCategoria ($nome){
        $this->nomeCategoria = $nome;
    }
    public function getNomeCategoria (){
        return $this->nomeCategoria;
    }
}