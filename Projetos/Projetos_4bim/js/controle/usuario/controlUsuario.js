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

    async  controle_usuario_post_json(request, response) {
        const objResposta = {
            codigo: 0,
            status: false,
            msg: '',
            usuariosDuplicados: [],
            totalUsuarios: 0
        };
    
        try {
            const usuarios = request.body.usuarios; // Assumindo que o JSON vem no formato: { "usuarios": [ ... ] }
            let qtdUsuariosCadastrados = 0;
            let qtdUsuariosDuplicados = 0;
            const usuariosDuplicados = [];
    
            // Processa cada usuário do arquivo JSON
            for (let usuarioData of usuarios) {
                const usuario = new Usuario();
                usuario.nomeUsuario = usuarioData.nomeUsuario;
                usuario.emailUsuario = usuarioData.emailUsuario;
                usuario.senhaUsuario = usuarioData.senhaUsuario;
                usuario.idade = usuarioData.idade;
                usuario.dataDate = usuarioData.dataDate;
                usuario.categoria_idCategoria = usuarioData.categoria_idCategoria;
    
                // Verifica se o e-mail já está cadastrado
                const isEmailDuplicado = await usuario.verificarEmail();
    
                if (!isEmailDuplicado) {
                    const isCadastrado = await usuario.cadastrar();
                    if (isCadastrado) {
                        qtdUsuariosCadastrados++;
                    }
                } else {
                    qtdUsuariosDuplicados++;
                    usuariosDuplicados.push(usuario.emailUsuario);
                }
            }
    
            // Determina a mensagem final com base nos resultados
            if (qtdUsuariosCadastrados === 0 && qtdUsuariosDuplicados > 0) {
                objResposta.codigo = 1;
                objResposta.status = false;
                objResposta.msg = `Nenhum cadastro feito. Os seguintes usuários já estão cadastrados: ${usuariosDuplicados.join(", ")}`;
            } else if (qtdUsuariosCadastrados > 0 && qtdUsuariosDuplicados > 0) {
                objResposta.codigo = 2;
                objResposta.status = true;
                objResposta.msg = `Alguns usuários foram cadastrados. No entanto, os seguintes usuários já estão cadastrados: ${usuariosDuplicados.join(", ")}`;
            } else if (qtdUsuariosCadastrados > 0 && qtdUsuariosDuplicados === 0) {
                objResposta.codigo = 3;
                objResposta.status = true;
                objResposta.msg = "Todos os usuários foram cadastrados com sucesso";
                objResposta.totalUsuarios = qtdUsuariosCadastrados;
            }
    
            objResposta.usuariosDuplicados = usuariosDuplicados;
    
            response.status(200).json(objResposta);
        } catch (error) {
            objResposta.codigo = 1;
            objResposta.status = false;
            objResposta.erro = error.message;
            response.status(500).json(objResposta);
        }
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