const express = require('express');
const Categoria = require("../../modelo/Categoria");
const MeuTokenJWT = require("../../modelo/MeuTokenJWT")


module.exports = class ControlOpcao {

    async controle_categoria_post (request , response ) { 
        console.log(request.body)
        const nomeCategoria = request.body.nomeCategoria


        const categoria = new Categoria()
        categoria.nomeCategoria = nomeCategoria
 

        const categoriaExistente  = await categoria.create();
        console.log(categoriaExistente)
        const objResposta = {
            cod: 1,
            status: categoriaExistente,
            msg: categoriaExistente ? 'categoria criado com sucesso' : 'Erro ao criar categoria'
        };
        response.status(200).send(objResposta);
    }

    async controle_categoria_update (request , response ) { 
        const idCategoria = request.params.idCategoria
        const nomeCategoria = request.body.nomeCategoria
    
        const categoria = new Categoria()
        categoria.idCategoria = idCategoria
        categoria.nomeCategoria = nomeCategoria

        const categoriaAtualizada  = await categoria.update();

        const objResposta = {
            cod: 1,
            status: categoriaAtualizada,
            msg: categoriaAtualizada ? 'categoria atualizada com sucesso' : 'Erro ao atualizada categoria'
        };
        response.status(200).send(objResposta);
    }

    async controle_categoria_delete (request , response ) { 
        const idCategoria = request.params.idCategoria

        const categoria = new Categoria()
        categoria.idCategoria = idCategoria
    
        const categoriaExcluida  = await categoria.delete();

        const objResposta = {
            cod: 1,
            status: categoriaExcluida,
            msg: categoriaExcluida ? 'categoria excluida com sucesso' : 'Erro ao excluir categoria, sugestao: exclua todas as opcoes relacionadaas a ela'
        };
        response.status(200).send(objResposta);
    }


    async controle_categoria_get_nome (request , response ) { 
        const nomeCategoria = request.body.nomeCategoria
        const categoria = new Categoria
        categoria.nomeCategoria  = nomeCategoria
        const buscarCategoria  = await categoria.get_nome_categorias();

        const objResposta = {
            cod: 1,
            status: true,
            dados  : buscarCategoria
        };
        response.status(200).send(objResposta);
    }



    async controle_categoria_get_all (request , response ) { 
        const categoria = new Categoria
        const buscarCategoria  = await categoria.get_all();

        const objResposta = {
            cod: 1,
            status: true,
            dados  : buscarCategoria
        };
        response.status(200).send(objResposta);
    }
}
