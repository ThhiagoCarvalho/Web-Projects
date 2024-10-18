from flask import Flask, jsonify, request, Response
from controle.controle_categoria import categoriaController

app = Flask("api categoria")

def handle_validation_error(e):
    return jsonify({"erro": str(e)}), 400


@app.route('/categorias', methods=['get'])
def get_categorias ():
    try: 
        body = request.get_json()
        controlCategoria = categoriaController()
        controlCategoria.categoria.nomeCategoria = body['nomeCategoria']
        return controlCategoria.get_categoria()

    except ValueError as error :
        return handle_validation_error(error)
    

    
@app.route('/categorias/<float:idCategoria>', methods=['delete'])
def delete_categorias (idCategoria):
    try: 
        controlCategoria = categoriaController()
        controlCategoria.categoria.idCategoria = idCategoria
        return controlCategoria.delete_categorias(idCategoria)

    except ValueError as error :
        return handle_validation_error(error)
    


@app.route('/categorias/<float:idCategoria>', methods=['put'])
def put_categorias (idCategoria):
    try: 
        body = request.get_json()
        controlCategoria = categoriaController()
        controlCategoria.categoria.idCategoria = idCategoria
        controlCategoria.categoria.nomeCategoria = body['nomeCategoria']

        return controlCategoria.put_categorias(idCategoria)
    except ValueError as error :
        return handle_validation_error(error)
    

@app.route('/categorias/<float:idCategoria>', methods=['post'])
def post_categorias ():
    try: 
        body = request.get_json()
        controlCategoria = categoriaController()
        controlCategoria.categoria.nomeCategoria = body['nomeCategoria']
        return controlCategoria.post_categorias()

    except ValueError as error :
        return handle_validation_error(error)


app.run(host='0.0.0.0', port=3000)

