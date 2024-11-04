using MySql.Data.MySqlClient;
using RestAPi.Model;

namespace CategoriaApi.Modelo {
    public class Categoria {
        public uint IdCategoria { get; set; }
        public string NomeCategoria { get; set; }

        public bool Create () { 
            

            try {
                MySqlCommand mysqlCommand = new MySqlCommand("INSERT INTO categoria (nomeCategoria) VALUES (@nomeCategoria)", Banco.GetConnection());
                mysqlCommand.Parameters.AddWithValue("@nomeCategoria", this.NomeCategoria);
                int itensInseridos = mysqlCommand.ExecuteNonQuery();
                if (itensInseridos > 0) {
                    uint idCategoriaInserido = Convert.ToUInt32(mysqlCommand.LastInsertedId);
                    this.IdCategoria = idCategoriaInserido;
                return true; 
                }


            }catch (Exception ex) {
                Console.WriteLine("Erro ao criar categoria: " + ex.Message);
                return false; 
            }
            return false; // Retorna false se não houve inserção
        }


        public bool Update () { 
            try {
                MySqlCommand mysqlCommand = new MySqlCommand("UPDATE categoria SET nomeCategoria = @nomeCategoria WHERE idCategoria = @idCategoria", Banco.GetConnection());
                mysqlCommand.Parameters.AddWithValue("@nomeCategoria", this.NomeCategoria);
                mysqlCommand.Parameters.AddWithValue("@idCategoria", this.IdCategoria);

                int qtdCategoriasAtualizados = mysqlCommand.ExecuteNonQuery();
                return qtdCategoriasAtualizados > 0;

            }catch (Exception ex) {
                Console.WriteLine("Erro ao atualizar categoria: " + ex.Message);
                return false; 
            }
            return false; // Retorna false se não houve inserção
        }


 public Categoria ReadById() {
                Categoria categoria = new Categoria();

    try { 
        MySqlCommand mysqlCommand = new MySqlCommand("SELECT * FROM categoria WHERE idCategoria = @idCategoria", Banco.GetConnection());
        mysqlCommand.Parameters.AddWithValue("@idCategoria", this.IdCategoria);

        MySqlDataReader matrizRegistros = mysqlCommand.ExecuteReader();
        if (matrizRegistros.Read()) {
            categoria.IdCategoria =   matrizRegistros.GetUInt32("idCategoria");
            categoria.NomeCategoria =   matrizRegistros.GetString("nomeCategoria");
        }
        matrizRegistros.Close();
    } catch (Exception ex) {
        Console.WriteLine("Erro ao buscar categoria: " + ex.Message);
    }
    return categoria;
}

public List<Categoria> ReadCategoria() {
    List<Categoria> categorias = new List<Categoria>();
    try { 
        MySqlCommand mysqlCommand = new MySqlCommand("SELECT * FROM categoria", Banco.GetConnection());
        MySqlDataReader matrizRegistros = mysqlCommand.ExecuteReader();

        while (matrizRegistros.Read()) {
            Categoria categoria = new Categoria();
            categoria.IdCategoria =   matrizRegistros.GetUInt32("idCategoria");
            categoria.NomeCategoria =   matrizRegistros.GetString("nomeCategoria");

            categorias.Add(categoria);
        }
        matrizRegistros.Close();
    } catch (Exception ex) {
        Console.WriteLine("Erro ao buscar categoria: " + ex.Message);
    }
    return categorias;
}


        public bool Delete () { 
            try { 
                MySqlCommand mysqlCommand = new MySqlCommand("Delete  FROM categoria WHERE idCategoria = @idCategoria", Banco.GetConnection());
                mysqlCommand.Parameters.AddWithValue("@idCategoria", this.IdCategoria);
                int qtdCategoriasExcluidas = mysqlCommand.ExecuteNonQuery();
                return qtdCategoriasExcluidas > 0;

            }catch (Exception ex) {
                Console.WriteLine("Erro ao excluir categoria: " + ex.Message);
                return false; 
            }
        }


public bool IsCategoria(string nomecategoria) { 
    bool existe = false;
    try {
        MySqlCommand mysqlCommand = new MySqlCommand("SELECT COUNT(*) as qtd FROM categoria WHERE nomeCategoria = @nomeCategoria", Banco.GetConnection());
        mysqlCommand.Parameters.AddWithValue("@nomeCategoria", nomecategoria);

        object resultado = mysqlCommand.ExecuteScalar();
        if (resultado != null) {
            int qtd = Convert.ToInt32(resultado);
            existe = qtd > 0;
        }
    } catch (Exception ex) {
        Console.WriteLine("Erro ao verificar categoria: " + ex.Message);
    }
    return existe; 
}


public bool ExisteCategoria(uint IdCategoria) { 
    bool existe = false;
    try {
        MySqlCommand mysqlCommand = new MySqlCommand("SELECT COUNT(*) as qtd FROM categoria WHERE idCategoria = @idCategoria", Banco.GetConnection());
        mysqlCommand.Parameters.AddWithValue("@idCategoria", IdCategoria);

        object resultado = mysqlCommand.ExecuteScalar();
        if (resultado != null) {
            int qtd = Convert.ToInt32(resultado);
            existe = qtd > 0;
        }
    } catch (Exception ex) {
        Console.WriteLine("Erro ao verificar categoria: " + ex.Message);
    }
    return existe; 
}


    }

}