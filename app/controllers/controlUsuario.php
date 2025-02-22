<?php
declare(strict_types=1);
require_once __DIR__ . "/../models/usuarioModel.php";

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
            //codigo malo dea xd wazaaa :v
            http_response_code(400);
            echo json_encode(["Error" => "El correo y la contraseña con requeridos"]);
        }

        //Obtener usuario por email
        $user = $this > user->obtener_usuario($data['email']);

        if (!user || !password_verify($data['password'], $user['contraseña'])) {
            http_response_code(401);
            echo json_encode(["Error" => "credenciales incorrectas"]);
            return;
        }

        //generar token simulado(por ahora) no es seguro del todo xd

        $token = bin2hex(random_bytes(32));

        echo json_encode(
            [
                "Mensaje" => "Inicio de sesion existoso",
                "User" => [
                    "id" => $user['id'],
                    "nombre" => $user['nombre'],
                    "email" => $user['email']
                ],
                "token" => $token
            ]
        );
    }

    public function register(): void{

        
        $data = json_decode(file_get_contents("PHP://input",true));

        if(!isset($data['nombre'], $data['email'], $data['direccion'], $data['telefeno'], $data['contraseña'])){
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

        echo json_encode(["message" => "Registro exitoso", "usuario" => $new_user]);
    }

}

/**
 * Referencias 
 * https://www.php.net/manual/en/function.bin2hex.php
 */
?>