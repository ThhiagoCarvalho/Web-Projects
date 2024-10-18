const express = require('express');
const path = require('path');
const app = express();
const portaServico = 3000;

const RouterUsuario = require("./router/RouterUsuario");
const RouterCategoria = require("./router/RouterCategoria");
const RouterOpcao = require("./router/RouterOpcao");

app.use(express.json()); // Middleware necessário para parsear JSON
app.use(express.static('js'));
app.use('/html', express.static(path.join(__dirname, 'view/html')));
app.use('/css', express.static(path.join(__dirname, 'view/css')));

app.get('/', (req, res) => {
    res.sendFile(path.join(__dirname, 'view/html/cadastro.html'));
});

const roteadorUsuario = new RouterUsuario();
const roteadorCategoria = new RouterCategoria();
const roteadorOpcao = new RouterOpcao();

app.use('/usuarios', roteadorUsuario.criarRotasUsuarios());
app.use('/categorias', roteadorCategoria.criarRotasCategorias());
app.use('/opcoes', roteadorOpcao.criarRotasOpcao());

app.listen(portaServico, () => {
    console.log("Api rodando na porta " + portaServico);
});