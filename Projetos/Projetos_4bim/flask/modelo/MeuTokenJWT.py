import jwt
import datetime
import secrets


class MeuTokenJWT:
    def __init__(self):
        self._key = "x9S4q0v+V0IjvHkG20uAxaHx1ijj+q1HWjHKv+ohxp/oK+77qyXkVj/l4QYHHTF3"  # Chave secreta
        self._alg = 'HS256'  # Algoritmo de criptografia
        self._type = 'JWT'
        self._iss = 'http://localhost'  # Emissor do token
        self._aud = 'http://localhost'  # Destinatário do token
        self._sub = "acesso_sistema"  # Assunto do token
        self._duracaoToken = 3600 * 24 * 30  # Duração do token (30 dias)
        self.payload = None


    def gerar_token(self, parametro_claims):
        headers = {
            'alg': self._alg,
            'typ': self._type
        }
        agora = datetime.datetime.now(datetime.timezone.utc)
        payload = {
            'iss': self._iss,  # Emissor do token
            'aud': self._aud,  # Destinatário do token
            'sub': self._sub,  # Assunto do token
            'iat': int(agora.timestamp()),  # Momento de criação (em segundos)
            'exp': int((agora + datetime.timedelta(seconds=self._duracaoToken)).timestamp()),  # Expiração (em segundos)
            'nbf': int(agora.timestamp()),  # Não é válido antes do tempo especificado
            'jti': secrets.token_hex(16),  # Identificador único (jti)
            'email': parametro_claims['emailUsuario'],  # Claims públicas
            'nome': parametro_claims['nomeUsuario'],  # Claims públicas

        }
        # Gera o token utilizando a biblioteca PyJWT
        token = jwt.encode(payload, self._key, algorithm=self._alg, headers=headers)
        return token


    def validar_token(self, string_token):
        if not string_token or not isinstance(string_token, str):
            print("Token inválido: o token fornecido é nulo ou não é uma string.")
            return False


        # Verifica se o token tem o prefixo 'Bearer' e o remove
        if string_token.startswith("Bearer "):
            token = string_token[len("Bearer "):].strip()
        else:
            token = string_token.strip()


        # Verifica se o token não está vazio após a limpeza
        if not token:
            print("Token inválido: o token está vazio após a remoção do prefixo.")
            return False


        try:
            # Decodifica o token
            decoded = jwt.decode(token, self._key, algorithms=[self._alg], audience=self._aud)
            self.payload = decoded
            return True
        except jwt.ExpiredSignatureError:
            print("Token expirado")
            return False
        except jwt.InvalidTokenError:
            print("Token inválido")
            return False


    def get_payload(self):
        return self.payload


    def set_payload(self, payload):
        self.payload = payload


    def get_alg(self):
        return self._alg


    def set_alg(self, alg):
        self._alg = alg
