from modelo.modelo_categoria import Categoria
from flask import jsonify  # Importação necessária
from modelo.MeuTokenJWT import MeuTokenJWT

class categoriaController: 
    def __init__(self):
        self._categoria = Categoria()


    def validar_nomeCategoria(self):
        qtd = len(self._categoria.nomeCategoria)
        if qtd < 4 :
            raise ValueError("A categoria deve possuir ao menos 5 caracteres")
        

        
    def get_categoria(self):
        buscaCategorias = self._categoria.get_categoria()
        if buscaCategorias:
            msg = "Categoria buscada com sucesso"
        else :
            msg = "Erro ao buscar categoria"
            
        return jsonify({
                "status": True if buscaCategorias else False,
                "msg": msg
            }), 200    
    

    def delete_categorias(self):
        linhaAfetadas = self._categoria.delete_categorias()
        if linhaAfetadas:
            msg = "Categoria excluida com sucesso"
        else :
            msg = "Erro ao excluir categoria"
        return jsonify({
                "status": True if linhaAfetadas else False,
                "msg": msg
            }), 200
    
    
    
    def put_categorias(self , idCategoria):
        self.validar_nomeCategoria()
        updCategorias = self._categoria.put_categoria(idCategoria)
        if  updCategorias:
            msg = "Sucesso ao atualizar categoria"
        else:
            msg = "Erro ao atualizar categoria"

        return jsonify({
                "status": True if updCategorias else False,
                "msg": msg
            }), 200   
    
    def post_categorias(self):
        self.validar_nomeCategoria()
        cadastroCategorias = self._categoria.post_categoria()
        if  cadastroCategorias:
            msg = "Sucesso ao cadastrar categoria"
        else:
            msg = "Erro ao cadastrar categoria"
        return jsonify({
                "status": True if cadastroCategorias else False,
                "msg": msg 
            }), 200   


    @property
    def categoria(self):
        return self._categoria
    
    @categoria.setter    
    def set_categoria(self, value):
        self._categoria.nomeCategoria = value