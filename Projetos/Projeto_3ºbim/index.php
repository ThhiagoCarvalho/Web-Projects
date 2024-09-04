<?php
require_once("modelo/Router.php");

$roteador = new Router();

    $roteador->get("/usuarios/readpage/(\d+)/", function($pagina){
        require_once("controle/usuario/controle_usuario_read_page.php");
    });
    

    $roteador->get("usuarios/(\d+)", function($parametro_idusuario){
        require_once("controle/usuario/controle_usuario_read_by_id.php");
    });

    $roteador->get("/usuarios/categorias/readAll", function(){
        require_once("controle/usuario/controle_usuario_readCategoria.php");
    });
    $roteador->get("/usuarios/opcoes/readAll", function(){
        require_once("controle/usuario/controle_usuario_readOpcoes.php");
    });
    $roteador->post("usuarios", function(){
        require_once("controle/usuario/controle_usuario_create.php");
    });
    $roteador->delete("usuarios/(\d+)", function($parametro_idusuario){
        require_once("controle/usuario/controle_usuario_delete.php");
    });

    $roteador->put("usuarios/(\d+)", function($parametro_idusuario){
        require_once("controle/usuario/controle_usuario_update.php");
    });

    $roteador->put("/usuarios/senha", function(){
        require_once("controle/usuario/controle_usuario_trocarSenha.php");
    });


    $roteador->post ("logar",function(){
        require_once("controle/usuario/controle_usuario_login.php");

    });

    $roteador->post("/usuarios/csv", function(){
        require_once("controle/usuario/controle_usuario_createCSV.php");
    });
/*

opcao >>

*/

    $roteador->get("opcao/(\d+)", function($parametro_idOpcao){
        require_once("controle/opcao/controle_opcao_readByID.php");
    });
    $roteador->get("/opcao/readAll/(\d+)", function($parametro_escolhido){
        require_once("controle/opcao/controle_opcao_readAll.php");
    });
    $roteador->get("opcao/readpage/(\d+)", function($pagina){
        require_once("controle/opcao/controle_opcao_readByPage.php");
    });

    $roteador->post("opcao/cadastrar", function(){
        require_once("controle/opcao/controle_opcao_create.php");
    });
    $roteador->post("opcao/login", function(){
        require_once("controle/opcao/controle_opcao_login.php");
    });
    $roteador->post("/opcao/csv", function(){
        require_once("controle/opcao/controle_opcao_createCSV.php");
    });

    $roteador->put("opcao/(\d+)", function($parametro_idOpcao){
        require_once("controle/opcao/controle_opcao_update.php");
    });
    
    $roteador->delete("opcao/(\d+)", function($parametro_idOpcao){
        require_once("controle/opcao/controle_opcao_delete.php");
    });

    /*

categorias >>

*/

$roteador->get("categorias/(\d+)", function($parametro_IdCategoria){
    require_once("controle/categoria/controle_categoria_read_by_id.php");
});
$roteador->get("categorias/readByPage/(\d+)", function($pagina){
    require_once("controle/categoria/controle_categoria_read_by_page.php");
});

$roteador->get("categorias/readAll", function(){
    require_once("controle/categoria/controle_categoria.readAll.php");
});

$roteador->post("categorias/cadastrar", function(){
    require_once("controle/categoria/controle_categoria_create.php");
});

$roteador->post("categorias/login", function(){
    require_once("controle/categoria/controle_categoria_login.php");
});

$roteador->post("/categorias/csv", function(){
    require_once("controle/categoria/controle_categoria_createCSV.php");
});

$roteador->put("categorias/(\d+)", function($parametro_IdCategoria){
    require_once("controle/categoria/controle_categoria_update.php");
});
$roteador->delete("categorias/(\d+)", function($parametro_IdCategoria){
    require_once("controle/categoria/controle_categoria_delete.php");
});

    $roteador->run();
?>