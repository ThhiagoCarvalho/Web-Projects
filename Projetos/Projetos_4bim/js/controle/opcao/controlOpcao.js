const express = require('express');
const Opcao = require("../../modelo/Opcao");
const MeuTokenJWT = require("../../modelo/MeuTokenJWT")


module.exports = class ControlOpcao {

    async controle_opcao_post (request , response ) { 
        console.log(request.body)
        const nomeOpcao = request.body.nomeOpcao
        const horarioFuncionamento = request.body.horarioFuncionamento
        const localizacaoOpcao = request.body.localizacaoOpcao
        const custoOpcao = request.body.custoOpcao
        const categoria_idCategoria = request.body.categoria_idCategoria
        const descricao = request.body.descricao

        const opcao = new Opcao()
        opcao.nomeOpcao = nomeOpcao
        opcao.horarioFuncionamento = horarioFuncionamento
        opcao.localizacaoOpcao = localizacaoOpcao
        opcao.custoOpcao = custoOpcao
        opcao.categoria_idCategoria = categoria_idCategoria
        opcao.descricao = descricao

        const opcaoExistente  = await opcao.create();
        console.log(opcaoExistente)
        const objResposta = {
            cod: 1,
            status: opcaoExistente,
            msg: opcaoExistente ? 'Opcao criado com sucesso' : 'Erro ao criar Opcao'
        };
        response.status(200).send(objResposta);
    }

    async controle_opcao_update (request , response ) { 
        const idOpcao = request.params.idOpcao
        const nomeOpcao = request.body.nomeOpcao
        const horarioFuncionamento = request.body.horarioFuncionamento
        const localizacaoOpcao = request.body.localizacaoOpcao
        const custoOpcao = request.body.custoOpcao
        const categoria_idCategoria = request.body.categoria_idCategoria
        const descricao = request.body.descricao

        const opcao = new Opcao()
        opcao.idOpcao = idOpcao
        opcao.nomeOpcao = nomeOpcao
        opcao.horarioFuncionamento = horarioFuncionamento
        opcao.localizacaoOpcao = localizacaoOpcao
        opcao.custoOpcao = custoOpcao
        opcao.categoria_idCategoria = categoria_idCategoria
        opcao.descricao = descricao

        const opcaoAtualizada  = await opcao.update();

        const objResposta = {
            cod: 1,
            status: opcaoAtualizada,
            msg: opcaoAtualizada ? 'Opcao atualizada com sucesso' : 'Erro ao atualizada Opcao'
        };
        response.status(200).send(objResposta);
    }

    async controle_opcao_delete (request , response ) { 
        const idOpcao = request.params.idOpcao

        const opcao = new Opcao()
        opcao.idOpcao = idOpcao
    
        const opcaoExcluida  = await opcao.delete();

        const objResposta = {
            cod: 1,
            status: opcaoExcluida,
            msg: opcaoExcluida ? 'Opcao excluida com sucesso' : 'Erro ao excluir Opcao'
        };
        response.status(200).send(objResposta);
    }


    async controle_opcao_get_categorias (request , response ) { 
        const idCategoria = parseFloat(request.params.idOpcao)
        const opcao = new Opcao
        opcao.categoria_idCategoria  = idCategoria
        const buscaOpcao  = await opcao.get_id_categorias();

        const objResposta = {
            cod: 1,
            status: true,
            dados  : buscaOpcao
        };
        response.status(200).send(objResposta);
    }

    async controle_opcao_get_nomeOpcoes (request , response ) { 
        const nomeOpcao = request.body.nomeOpcao
        const opcao = new Opcao
        opcao.nomeOpcao  = nomeOpcao
        const buscaOpcao  = await opcao.get_nomeOpcao();

        const objResposta = {
            cod: 1,
            status: true,
            dados  : buscaOpcao
        };
        response.status(200).send(objResposta);
    }


    async controle_opcao_get_id (request , response ) { 
        const idOpcao = parseFloat(request.params.idOpcao)
        const opcao = new Opcao
        opcao.idOpcao  = idOpcao
        const buscaOpcao  = await opcao.get_id();

        const objResposta = {
            cod: 1,
            status: true,
            dados  : buscaOpcao
        };
        response.status(200).send(objResposta);
    }
}
