<?
declare(strict_types=1);
require_once __DIR__ . "/../../vendor/autoload.php";
require_once __DIR__ . '/../config/database.php';

USE Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Token{

    Private PDO $db; 

    public function __construct(){
        $this->db = Database::connection();
    }

    public function obtenerToken(): ?stdClass{
        $headers = apache_request_headers();
        if(!isset($headers['Authorization'])){
            return null; 
        }
        $auth = $headers['Authorization'];
        $authArray = explode(' ', $auth);
        $token = $authArray[1];
        $key = getenv('JWT_SECRET');
        $decode = JWT::decode($token, new Key($key, 'HS256'));
        return $decode;
    }

    public function verify(): mixed{
        $info = $this->obtenerToken();
        if(!$info){
            return null;
        }
        $stmt = $this->db->prepare("SELECT `rol` FROM usuarios WHERE id = :id");
        $stmt->execute(["id" => $info->data]);
        $rows = $stmt->fetchColumn();
        return $rows;
    }

}

?>