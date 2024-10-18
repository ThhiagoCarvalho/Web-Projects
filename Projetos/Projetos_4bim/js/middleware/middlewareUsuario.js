const express = require('express');
const Usuario = require("../modelo/Usuario")

module.exports = class middlewareUsuario {

validar_nome = (req, res, next) => {

    const  nome  = req.body.nomeUsuario;

    if (!nome || nome.length < 3) {
        const objResposta = {
            msg : "Nome deve ter pelo menos 3 caracteress" ,
            status : false
        }
        res.status(200).send(objResposta);
    }else { 
        next();
    }
};

async validar_email  (req, res, next) {
    console.log(req)

    const  email  = req.body.emailUsuario;
    console.log(req.body)
    const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!email || !regexEmail.test(email)) {
        
        const objResposta = {
            msg : "E-mail inválido" ,
            status : false
        }
        res.status(200).send(objResposta);
    }else { 
        next();
    }
};

validar_senha = (req, res, next) => {
    const  senha  = req.body.senhaUsuario;
    if (!senha || senha.length < 5) {
        const objResposta = {
            msg : "A senha deve ter pelo menos 5 caracteres" ,
            status : false
        }
        res.status(200).send(objResposta);
    }else { 
        next();
    }
};

validar_idade = (req, res, next) => {
    const  idade  = req.body.idade;
    if (!idade || isNaN(idade) || idade <= 0) {
        const objResposta = {
            msg : "Idade inválida." ,
            status : false
        }
        res.status(200).send(objResposta);
    }else { 
        next();
    }
};

validar_dataDate = (req, res, next) => {
    const  dataDate  = req.body.dataDate;

    if (!dataDate) {
        const objResposta = {
            msg : "A data é obrigatória" ,
            status : false
        }
        res.status(200).send(objResposta);
    }

    const hoje = new Date();  
    hoje.setHours(0, 0, 0, 0); 

    const dataSelecionada = new Date(dataDate);

    if (dataSelecionada < hoje) {
        const objResposta = {
            msg : "A data escolhida não pode ser no passado" ,
            status : false
        }
        res.status(200).send(objResposta);
    }else { 
        next();
    }
};



async validar_usuario (req, res, next) {
    
    const emailUsuario = req.body.emailUsuario
    const objUsuario = new Usuario () 
    objUsuario.emailUsuario = emailUsuario

    const existeUsuario =  await objUsuario.verificarEmail()
    console.log(">>?>" + existeUsuario)

    if  (existeUsuario) {
        const objResposta = {
            msg : "Este email ja esta cadastrado" ,
            status : false
        }
        res.status(200).send(objResposta);
    }else { 
        next();

    }
};

async validar_usuario_logado  (req, res, next)  {
    
    const emailUsuario = req.body.emailUsuario
    const objUsuario = new Usuario () 
    objUsuario.emailUsuario = emailUsuario

    const usuario =  await objUsuario.verificarEmail ()
    
    if  (usuario) {
        console.log(usuario)
        req.usuario = usuario;
        next();

    }else { 
        const objResposta = {
            msg : "Este email nao esta cadastrado!" ,
            status : false
        }
        res.status(200).send(objResposta);

    }
};
}