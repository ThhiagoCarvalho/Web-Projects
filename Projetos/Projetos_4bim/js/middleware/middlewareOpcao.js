const express = require('express');
const Opcao = require("../modelo/Opcao");
const MeuTokeJWT = require("../modelo/MeuTokenJWT")
module.exports = class middlewareOpcao {


    validar_nomeOpcao = (req, res, next) => {
        const  nomeOpcao  = req.body.nomeOpcao;
        if (!nomeOpcao || nomeOpcao.length < 3) {
            const objResposta = {
                msg : "Nome da opção deve ter pelo menos 3 caracteres" ,
                status : false
            }
            res.status(200).send(objResposta);
        }else { 
            next();
        }
    };



    validar_localizacaoOpcao = (req, res, next) => {
        const  localizacaoOpcao  = req.body.localizacaoOpcao;
        if (!localizacaoOpcao || localizacaoOpcao.trim().length === 0) {
            const objResposta = {
                msg : "Localização da opção não pode estar vazia" ,
                status : false
            }
            res.status(200).send(objResposta);
        }else { 
            next();
        }
    };


    async validar_opcao (req, res, next)  {
        const  nomeOpcao  = req.body.nomeOpcao;
        console.log(nomeOpcao)
        const objOpcao = new Opcao()
        objOpcao.nomeOpcao = nomeOpcao
        const existeOpcao = await objOpcao.validar_opcao() 
        console.log(existeOpcao)
        if (existeOpcao) {
            const objResposta = {
                msg : "Esta opcao ja existe" ,
                status : false
            }
            res.status(200).send(objResposta);
        
        }else { 
            next();
        }
    };


    async validar_Idopcao (req, res, next)  {
        const  idOpcao  = req.params.idOpcao;
        const objOpcao = new Opcao()
        objOpcao.idOpcao = idOpcao
        const existeOpcao = await objOpcao.validar_IDopcao() 
        console.log(existeOpcao)
        if (existeOpcao) {
            next();
        
        }else { 
            const objResposta = {
                msg : "Esta opcao nao existe" ,
                status : false
            }
            res.status(200).send(objResposta);        }
    };


    async validar_opcao_existente (req, res, next)  {
        const  nomeOpcao  = req.body.nomeOpcao;
        console.log(nomeOpcao)
        const objOpcao = new Opcao()
        objOpcao.nomeOpcao = nomeOpcao
        const existeOpcao = await objOpcao.validar_opcao() 
        console.log(existeOpcao)
        if (existeOpcao) {
            next();        
        }else { 
            const objResposta = {
                msg : "Esta opcao nao existe" ,
                status : false
            }
            res.status(200).send(objResposta);
        }
    };

    validar_autenticacao = (req, res, next) => {
        const  objToken = new MeuTokeJWT()
        const header = req.headers['authorization'];
        console.log("HEader> " , header)
        if (objToken.validarToken(header) == true) {
            next();
        }else { 
            const objResposta = {
                msg : "Token invalido" ,
                status : false
            }
            res.status(200).send(objResposta);
            next();
        }
    };
    

    validar_categoria_descricao = (req, res, next) => {
        const  descricaoCategoria  = req.body.descricao;
        if (!descricaoCategoria || descricaoCategoria.length < 5) {
            const objResposta = {
                msg : "A descrição da categoria deve ter pelo menos 5 caracteres" ,
                status : false
            }
            res.status(200).send(objResposta);
        }else { 
            next();
        }
    };


}