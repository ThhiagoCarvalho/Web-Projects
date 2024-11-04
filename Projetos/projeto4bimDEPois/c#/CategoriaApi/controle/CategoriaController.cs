using Microsoft.AspNetCore.Mvc;
using CategoriaApi.Modelo;

namespace CategoriaApi.Control
{
    [ApiController] // Indica que esta classe é um controlador de API
    [Route("/[controller]")]
    public class CategoriaController : ControllerBase
    {

        [HttpGet("/categorias/{idCategoria}")]
        public IActionResult Get_IdCategorias(uint idCategoria)
        {
            Categoria objcategoria = new Categoria();
            objcategoria.IdCategoria = idCategoria;
            object resposta = new
{
                categorias = objcategoria.ReadById() // Obtém os dados da categoria pelo ID
            };

            return Ok(resposta);
        }

        // GET todas as categorias
        [HttpGet("/categorias/")]
        public IActionResult Get_Categorias()
        {
            Categoria objcategoria = new Categoria();
            object resposta = new
            {
                status = true, // Define o status como sucesso
                mensagem = "Executado com sucesso",
                categorias = objcategoria.ReadCategoria() // Obtém os dados das categorias
            };

            return Ok(resposta);
        }

        // POST para criar uma nova categoria
        [HttpPost("/categorias/")]
        public IActionResult Post_Categorias([FromBody] Dictionary<string, Dictionary<string, object>> jsonData)
        {
            try
            {
                CategoriaMiddleware categoriaMiddleware = new CategoriaMiddleware();
                categoriaMiddleware.ValidarNomeCategoria(jsonData);
                Dictionary<string, object> categoriaData = jsonData["categoria"];
                string nomeCategoria = categoriaData["nomeCategoria"].ToString();
                categoriaMiddleware.IsNotCategoria(nomeCategoria);

                Categoria categoria = new Categoria
                {
                    NomeCategoria = nomeCategoria
                };

                if (categoria.Create() == false)
                {
                    object resposta = new
                    {
                        mensagem = "Erro ao salvar categoria." // Mensagem de erro
                    };
                    return StatusCode(500, resposta);
                }
                else
                {
                    object resposta = new
                    {
                        mensagem = "Categoria criada com sucesso", // Mensagem de sucesso
                        categoria = categoria // Inclui a categoria criada na resposta
                    };
                    return Ok(resposta);
                }
            }
            catch (Exception e)
            {
                object resposta = new
                {
                    mensagem = e.Message // Mensagem de erro
                };
                return BadRequest(resposta);
            }
        }

        // PUT para atualizar uma categoria
        [HttpPut("/categorias/{idCategoria}")]
        public IActionResult Put_Categorias(uint idCategoria, [FromBody] Dictionary<string, Dictionary<string, object>> jsonData)
        {
            try
            {
               

                CategoriaMiddleware categoriaMiddleware = new CategoriaMiddleware();
                categoriaMiddleware.ValidarNomeCategoria(jsonData);
                

                Dictionary<string, object> categoriaData = jsonData["categoria"];
                string nomeCategoria = categoriaData["nomeCategoria"].ToString();
                categoriaMiddleware.IsNotCategoria(nomeCategoria);
                if  (categoriaMiddleware.ExisteCategoriaId(idCategoria) == false )  {
                     return StatusCode(404, new { mensagem = "Categoria não encontrada." });
                }

                Categoria categoria = new Categoria
                {
                    IdCategoria = idCategoria,
                    NomeCategoria = nomeCategoria
                };

                if (categoria.Update() == false)
                {
                    object resposta = new
                    {
                        mensagem = "Erro ao atualizar categoria." // Mensagem de erro
                    };
                    return StatusCode(500, resposta);
                }
                else
                {
                    object resposta = new
                    {
                        mensagem = "Categoria atualizada com sucesso", // Mensagem de sucesso
                        categoria = categoria // Inclui a categoria atualizada na resposta
                    };
                    return Ok(resposta);
                }
            }
            catch (Exception e)
            {
                object resposta = new
                {
                    mensagem = e.Message // Mensagem de erro
                };
                return BadRequest(resposta);
            }
        }

        // DELETE para excluir uma categoria
        [HttpDelete("/categorias/{idCategoria}")]
        public IActionResult Delete_Categoria(uint idCategoria)
        {
            CategoriaMiddleware categoriaMiddleware = new CategoriaMiddleware();
            if  (categoriaMiddleware.ExisteCategoriaId(idCategoria) == false )  {
                return StatusCode(404, new { mensagem = "Categoria não encontrada." });
            }

            Categoria objcategoria = new Categoria();
            objcategoria.IdCategoria = idCategoria;

            if (objcategoria.Delete() == false)
            {
                object resposta = new
                {
                    mensagem = "Erro ao excluir categoria." // Mensagem de erro
                };
                return StatusCode(500, resposta);
            }
            else
            {
                object resposta = new
                {
                    mensagem = "Categoria excluída com sucesso" // Mensagem de sucesso
                };
                return Ok(resposta);
            }
        }
    }
}
