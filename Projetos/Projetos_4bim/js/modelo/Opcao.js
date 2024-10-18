const Banco = require("./Banco")


module.exports  = class Opcao  { 

    constructor ( ) { 
        this._idOpcao = null
        this._nomeOpcao = ""
        this._custo = null
        this._localizacaoOpcao = ""
        this._horarioFuncionamento = ""
        this._categoria_idCategoria = null
        this._descricao =  ""
    }


    async create () { 
        const conexao = Banco.getConexao()
        const sql = "insert into opcoes (nomeOpcao,localizacaoOpcao,horarioFucionamento,custoEstimado,Categoria_idCategoria,descricao) values (?,?,?,?,?,?)";
        try {
            const [result] = await conexao.promise().execute (sql, [this._nomeOpcao,this._localizacaoOpcao,this._horarioFuncionamento,this._custo,this._categoria_idCategoria,this._descricao])
            const idOpcao = result.insertId
            return result.affectedRows > 0;

        }catch (error) {
            console.log("Errro >>>" , error)
            return false        
        }
    }

    async update () { 
        const conexao = Banco.getConexao()
        const sql = "update opcoes set nomeOpcao=?,localizacaoOpcao=?,horarioFucionamento=?,custoEstimado=?,Categoria_idCategoria=?,descricao=? where idOpcoes = ? ";
        try {
            const [result] = await conexao.promise().execute  (sql, [this._nomeOpcao,this._localizacaoOpcao,this._horarioFuncionamento,this._custo,this._categoria_idCategoria,this._descricao,this._idOpcao])
            return result.affectedRows > 0;
        }catch (error) {
            console.log("Errro >>>" , error)
            return false        
        }
    }

    async get_id_categorias() { 
        const conexao = Banco.getConexao();
           
        const sql = "SELECT opcoes.nomeOpcao, opcoes.descricao, opcoes.horarioFucionamento,opcoes.localizacaoOpcao,idOpcoes, custoEstimado FROM opcoes JOIN categoria ON categoria.idCategoria = opcoes.Categoria_idCategoria WHERE categoria.idCategoria = ?; ";
        try {
            const [result] = await conexao.promise().execute(sql, [this._categoria_idCategoria]);
            return result;
        } catch (error) {
            console.log("Erro >>>", error);
            return false;        
        }
    }


    async get_id() { 
        const conexao = Banco.getConexao();
           
        const sql = "SELECT * from opcoes where idOpcoes =  ?  ";
        try {
            const [result] = await conexao.promise().execute(sql, [this._idOpcao]);
            return result;
        } catch (error) {
            console.log("Erro >>>", error);
            return false;        
        }
    }
    
    async get_nomeOpcao() { 
        const conexao = Banco.getConexao();
           
        const sql = "SELECT * from opcoes where nomeOpcao =  ?  ";
        try {
            const [result] = await conexao.promise().execute(sql, [this._nomeOpcao]);
            return result;
        } catch (error) {
            console.log("Erro >>>", error);
            return false;        
        }
    }
    
    


    async delete () { 
        const conexao = Banco.getConexao()
        const sql = "delete from opcoes where idOpcoes = ? ";
        try {
            const [result] = await conexao.promise().execute  (sql, [this._idOpcao])
            return result.affectedRows > 0;
        }catch (error) {
            console.log("Errro >>>" , error)
            return false        
        }
    }


    async validar_opcao () { 
        const conexao = Banco.getConexao()
        const sql = "select count(*) as qtd from opcoes where nomeOpcao = ? ";
        try {
            const [result] = await conexao.promise().execute  (sql, [this._nomeOpcao])
            console.log(result)
            return result[0].qtd > 0;
        }catch (error) {
            console.log("Errro >>>" , error)
            return false        
        }
    }


      get idOpcao() {
        return this._idOpcao;
    }

    get nomeOpcao() {
        return this._nomeOpcao;
    }

    get custoOpcao() {
        return this._custo;
    }

    get localizacaoOpcao() {
        return this._localizacaoOpcao;
    }

    get horarioFuncionamento() {
        return this._horarioFuncionamento;
    }

    get categoria_idCategoria() {
        return this._categoria_idCategoria;
    }

    get descricao() {
        return this._descricao;
    }

    // Setters
    set idOpcao(value) {
        this._idOpcao = value;
    }

    set nomeOpcao(value) {
        this._nomeOpcao = value;
    }

    set custoOpcao(value) {
        this._custo = value;
    }

    set localizacaoOpcao(value) {
        this._localizacaoOpcao = value;
    }

    set horarioFuncionamento(value) {
        this._horarioFuncionamento = value;
    }

    set categoria_idCategoria(value) {
        this._categoria_idCategoria = value;
    }

    set descricao(value) {
        this._descricao = value;
    }
}