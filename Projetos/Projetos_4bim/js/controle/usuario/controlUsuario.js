const express = require('express');
const Usuario = require("../../modelo/Usuario");
const MeuTokenJWT = require("../../modelo/MeuTokenJWT")


module.exports = class ControlUsuario {

    async controle_usuario_post (request , response ) { 
        const nomeUsuario = request.body.nomeUsuario
        const emailUsuario = request.body.emailUsuario
        const senhaUsuario = request.body.senhaUsuario
        const idade = request.body.idade
        const dataDate = request.body.dataDate
        const categoria_idCategoria = request.body.idCategoria

        const usuario = new Usuario()
        usuario.nomeUsuario = nomeUsuario
        usuario.emailUsuario = emailUsuario
        usuario.senhaUsuario = senhaUsuario
        usuario.idade = idade
        usuario.dataDate = dataDate
        usuario.categoria_idCategoria = categoria_idCategoria

        const usuarioExistente  = await usuario.cadastrar();

        const objResposta = {
            cod: 1,
            status: usuarioExistente,
            msg: usuarioExistente ? 'Usuario criado com sucesso' : 'Erro ao criar conta'
        };
        response.status(200).send(objResposta);
    }


    async controle_usuario_update (request , response ) { 
        const emailUsuario = request.body.emailUsuario
        const senhaUsuario = request.body.senhaUsuario

        const usuario = new Usuario()
        usuario.emailUsuario = emailUsuario
        usuario.senhaUsuario = senhaUsuario

        const sucesso  = await usuario.updateSenha();

        const objResposta = {
            cod: 1,
            status: sucesso,
            msg: sucesso ? 'Usuario com senha atualizada!' : 'Erro ao mudar de senha'
        };
        response.status(200).send(objResposta);
    }
    


    async controle_usuario_get_categorias (request , response ) { 

        const usuario = new Usuario()

        const categorias  = await usuario.get_categorias();

        const objResposta = {
            cod: 1,
            status: true,
            dados : categorias
        };
        response.status(200).send(objResposta);
    }

    async controle_usuario_login (request , response ) { 
        const objUsuario = request.usuario

        console.log (objUsuario)
        try { 
            const objToken = new MeuTokenJWT ()
            const objClaimsToken = {
                nomeUsuario : objUsuario.nomeUsuario ,
                emailUsuario : objUsuario.emailUsuario
            };

            const novoToken = objToken.gerarToken(objClaimsToken)

            const objResposta = {
                resposta : "Sucesso ao logar" ,
                token : novoToken,
                usuario : objUsuario
              
            }
            response.status(200).send(objResposta);

        } catch (error) { 
            console.log("Errro >>>" , error)
            return false
        }
    }

}