const express = require('express');
const controlOpcao = require("../controle/opcao/controlOpcao")

const MiddlewareOpcao = require("../middleware/middlewareOpcao")
module.exports = class RouterOpcao {

    constructor () { 
        this._router = express.Router()
        this._controleOpcao = new controlOpcao()
        this._middleOpcao = new MiddlewareOpcao ()
    }

    criarRotasOpcao () {
        this._router.post ('/' ,
            this._middleOpcao.validar_autenticacao,

            this._middleOpcao.validar_nomeOpcao,
            this._middleOpcao.validar_localizacaoOpcao,
            this._middleOpcao.validar_categoria_descricao,


            this._middleOpcao.validar_opcao,

            this._controleOpcao.controle_opcao_post
        )

        this._router.put ('/:idOpcao' ,
            this._middleOpcao.validar_autenticacao,

            this._middleOpcao.validar_nomeOpcao,
            this._middleOpcao.validar_localizacaoOpcao,
            this._middleOpcao.validar_categoria_descricao,
        
            this._controleOpcao.controle_opcao_update
        )

        this._router.delete ('/:idOpcao' ,
            this._middleOpcao.validar_autenticacao,

            this._controleOpcao.controle_opcao_delete
        )


        this._router.get ('/readAll/:idOpcao' ,
            this._middleOpcao.validar_autenticacao,

            this._controleOpcao.controle_opcao_get_categorias
        )

        this._router.post ('/nomes/' ,
            this._middleOpcao.validar_autenticacao,

            this._middleOpcao.validar_opcao_existente,
            this._controleOpcao.controle_opcao_get_nomeOpcoes
        )
        
        this._router.get ('/:idOpcao' ,
            this._middleOpcao.validar_autenticacao,

            this._controleOpcao.controle_opcao_get_id
        )
        return this._router
    }
}