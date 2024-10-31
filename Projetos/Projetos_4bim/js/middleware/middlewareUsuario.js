const Usuario = require("../modelo/Usuario");
const express = require('express');
const multer = require('multer');
const fs = require('fs');
const bodyParser = require('body-parser');

const app = express();

const upload = multer({ dest: 'uploads/' });

app.use(express.json()); // Middleware necessário para parsear JSON
app.use(express.static('js'));
// Middleware para JSON, mas sem interferir em multipart/form-data
app.use(bodyParser.json());


module.exports = class MiddlewareUsuario {
    uploadJSON = [
        upload.single('variavelArquivo'), // Middleware de upload do multer
        (req, res, next) => {
            if (req.file) {
                // Leia o conteúdo do arquivo JSON
                const nomeArquivo = req.file.path; // Aqui você obtém o caminho do arquivo
            console.log(nomeArquivo); 
                fs.readFile(req.file.path, 'utf8', (err, data) => {
                    if (err) {
                        return res.status(500).json({ msg: 'Erro ao ler o arquivo' });
                    }
                    req.body = JSON.parse(data); // Parse o JSON e insira no req.body
                    fs.unlink(req.file.path, () => {}); // Remove o arquivo após a leitura
                    next(); // Continue para o próximo middleware
                });
            } else {
                return res.status(400).json({ msg: 'Arquivo não encontrado' });
            }
        }
    ];

    

    
    validar_nome(req, res, next) {
        // Verifique se `usuarios` está presente no corpo da requisição
        if (!req.body.usuarios) {
            return res.status(400).json({
                msg: "Usuários não fornecidos no corpo da requisição",
                status: false
            });
        }
    
        // Validação para quando `usuarios` não é um array (usuário único)
        if (!Array.isArray(req.body.usuarios)) {
            const nome = req.body.usuarios.nomeUsuario;
            if (!nome || nome.length < 3) {
                return res.status(400).json({
                    msg: "Nome deve ter pelo menos 3 caracteres",
                    status: false
                });
            }
        } else {
            // Validação para quando `usuarios` é um array (múltiplos usuários)
            const { usuarios } = req.body;
            for (let i = 0; i < usuarios.length; i++) {
                if (!usuarios[i].nomeUsuario || usuarios[i].nomeUsuario.length < 3) {
                    return res.status(400).json({
                        cod: 1,
                        status: false,
                        msg: `O nome do usuário ${i + 1} é inválido ou muito curto.`,
                    });
                }
            }
        }
        next();
    }

    async validar_email(req, res, next) {
        const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!Array.isArray(req.body.usuarios)) {
            const email = req.body.emailUsuario;
            if (!email || !regexEmail.test(email)) {
                return res.status(400).json({
                    msg: "E-mail inválido",
                    status: false
                });
            }
        } else {
            const { usuarios } = req.body;
            for (let i = 0; i < usuarios.length; i++) {
                if (!usuarios[i].emailUsuario || !regexEmail.test(usuarios[i].emailUsuario)) {
                    return res.status(400).json({
                        cod: 2,
                        status: false,
                        msg: `O e-mail do usuário ${i + 1} é inválido.`,
                    });
                }
            }
        }
        next();
    }

    validar_senha(req, res, next) {
        if (!Array.isArray(req.body.usuarios)) {
            const senha = req.body.senhaUsuario;
            if (!senha || senha.length < 5) {
                return res.status(400).json({
                    msg: "A senha deve ter pelo menos 5 caracteres",
                    status: false
                });
            }
        } else {
            const { usuarios } = req.body;
            for (let i = 0; i < usuarios.length; i++) {
                if (!usuarios[i].senhaUsuario || usuarios[i].senhaUsuario.length < 6) {
                    return res.status(400).json({
                        cod: 3,
                        status: false,
                        msg: `A senha do usuário ${i + 1} é muito curta.`,
                    });
                }
            }
        }
        next();
    }

    validar_idade(req, res, next) {
        if (!Array.isArray(req.body.usuarios)) {
            const idade = req.body.idade;
            if (!idade || isNaN(idade) || idade <= 0) {
                return res.status(400).json({
                    msg: "Idade inválida",
                    status: false
                });
            }
        } else {
            const { usuarios } = req.body;
            for (let i = 0; i < usuarios.length; i++) {
                const idade = usuarios[i].idade;
                if (!idade || isNaN(idade) || idade < 18) {
                    return res.status(400).json({
                        cod: 4,
                        status: false,
                        msg: `A idade do usuário ${i + 1} é inválida ou está abaixo do mínimo permitido.`,
                    });
                }
            }
        }
        next();
    }

    validar_dataDate(req, res, next) {
        const hoje = new Date();
        hoje.setHours(0, 0, 0, 0);

        if (!Array.isArray(req.body.usuarios)) {
            const dataDate = req.body.dataDate;
            if (!dataDate) {
                return res.status(400).json({
                    msg: "A data é obrigatória",
                    status: false
                });
            }
            const dataSelecionada = new Date(dataDate);
            if (dataSelecionada < hoje) {
                return res.status(400).json({
                    msg: "A data escolhida não pode ser no passado",
                    status: false
                });
            }
        } else {
            const { usuarios } = req.body;
            for (let i = 0; i < usuarios.length; i++) {
                const dataDate = new Date(usuarios[i].dataDate);
                if (isNaN(dataDate.getTime()) || dataDate < hoje) {
                    return res.status(400).json({
                        cod: 5,
                        status: false,
                        msg: `A data de ${i + 1} é inválida.`,
                    });
                }
            }
        }
        next();
    }

    async validar_usuario(req, res, next) {
        const emailUsuario = req.body.emailUsuario;
        const objUsuario = new Usuario();
        objUsuario.emailUsuario = emailUsuario;

        const existeUsuario = await objUsuario.verificarEmail();
        if (existeUsuario) {
            return res.status(400).json({
                msg: "Este email já está cadastrado",
                status: false
            });
        }
        next();
    }

    async validar_usuario_logado(req, res, next) {
        const emailUsuario = req.body.emailUsuario;
        const objUsuario = new Usuario();
        objUsuario.emailUsuario = emailUsuario;

        const usuario = await objUsuario.verificarEmail();
        if (usuario) {
            req.usuario = usuario;
            next();
        } else {
            return res.status(400).json({
                msg: "Este email não está cadastrado!",
                status: false
            });
        }
    }
};
