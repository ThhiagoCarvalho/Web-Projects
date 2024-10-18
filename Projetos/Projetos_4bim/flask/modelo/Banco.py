import mysql.connector
from mysql.connector import Error


class Banco:
    @staticmethod
    def getConexao():
        try:
            conexao = mysql.connector.connect(
                host='localhost',          # Exemplo: 'localhost'
                database='mydb',     # Nome do banco de dados
                user='root',       # Seu usuário do MySQL
                password='root123'      # Sua senha do MySQL
            )
            if conexao.is_connected():
                print("Conexão com o banco de dados estabelecida.")
                return conexao
        except Error as e:
            print(f"Erro ao conectar ao banco de dados: {e}")
            return None