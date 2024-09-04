const dadosUsuarios = localStorage.getItem("dados")
const objUsuario = JSON.parse(dadosUsuarios);

const h1 = document.createElement('h1');


const divCumprimento = document.getElementById('cumprimento')
h1.textContent = "Seja bem-vindo " + objUsuario.usuario.nomeUsuario + "!";
divCumprimento.appendChild(h1);




function showContent(tab) {
    // Esconder todos os conteúdos
    const contents = document.querySelectorAll('.content');
    contents.forEach(content => content.classList.remove('active'));

    // Mostrar o conteúdo da aba clicada
    const activeContent = document.getElementById(tab);
    activeContent.classList.add('active');
}


function create_Categorias(){

    
}