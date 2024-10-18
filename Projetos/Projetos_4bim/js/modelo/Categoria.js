const Banco = require("./Banco")


module.exports  = class Categoria  { 

    constructor ( ) { 
        this._idCategoria = null
        this._nomeCategoria = ""
    }



    async create () { 
        const conexao = Banco.getConexao()
        const sql = "insert into categoria (nomeCategoria) values (?)";
        try {
            const [result] = await conexao.promise().execute (sql, [this._nomeCategoria])
            const idOpcao = result.insertId
            return result.affectedRows > 0;

        }catch (error) {
            console.log("Errro >>>" , error)
            return false        
        }
    }

    async update () { 
        const conexao = Banco.getConexao()
        const sql = "update categoria set nomeCategoria=? where idCategoria = ? ";
        try {
            const [result] = await conexao.promise().execute  (sql, [this._nomeCategoria,this._idCategoria])
            return result.affectedRows > 0;
        }catch (error) {
            console.log("Errro >>>" , error)
            return false        
        }
    }

    async get_nome_categorias() { 

        const conexao = Banco.getConexao();
        const sql = "select * from categoria where nomeCategoria =  ? "
        try {
            const [result] = await conexao.promise().execute(sql, [this._nomeCategoria]);
            return result;
        } catch (error) {
            console.log("Erro >>>", error);
            return false;        
        }
    }


    async get_all() { 
        const conexao = Banco.getConexao();
           
        const sql = "SELECT * from categoria  ";
        try {
            const [result] = await conexao.promise().execute(sql,);
            return result;
        } catch (error) {
            console.log("Erro >>>", error);
            return false;        
        }
    }
    

    async delete () { 
        const conexao = Banco.getConexao();
        const sql = "DELETE FROM categoria WHERE idCategoria = ?";
    
        try {
            const [result] = await conexao.promise().execute(sql, [this._idCategoria]);
            return result.affectedRows > 0;
        } catch (error) {
            if (error.code === 'ER_ROW_IS_REFERENCED_2') {
                console.error("Não é possível excluir a categoria. Ela está relacionada a outra tabela.");
            } else {
                console.error("Erro ao deletar categoria:", error);
            
            }
        }
    }
    


    async validar_categoria () { 
        const conexao = Banco.getConexao()
        const sql = "select count(*) as qtd from categoria where nomeCategoria = ? ";
        try {
            const [result] = await conexao.promise().execute  (sql, [this._nomeCategoria])
            console.log(result)
            return result[0].qtd > 0;
        }catch (error) {
            console.log("Errro >>>" , error)
            return false        
        }
    }

    get idCategoria() {
        return this._idCategoria;
    }

    // Setter para _idCategoria
    set idCategoria(value) {
        this._idCategoria = value;
    }

    // Getter para _nomeCategoria
    get nomeCategoria() {
        return this._nomeCategoria;
    }

    // Setter para _nomeCategoria
    set nomeCategoria(value) {
        this._nomeCategoria = value;
    }

}