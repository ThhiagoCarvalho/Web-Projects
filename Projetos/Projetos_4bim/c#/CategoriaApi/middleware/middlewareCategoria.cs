using RestAPi.Model;
using CategoriaApi.Modelo; // Adicione esta linha se ainda não estiver presente


// Define a classe CursoMiddleware, responsável por validações relacionadas a cursos e cargos
public class CategoriaMiddleware
{
    public bool ValidarNomeCategoria(Dictionary<string, Dictionary<string, object>> jsonData)
    {
        // Verifica se o JSON contém a chave "cargo"
        if (!jsonData.ContainsKey("categoria"))
        {
            // Lança uma exceção se a chave "cargo" não estiver presente
            throw new Exception("categoria não fornecido");
        }
        
        // Obtém os dados do cargo a partir do JSON
        var categoriaData = jsonData["categoria"];

        // Verifica se o objeto cargo contém a chave "nomeCargo"
        if (!categoriaData.ContainsKey("nomeCategoria"))
        {
            // Lança uma exceção se o campo "nomeCargo" não estiver presente
            throw new Exception("Nome da nomeCategoria não fornecido");
        }
        
        // Converte o valor de "nomeCargo" para string
        string nomeCategoria = categoriaData["nomeCategoria"].ToString();

        // Verifica se o nome do cargo possui pelo menos 5 caracteres
        if (nomeCategoria.Length < 5)
        {
            // Lança uma exceção se o nome do cargo for muito curto
            throw new Exception("nome da categoria deve possuir pelo menos 5 caracteres");
        }

        // Se todas as validações forem bem-sucedidas, retorna true
        return true;
    }

    // Método para verificar se já existe um cargo com o mesmo nome
    public bool IsNotCategoria(string nomeCategoria)
    {
        // Cria uma nova instância de Cargo para realizar a verificação
        Categoria categoria = new Categoria();

        // Chama o método IsCargoByNomeCargo para verificar se o cargo já existe
        if (categoria.IsCategoria(nomeCategoria) == true)
        {
            // Lança uma exceção se o nome do cargo já estiver registrado
            throw new Exception("Já existe uma categoria com o nome informado");
        }

        // Retorna true se não houver um cargo com o nome informado
        return true;
    }


        public bool ExisteCategoriaId(uint idCategoria)
    {
        // Cria uma nova instância de Cargo para realizar a verificação
        Categoria categoria = new Categoria();

        // Chama o método IsCargoByNomeCargo para verificar se o cargo já existe
        if (categoria.ExisteCategoria(idCategoria) == false)
        {
            // Lança uma exceção se o nome do cargo já estiver registrado
             return false;
        }else { 

        // Retorna true se não houver um cargo com o nome informado
        return true;
        }
        
    }
}
