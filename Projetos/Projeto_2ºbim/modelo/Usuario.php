<?php
require_once("modelo/Banco.php");


class Usuario implements JsonSerializable {
    private $idUsuario;
    private $nomeUsuario;  
    private $senhaUsuario;
    private $emailUsuario;

    private $tokenUsuario;
    private $categoria_idCategoria;
    private $idade;
    private $dataDate;





    public function jsonSerialize():mixed
    {
        $obj = new stdClass();
        $obj->idUsuario= $this->getIdUsuario();
        $obj->nomeUsuario = $this->getNomeUsuario();
        $obj->emailUsuario = $this->getEmail();
        $obj->idade = $this->getIdade();
        $obj->dataDate = $this->getData();
        $obj->categoriaID = $this->getCategoriaID();
        
        return $obj;

    }


public function verficarUsuarioSenha () {
    $conexao = Banco::getConexao();
    $sql =  "SELECT count(*) AS qtd, idUsuario,nomeUsuario, emailUsuario,idade,dataDate,Categoria_idCategoria FROM usuario WHERE emailUsuario = ? AND senhaUsuario = md5(?)  GROUP BY idUsuario, nomeUsuario, emailUsuario, idade,dataDate,Categoria_idCategoria";

    $prepararsql = $conexao->prepare($sql);
    $prepararsql->bind_param("ss", $this->emailUsuario, $this->senhaUsuario);
    $prepararsql ->execute();
    $matriz = $prepararsql -> get_result();
    
    while ($tupla = $matriz -> fetch_object() ){
        if($tupla->qtd == 1){
            $this->setIdUsuario($tupla->idUsuario);
            $this->setNomeUsuario($tupla->nomeUsuario);
            $this->setEmail($tupla->emailUsuario);
            $this->setIdade($tupla->idade);
            $this->setData($tupla->dataDate);
            $this->setCategoriaID($tupla->Categoria_idCategoria);

            return true;  

        }
    }
    return false;  

}

public function verificarEmail () {
    $conexao = Banco::getConexao();
    $sql =  "SELECT count(*) AS qtd, emailUsuario FROM usuario WHERE emailUsuario = ?   GROUP BY emailusuario";

    $prepararsql = $conexao->prepare($sql);
    $prepararsql->bind_param("s", $this->emailUsuario);
    $prepararsql ->execute();
    $matriz = $prepararsql -> get_result();
    $objTupla = $matriz -> fetch_object();

    return $objTupla->qtd > 0;  
}

public function create (){
    $conexao = Banco::getConexao() ;
    $this->senhaUsuario = md5($this->senhaUsuario);

    $sql = "insert into usuario (nomeUsuario,emailUsuario,senhaUsuario,idade,dataDate,Categoria_idCategoria) values (?,?,?,?,?,?)";
    
   
    $prepararsql = $conexao->prepare($sql);
    if (!$prepararsql) {
        throw new Exception("Erro ao preparar a consulta SQL");
    }
    $prepararsql->bind_param("sssisi",$this->nomeUsuario,$this->emailUsuario,$this->senhaUsuario,$this->idade,$this->dataDate,$this->categoria_idCategoria);
    $executou = $prepararsql->execute();
    if (!$executou) {
        throw new Exception("Erro ao executar a consulta SQL");
    }
    $idCadastrado = $conexao->insert_id;
    $this->setIdUsuario($idCadastrado);
    return $executou;    
}


public function createFromCsv (){
    $conexao = Banco::getConexao() ;
    $this->senhaUsuario = md5($this->senhaUsuario);
   
    $sql = "insert into usuario (nomeUsuario,emailUsuario,senhaUsuario,idade,dataDate,Categoria_idCategoria) values (?,?,?,?,?,?)";
    $prepararsql = $conexao->prepare($sql);
    if (!$prepararsql) {
        throw new Exception("Erro ao preparar a consulta SQL");
    }
    $prepararsql->bind_param("sssisi",$this->nomeUsuario,$this->emailUsuario,$this->senhaUsuario,$this->idade,$this->dataDate,$this->categoria_idCategoria);
    $executou = $prepararsql->execute();
   
    $idCadastrado = $conexao->insert_id;
    $this->setIdUsuario($idCadastrado);
    return $executou;    
}

public function IsUsuario (){
    $conexao = Banco::getConexao() ;
    $sql = "select count(*) as qtd from usuario where emailUsuario = ?";
    $prepararsql = $conexao->prepare($sql);
    if (!$prepararsql) {
        throw new Exception("Erro ao preparar a consulta SQL");
    }
    $prepararsql->bind_param("s",$this->emailUsuario);
    $executou = $prepararsql->execute();
    if (!$executou) {
        throw new Exception("Erro ao executar a consulta SQL");
    }
    $matriz = $prepararsql->get_result();
    $objTupla  = $matriz->fetch_object();
    return $objTupla->qtd > 0;
}


public function delete (){
    $conexao = Banco::getConexao() ;
    $sql = "delete from usuario where idUsuario = ?";
    $prepararsql = $conexao->prepare($sql);
    if (!$prepararsql) {
        throw new Exception("Erro ao preparar a consulta SQL");
    }
    $prepararsql->bind_param("i",$this->idUsuario);
    return $prepararsql->execute();    

}


public function update (){
    $conexao = Banco::getConexao() ;
    $this->senhaUsuario = md5($this->senhaUsuario);

    $sql = "update usuario set nomeUsuario=?,emailUsuario=?,senhaUsuario=?,idade=?,dataDate=?,Categoria_idCategoria=? where idUsuario = ?";
    $prepararsql = $conexao->prepare($sql);
    if (!$prepararsql) {
        throw new Exception("Erro ao preparar a consulta SQL");
    }
    $prepararsql->bind_param("sssisii",$this->nomeUsuario,$this->emailUsuario,$this->senhaUsuario,$this->idade,$this->dataDate,$this->categoria_idCategoria,$this->idUsuario);
    return  $prepararsql->execute();
}

public function updateSenha (){
    $conexao = Banco::getConexao() ;

    $sql = "update usuario set senhaUsuario = md5(?)  where emailUsuario = ?";
    $prepararsql = $conexao->prepare($sql);
    if (!$prepararsql) {
        throw new Exception("Erro ao preparar a consulta SQL");
    }
    $prepararsql->bind_param("ss",$this->senhaUsuario,$this->emailUsuario);
    return  $prepararsql->execute();
}
public function ReadById (){
    $conexao = Banco::getConexao() ;
    $sql = "select * from usuario where idUsuario = ?";
    $prepararsql = $conexao->prepare($sql);
    if (!$prepararsql) {
        throw new Exception("Erro ao preparar a consulta SQL");
    }
    $prepararsql->bind_param("i", $this->idUsuario);
    $prepararsql->execute();
    if (!$prepararsql->execute()) {
        throw new Exception("Erro ao executar a consulta SQL");
    }
    $matrizTuplas = $prepararsql->get_result();
    $matrizTuplas = $matrizTuplas ->fetch_all(MYSQLI_ASSOC);
    return $matrizTuplas;

}

public function ReadByPage ($pagina){
    $conexao = Banco::getConexao() ;
    $itensPorPagina = 5;
    $inicio = ($pagina - 1) * $itensPorPagina;
    $sql = "select * from usuario limit ?,?";
    $prepararsql = $conexao->prepare($sql);
    if (!$prepararsql) {
        throw new Exception("Erro ao preparar a consulta SQL");
    }
    $prepararsql->bind_param("ii",$inicio,$itensPorPagina);
    $executou = $prepararsql->execute();
    if (!$executou) {
        throw new Exception("Erro ao executar a consulta SQL");
    }
    $matriz = $prepararsql->get_result();
    $matriz = $matriz->fetch_all(MYSQLI_ASSOC);
    return $matriz;
}



public function getTokenUsuario ( $token ){
    return $this->tokenUsuario;
}
public function setTokenUsuario( $token ){
    $this->tokenUsuario = $token;
}

public function setIdUsuario($idUsuario) {
    $this->idUsuario = $idUsuario;
}
public function getIdUsuario() {
    return $this->idUsuario;
}

public function setNomeUsuario($nome) {

    $this->nomeUsuario = $nome;
}
public function getNomeUsuario() {
    return $this->nomeUsuario;
}
public function setSenha($senha) {
    $this->senhaUsuario = $senha;
}
public function getSenha() {
    return $this->senhaUsuario;
}
public function setEmail($email) {
    $this->emailUsuario = $email;
}
public function getEmail() {
    return $this->emailUsuario;
}
public function setData($data) {
    $this->dataDate = $data;
}
public function getData() {
    return $this->dataDate;
}

public function setIdade($idade) {
    $this->idade = $idade;
}
public function getIdade() {
    return $this->idade;
}



public function setCategoriaID($categoriaID) {
    $this->categoria_idCategoria = $categoriaID;
}
public function getCategoriaID() {
    return $this->categoria_idCategoria;
}

















}
?>