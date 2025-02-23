<?php
declare(strict_types=1);
require_once __DIR__ . "/../models/usuarioModel.php";
require_once __DIR__ . "/../../vendor/autoload.php";

USE Firebase\JWT\JWT;
use Firebase\JWT\Key;


class UsuarioControlador
{

    private Usuario $user;

    public function __construct()
    {
        $this->user = new Usuario();
    }

    public function login(): void
    {

        //convertir json 
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['email'], $data['password'])) {
            http_response_code(400);
            echo json_encode(["Error" => "El correo y la contraseña con requeridos"]);
        }

        //Obtener usuario por email
        $user = $this->user->obtener_usuario($data['email']);

        if (!$user || !password_verify($data['password'], $user['contrasenia'])) {
            http_response_code(401);
            echo json_encode(["Error" => "credenciales incorrectas"]);
            return;
        }

        $createTime = time();
        $expiration = $createTime + 3600;
        $key = "APP_PASSWORD"; //esto no debería de hacerse pero lo hago ps pq puedo :v
        $payload = [
            "exp" => $expiration,
            "data" => $user['id']
        ];

        $jwt = JWT::encode($payload, $key, 'HS256');

        echo json_encode(
            [
                "Mensaje" => "Inicio de sesión exitoso",
                "User" => [
                    "id" => $user['id'],
                    "nombre" => $user['nombre'],
                    "email" => $user['email']
                ],
                "token" => $jwt
            ]
        );
    }

    public function register(): void{

        
        $data = json_decode(file_get_contents("php://input"), true);

        if(!isset($data['nombre'], $data['email'], $data['direccion'], $data['telefono'], $data['contraseña'])){
            http_response_code(400);
            echo json_encode(["Error" => "Nombre, correo y contraseña son  requeridos"]);
            return;
        }

        if($this->user->obtener_usuario($data['email'])){
            http_response_code(409);
            echo json_encode(["Error" => "El correo ya existe"]);
            return;
        }

        $hash_passwd = password_hash($data['contraseña'], PASSWORD_BCRYPT);

        try{
            $new_user = $this->user->crear_usuario($data['nombre'], $data['email'],$data['direccion'], $data['telefono'], $hash_passwd);
        }catch(PDOException $e){
            echo json_encode(["Error" => $e]);
        }

        echo json_encode(["message" => "Registro exitoso"]);
    }

}

/**
 * Referencias 
 * https://www.php.net/manual/en/function.bin2hex.php
 */
?>