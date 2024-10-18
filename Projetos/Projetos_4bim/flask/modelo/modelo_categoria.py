import math
from modelo.Banco import Banco
from mysql.connector import Error

class Categoria :
    def __init__(self):
        self._idCategoria =None
        self._nomeCategoria =""



    def get_categoria(self):
        conexao = Banco.getConexao()
        if conexao : 
            cursor = conexao.cursor()
            sql = "select * from categoria where nomeCategoria = %s"
            cursor.execute(sql, (self.nomeCategoria,))
            result = cursor.fetchall()
            return result


    def get_allCategorias(self):
        conexao = Banco.getConexao()
        if conexao : 
            cursor = conexao.cursor()
            sql = "select * from categoria"
            cursor.execute(sql,)
            result = cursor.fetchall()
            return result
    
    def delete_categorias(self , idCategoria):
        conexao = Banco.getConexao()
        if conexao :
            try :  
                cursor = conexao.cursor()
                sql = "delete from categoria where idCategoria = %s"
                cursor.execute(sql, (idCategoria,))
                conexao.commit()
                return cursor.rowcount
            except Error as e : 
                print(f"Erro ao deletar categoria: {e}")
                return None

    def put_categoria(self , idCategoria):
        conexao = Banco.getConexao()
        if conexao :
            try :  
                cursor = conexao.cursor()
                sql = "update categoria set nomeCategoria = %s where idCategoria = %s"
                cursor.execute(sql, (self.nomeCategoria, idCategoria))
                conexao.commit()
                return cursor.rowcount
            except Error as e : 
                print(f"Erro ao deletar categoria: {e}")
                return None
    def post_categoria(self):
        conexao = Banco.getConexao()
        if conexao :
            try :  
                cursor = conexao.cursor()
                sql = "insert into categoria (nomeCategoria) values (%s)"
                cursor.execute(sql, (self.nomeCategoria,))
                conexao.commit()
                return cursor.rowcount
            except Error as e : 
                print(f"Erro ao deletar categoria: {e}")
                return None  
        
    @property
    def idCategoria(self):
        return self._idCategoria
    
    @idCategoria.setter
    def idCategoria(self,value):
        self._idCategoria = value


    @property
    def nomeCategoria(self):
        return self._nomeCategoria
    
    @nomeCategoria.setter
    def nomeCategoria(self,value):
        self._nomeCategoria = value
