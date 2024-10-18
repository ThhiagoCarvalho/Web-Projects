const Banco = require("./Banco")

module.exports = class Usuario {

    constructor() { 
        this._idUSuario = null
        this._nomeUsuario = ""
        this._emailUsuario = ""
        this._senhaUsuario = ""
        this._idade = ""
        this._dataDate = ""
        this._categoria_idCategoria = ""

    }

    async cadastrar () {
        const conexao = Banco.getConexao()
        const sql = "insert into usuario (nomeUsuario,emailUsuario,senhaUsuario,idade,dataDate,Categoria_idCategoria) values (?,?,md5(?),?,?,?)";

        try { 
            const [result] = await conexao.promise().execute(sql , [this._nomeUsuario, this._emailUsuario, this._senhaUsuario,this._idade,this._dataDate,this._categoria_idCategoria])
            this._idUSuario = result.insertId;
            return result.affectedRows > 0;
        }catch (error) {
            console.log("Errro >>>" , error)
            return false
        }
    }


    async updateSenha () {
        const conexao = Banco.getConexao()
        const sql = "update usuario set senhaUsuario = md5(?) where emailUsuario =  ? ";

        try { 
            const [result] = await conexao.promise().execute(sql , [this._senhaUsuario, this._emailUsuario ])
            this._idUSuario = result.insertId;
            return result.affectedRows > 0;
        }catch (error) {
            console.log("Errro >>>" , error)
            return false
        }
    }


    async verificarUsuario () {
        const conexao = Banco.getConexao()
        console.log (this._emailUsuario)
        console.log (this._senhaUsuario)

        const sql = "select count(*) AS qtd, nomeUsuario from usuario where emailUsuario = ? and senhaUsuario = md5(?) group by  nomeUsuario"
        try {
            const [result] = await conexao.promise().execute(sql , [ this._emailUsuario , this._senhaUsuario])

            for (let tupla of result) {
                if (tupla.qtd === 1) {
                    this.nomeUsuario = tupla.nomeUsuario;
                    this.emailUsuario = tupla.emailUsuario;
                    return true;
                }
            }
        }catch (error) { 
            console.log("Errro >>>" , error)
            return false
        }
    }


    async verificarEmail () {
        const conexao = Banco.getConexao()
        const sql = "select count(*) AS qtd,nomeUsuario,emailUsuario,senhaUsuario,Categoria_idCategoria from usuario where emailUsuario = ? group by nomeUsuario,emailUsuario,senhaUsuario,Categoria_idCategoria"
        try {
            const [result] = await conexao.promise().execute(sql , [ this._emailUsuario])
            console.log(result)
            if (result.length > 0) {
                // Retorna o usuário encontrado
                return {
                    nomeUsuario: result[0].nomeUsuario,
                    emailUsuario: result[0].emailUsuario,
                    senhaUsuario: result[0].senhaUsuario,
                    categoriaID: result[0].Categoria_idCategoria

                };
            } else {
                // Caso não encontre o usuário, retorna false
                return false;
            }            
        }catch (error) { 
            console.log("Errro >>>" , error)
            return false
        }
    }


    async get_categorias () {
        const conexao = Banco.getConexao()
        const sql = "select * from categoria";
        try {
            const [result] = await conexao.promise().execute(sql ,)
            return result;
                        
        }catch (error) { 
            console.log("Errro >>>" , error)
            return false
        }
    }

   // Getters
    get idUsuario() {
        return this._idUsuario;
    }

    get nomeUsuario() {
        return this._nomeUsuario;
    }

    get emailUsuario() {
        return this._emailUsuario;
    }

    get senhaUsuario() {
        return this._senhaUsuario;
    }

    get idade() {
        return this._idade;
    }

    get dataDate() {
        return this._dataDate;
    }

    get categoria_idCategoria() {
        return this._categoria_idCategoria;
    }

    // Setters
    set idUsuario(value) {
        this._idUsuario = value;
    }

    set nomeUsuario(value) {
        this._nomeUsuario = value;
    }

    set emailUsuario(value) {
        this._emailUsuario = value;
    }

    set senhaUsuario(value) {
        this._senhaUsuario = value;
    }

    set idade(value) {
        this._idade = value;
    }

    set dataDate(value) {
        this._dataDate = value;
    }

    set categoria_idCategoria(value) {
        this._categoria_idCategoria = value;
    }


}