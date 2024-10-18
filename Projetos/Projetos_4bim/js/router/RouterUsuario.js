const express = require('express');
const controlUsuario = require("../controle/usuario/controlUsuario")

const MiddlewareUsuario = require("../middleware/middlewareUsuario")
module.exports = class RouterUsuario {

    constructor () { 
        this._router = express.Router()
        this._controleUsuario = new controlUsuario()
        this._middleUsuario = new MiddlewareUsuario ()
    }

    criarRotasUsuarios () {
        this._router.post ('/' ,

            this._middleUsuario.validar_nome,
            this._middleUsuario.validar_email,
            this._middleUsuario.validar_senha,
            this._middleUsuario.validar_idade,
            this._middleUsuario.validar_dataDate,
            this._middleUsuario.validar_usuario,

            this._controleUsuario.controle_usuario_post
        )
        
        this._router.post ('/login' ,
            this._middleUsuario.validar_email,
            this._middleUsuario.validar_senha,

            this._middleUsuario.validar_usuario_logado,
            this._controleUsuario.controle_usuario_login
        )

        this._router.put ('/senha' ,
            this._middleUsuario.validar_email,
            this._middleUsuario.validar_senha,

            this._middleUsuario.validar_usuario_logado,
            this._controleUsuario.controle_usuario_update
        )


        this._router.get ('/categorias' ,
            this._controleUsuario.controle_usuario_get_categorias
        )

    
        return this._router
    }
}