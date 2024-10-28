const express = require('express');
const Categoria = require("../modelo/Categoria");

const MeuTokeJWT  = require("../modelo/MeuTokenJWT")
module.exports = class middlewareCategoria {



    async validar_IsCategoria(req, res, next)  {
        const  nomeCategoria  = req.body.nomeCategoria;
        const objCategoria = new Categoria()
        objCategoria.nomeCategoria = nomeCategoria
        const existeCategoria = await objCategoria.validar_categoria()
        if (existeCategoria) {
            const objResposta = {
                msg : "Esta categoria ja existe" ,
                status : false
            }
            res.status(200).send(objResposta);
        }else { 
            next();
        }
    };


    validar_nomeCategoria = (req, res, next) => {
        const  nomeCategoria  = req.body.nomeCategoria;
        if (!nomeCategoria || nomeCategoria.length < 3) {
            const objResposta = {
                msg : "Nome da categoria deve ter pelo menos 3 caracteres" ,
                status : false
            }
            res.status(200).send(objResposta);
        }else { 
            next();
        }
    };

    validar_autenticacao = (req, res, next) => {
        const  objToken = new MeuTokeJWT()
        const header = req.headers['authorization'];
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


    async validar_categoria_existente (req, res, next)  {
        const  nomeCategoria  = req.body.nomeCategoria;
        const objCategoria = new Categoria()

        objCategoria.nomeCategoria = nomeCategoria
        const existeCategoria = await objCategoria.validar_categoria() 
        
        if (existeCategoria) {
            next();        
        }else { 
            const objResposta = {
                msg : "Esta categoria nao existe" ,
                status : false
            }
            res.status(200).send(objResposta);
        }
    };


    async validar_Idcategoria_existente (req, res, next)  {
        const  idCategoria  = req.params.idCategoria;
        const objCategoria = new Categoria()

        objCategoria.idCategoria = idCategoria
        const existeCategoria = await objCategoria.validar_IDcategoria() 
        console.log("existeCategoria" >>> + existeCategoria)
        if (existeCategoria) {
            next();        
        }else { 
            const objResposta = {
                msg : "Esta categoria nao existe" ,
                status : false
            }
            res.status(200).send(objResposta);
        }
    };

}