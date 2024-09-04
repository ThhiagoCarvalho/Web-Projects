<?php
namespace Firebase\JWT;

use stdClass;
use Firebase\JWT\Key;
use Firebase\JWT\JWT;
use DomainException;
use Exception;
use InvalidArgumentException;
use UnexpectedValueException;
use Firebase\JWT\SignatureInvalidException;
use Firebase\JWT\ExpiredException;

require_once "jwt/JWT.php";
require_once "jwt/Key.php";
require_once "jwt/SignatureInvalidException.php";

require_once "jwt/ExpiredException.php";

class MeuTokenJWT
{
    //chave de criptografia, defina uma chave forte e a mantenha segura.
    private $key = "x9S4q0v+V0IjvHkG20uAxaHx1ijj+q1HWjHKv+ohxp/oK+77qyXkVj/l4QYHHTF3";

    //algoritmo de criptografia para assinatura
    //Suportados: 'HS256' , 'ES384','ES256', 'ES256K', ,'HS384', 'HS512', 'RS256', 'RS384'
    private $alg = 'HS256';
    private $type = 'JWT';
    private $iss = 'http://localhost'; //emissor do token
    private $aud = 'http://localhost'; //destinatário do token
    private $sub = "acesso_sistema";   //assunto do token
    private $iat = "";  //momento de emissão
    private $exp = "";     //momento de expiração
    private $nbf = ""; //não é válido antes do tempo especificado
    private $jti = "";  //Identificador único
    private $payload; //claims 
    //tempo de validade do token
    private $duracaoToken = 3600 * 24 * 30; //3600 segundos = 60 min

    public function gerarToken($parametro_claims)
    {

        // Criação dos headers como objeto da classe stdClass
        $objHeaders = new stdClass();
        $objHeaders->alg = $this->alg;
        $objHeaders->typ = $this->type;

        // Criação do payload como objeto da classe stdClass
        $objPayload = new stdClass();

        //Registered Claims
        $objPayload->iss = $this->iss;        // emissor do token
        $objPayload->aud = $this->aud;        // destinatário do token
        $objPayload->sub = $this->sub;        // assunto do token  
        $objPayload->iat = time();            // momento de criação do token
        $objPayload->exp = time() + $this->duracaoToken;   // momento de expiração = tempo atual + duração
        $objPayload->nbf = time();        // momento em que o token torna-se valido. 
        $objPayload->jti = bin2hex(random_bytes(16)); // gera um valor aleatório para jti;

        //Public Claims
        $objPayload->emailUsuario = $parametro_claims->emailUsuario;
        $objPayload->senhaUsuario = $parametro_claims->senhaUsuario;

        //Private claims


        // Utiliza a biblioteca do Firebase para gerar o token com os parâmetros
        $token = JWT::encode((array) $objPayload, $this->key, $this->alg, null, (array) $objHeaders);
        return $token;
    }

    public function validarToken($stringToken)
    {
        if (isset($stringToken)) {
            if ($stringToken == "") {
                return false;
            } else {
                $remover = ["Bearer ", " "];
                $token = str_replace($remover, "", $stringToken);
                try {
                    $payloadValido = JWT::decode($token, new Key($this->key, $this->alg));
                    $this->setPayload($payloadValido);
                    return true;
                } catch (SignatureInvalidException $e) {
                    // A assinatura do token é inválida.
                    //error_log("Invalid token signature: " . $e->getMessage());
                    return false;
                } catch (BeforeValidException $e) {
                    // O token não é válido ainda (antes do tempo 'nbf').
                    //error_log("Token not valid yet: " . $e->getMessage());
                    return false;
                } catch (ExpiredException $e) {
                    // O token expirou.
                    // error_log("Token expired: " . $e->getMessage());
                    return false;
                } catch (InvalidArgumentException $e) {
                    // Argumento inválido passado.
                    //error_log("Invalid argument: " . $e->getMessage());
                    return false;
                } catch (DomainException $e) {
                    // Exceção de domínio genérica.
                    //error_log("Domain exception: " . $e->getMessage());
                    return false;
                } catch (UnexpectedValueException $e) {
                    // Valor inesperado encontrado.
                    //error_log("Unexpected value: " . $e->getMessage());
                    return false;
                } catch (Exception $e) {
                    // Qualquer outra exceção genérica.
                    //error_log("General exception: " . $e->getMessage());
                    return false;
                }
            }
        }
        return false;
    }

    /**
     * Get the value of payload
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * Set the value of payload
     *
     * @return  self
     */
    public function setPayload($payload)
    {
        $this->payload = $payload;

        return $this;
    }

    /**
     * Get the value of alg
     */
    public function getAlg()
    {
        return $this->alg;
    }

    /**
     * Set the value of alg
     *
     * @return  self
     */
    public function setAlg($alg)
    {
        $this->alg = $alg;

        return $this;
    }
}