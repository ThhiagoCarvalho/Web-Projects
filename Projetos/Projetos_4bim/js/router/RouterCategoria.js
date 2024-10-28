const express = require('express');
const controlCategoria = require("../controle/categoria/controlCategoria")

const MiddlewareCategoria = require("../middleware/middlewareCategoria")
module.exports = class RouterCategoria {

    constructor () { 
        this._router = express.Router()
        this._controleCategoria = new controlCategoria()
        this._middleCategoria= new MiddlewareCategoria ()
    }

        criarRotasCategorias () {
        this._router.post ('/' ,
            this._middleCategoria.validar_autenticacao,
            this._middleCategoria.validar_nomeCategoria,
            this._middleCategoria.validar_IsCategoria,
            this._controleCategoria.controle_categoria_post
        )

        this._router.put ('/:idCategoria' ,      
            this._middleCategoria.validar_autenticacao,
            this._middleCategoria.validar_Idcategoria_existente,

            this._controleCategoria.controle_categoria_update
        )

        this._router.delete ('/:idCategoria' ,
            this._middleCategoria.validar_autenticacao,
            this._middleCategoria.validar_Idcategoria_existente,

            this._controleCategoria.controle_categoria_delete
        )


        this._router.get ('/' ,

            this._controleCategoria.controle_categoria_get_all
        )
        // busca os dados a partir do nome da categoria
        this._router.post ('/getCategorias/' ,
            this._middleCategoria.validar_autenticacao,

            this._middleCategoria.validar_categoria_existente,
            this._controleCategoria.controle_categoria_get_nome
        )

        return this._router
    }
}

