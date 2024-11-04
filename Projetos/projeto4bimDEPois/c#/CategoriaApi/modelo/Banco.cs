using MySql.Data.MySqlClient;

namespace RestAPi.Model
{
    public static class Banco
    {
        // Constantes privadas que armazenam os dados da conexão com o banco de dados
        private const string Host = "127.0.0.1"; // Endereço do servidor MySQL (neste caso, localhost)
        private const string User = "root"; // Nome de usuário para conectar ao banco de dados
        private const string Password = "root123"; // Senha para o usuário especificado
        private const string DatabaseName = "mydb"; // Nome do banco de dados a ser utilizado
        private const string Port = "3306"; // Porta do servidor MySQL (padrão é 3306)

        // Variável estática privada que armazena a conexão MySQL
        private static MySqlConnection? CONEXAO;

        // Método privado responsável por estabelecer a conexão com o banco de dados
        private static void Connect()
        {
            string connectionString = $"Server={Host};Database={DatabaseName};User ID={User};Password={Password};Port={Port};";
            CONEXAO = new MySqlConnection(connectionString);
            CONEXAO.Open();
        }

        // Método público para obter a conexão com o banco de dados
        public static MySqlConnection GetConnection()
        {
            if (CONEXAO == null || CONEXAO.State != System.Data.ConnectionState.Open)
            {
                Banco.Connect();
            }
            return CONEXAO;
        }
    }
}
