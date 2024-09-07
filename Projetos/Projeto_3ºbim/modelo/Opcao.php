<?php

class Opcao implements JsonSerializable{

    private $idOpcao;

    private $nomeOpcao;

    private $localizacao;

    private $horarioFuncionamento;

    private $custo;

    private $categoria_idCategoria;

    private $descricao;
    

    public function jsonSerialize():mixed
    {
        $objJson = new stdClass();
        $objJson->nomeOpcao =$this->getNomeOpcao();

        $objJson->localizacao =$this->getlocalizacao();
        $objJson->horarioFuncionamento = $this->getHorario();
        $objJson->custo = $this->getCusto();
        $objJson->categoria_idCategoria =$this->getIdCategoria();
        $objJson->descricao =$this->getDescricao();


        return $objJson;

    }


    public function create (){
        $conexao = Banco::getConexao();
        $sql = "insert into opcoes (nomeOpcao,localizacaoOpcao,horarioFucionamento,custoEstimado,Categoria_idCategoria,descricao) values (?,?,?,?,?,?)";
        $prepararSql = $conexao->prepare($sql);
        $prepararSql-> bind_param("ssssis",$this->nomeOpcao,$this->localizacao,$this->horarioFuncionamento,$this->custo,$this->categoria_idCategoria,$this->descricao);
        $executou = $prepararSql->execute();

        $idCadastrado = $conexao->insert_id;
        $this->setIdOpcao($idCadastrado);
        return $executou;

    }

    public function verificarOpcao () {
        $conexao = Banco::getConexao();
    
        $sql =  "SELECT count(*) AS qtd, nomeOpcao FROM opcoes WHERE nomeOpcao = ?   GROUP BY nomeOpcao";
    
        $prepararsql = $conexao->prepare($sql);
        $prepararsql->bind_param("s", $this->nomeOpcao);
        $prepararsql ->execute();
        $matriz = $prepararsql -> get_result();
        $objTupla = $matriz -> fetch_object();
        return $objTupla->qtd > 0;  
    }


    public function createFromCsv (){
        $conexao = Banco::getConexao();
        $sql = "insert into opcoes (nomeOpcao,localizacaoOpcao,horarioFucionamento,custoEstimado,Categoria_idCategoria,descricao) values (?,?,?,?,?,?)";
        $prepararSql = $conexao->prepare($sql);
        $prepararSql-> bind_param("ssssis",$this->nomeOpcao,$this->localizacao,$this->horarioFuncionamento,$this->custo,$this->categoria_idCategoria,$this->descricao);
        $executou = $prepararSql->execute();

        $idCadastrado = $conexao->insert_id;
        $this->setIdOpcao($idCadastrado);
        return $executou;

    }
    public function update (){
        $conexao = Banco::getConexao();
        $sql = "update opcoes set nomeOpcao=?,localizacaoOpcao=?,horarioFucionamento=?,custoEstimado=?,Categoria_idCategoria=?,descricao=?  where idOpcoes = ?";
        $prepararSql = $conexao->prepare($sql);
        $prepararSql-> bind_param("ssssisi",$this->nomeOpcao,$this->localizacao,$this->horarioFuncionamento,$this->custo,$this->categoria_idCategoria,$this->descricao,$this->idOpcao);
        $executou = $prepararSql->execute();
        return $executou;

    }
    public function delete (){
        $conexao = Banco::getConexao();
        $sql = "delete from opcoes where idOpcoes = ?";
        $prepararSql = $conexao->prepare($sql);
        $prepararSql-> bind_param("i",$this->idOpcao);
        $executou = $prepararSql->execute();
        return $executou;

    }
    public function readByID (){
        $conexao = Banco::getConexao();
        $sql = "select *  from opcoes where idOpcoes = ?";
        $prepararSql = $conexao->prepare($sql);
        $prepararSql-> bind_param("i",$this->idOpcao);
        $prepararSql->execute();
        $matriz = $prepararSql->get_result();
        $matrizTuplas = $matriz ->fetch_all(MYSQLI_ASSOC);
        return $matrizTuplas;

    }

    public function readId (){
        $conexao = Banco::getConexao();
        $sql = "SELECT opcoes.nomeOpcao, opcoes.descricao, opcoes.horarioFucionamento,opcoes.localizacaoOpcao,idOpcoes, custoEstimado FROM opcoes JOIN categoria ON categoria.idCategoria = opcoes.Categoria_idCategoria WHERE categoria.idCategoria = ?; ";
        $prepararSql = $conexao->prepare($sql);
        $prepararSql-> bind_param("i",$this->categoria_idCategoria);

        $prepararSql->execute();
        $matriz = $prepararSql->get_result();
        $matrizTuplas = $matriz ->fetch_all(MYSQLI_ASSOC);
        return $matrizTuplas;

    }

    public function readNome (){
        $conexao = Banco::getConexao();
        $sql = "SELECT * from opcoes where nomeOpcao = ? ";
        $prepararSql = $conexao->prepare($sql);
        $prepararSql-> bind_param("s",$this->nomeOpcao);

        $prepararSql->execute();
        $matriz = $prepararSql->get_result();
        $matrizTuplas = $matriz ->fetch_all(MYSQLI_ASSOC);
        return $matrizTuplas;

    }


    public function readByPage ($pagina){
        $itensPagina = 5;
        $inicio = ($pagina-1) * $itensPagina;
        $conexao = Banco::getConexao();
        $sql = "select * from opcoes  limit ? , ? ";
        $prepararSql = $conexao->prepare($sql);
        $prepararSql-> bind_param("ii",$inicio,$itensPagina);
        $prepararSql->execute();
        $matriz = $prepararSql->get_result();
        $matrizTuplas = $matriz ->fetch_all(MYSQLI_ASSOC);
        return $matrizTuplas;

    }


    public function setIdOpcao ($idOpcao){
        $this->idOpcao = $idOpcao;
    }
    public function getIdOpcao (){
        return $this->idOpcao;
    }
    public function setNomeOpcao ($nomeOpcao){
        $this->nomeOpcao = $nomeOpcao;
    }
    public function getNomeOpcao(){
        return $this->nomeOpcao;
    }


    public function setlocalizacao ($localizacao){
        $this->localizacao = $localizacao;
    }

    public function getlocalizacao(){
        return $this->localizacao;
    }   
    
    public function setHorario ($horario){
        $this->horarioFuncionamento = $horario;
    }

    public function getHorario(){
        return $this->horarioFuncionamento;
    } 
    
    public function setCusto ($custo){
        $this->custo = $custo;
    }
    public function getCusto(){
        return $this->custo;
    } 
    
    public function setIdCategoria ($idCategoria){
        $this->categoria_idCategoria = $idCategoria;
    }

    public function getIdCategoria(){
        return $this->categoria_idCategoria;
    }

    public function setDescricao ($descricao){
        $this->descricao = $descricao;
    }

    public function getDescricao(){
        return $this->descricao;
    }
}