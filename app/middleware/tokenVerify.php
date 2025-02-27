<?
declare(strict_types=1);
require_once __DIR__ . "/../../vendor/autoload.php";
require_once __DIR__ . '/../config/database.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Token
{

    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connection();
    }

    public function obtenerToken(): ?stdClass
    {
        $headers = apache_request_headers();
        if (!isset($headers['Authorization'])) {
            return null;
        }

        $auth = $headers['Authorization'];
        $authArray = explode(' ', $auth);
        $token = $authArray[1];
        $key = getenv('JWT_SECRET');

        try {
            $decode = JWT::decode($token, new Key($key, 'HS256'));
            return $decode;
        } catch (\Firebase\JWT\ExpiredException $e) {
            //token expirado
            return null;
        } catch (\Firebase\JWT\SignatureInvalidException $e) {
            //error de firma incorrecta
            return null;
        } catch (\Firebase\JWT\BeforeValidException $e) {
            //token sin validar
            return null;
        } catch (\UnexpectedValueException $e) {
            //error de token mal formado
            return null;
        } catch (\Exception $e) {
            //error desconocido
            return null;
        }
    }

    public function verify(): mixed
    {
        $info = $this->obtenerToken();
        if (!$info) {
            return null;
        }
        $stmt = $this->db->prepare("SELECT `rol` FROM usuarios WHERE id = :id");
        $stmt->execute(["id" => $info->data]);
        $rows = $stmt->fetchColumn();
        return $rows;
    }

}

?>