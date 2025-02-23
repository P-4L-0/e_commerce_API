<?
declare(strict_types=1);
require_once __DIR__ . '/app/controllers/controlUsuario.php';
require_once __DIR__ . '/app/middleware/tokenVerify.php';

header("Content-Type: application/json");

$controlador = new UsuarioControlador();
$auth = new tokenVerify();

//obtencion del metodo
$method = $_SERVER["REQUEST_METHOD"];
$uri = explode("/", trim($_SERVER["REQUEST_URI"], "/"));

//rutas de la api
if ($method == "POST" && $uri[0] == "register") {
    $controlador->register();
}

if ($method == "POST" && $uri[0] == "login") {
    $controlador->login();
}

if ($method == "GET" && $uri[0] == "account") {
    if ($auth->verify() == 'user') {
        echo json_encode(["message" => "Usuario autenticado"]);
    } else {
        echo json_encode(["message" => "Usuario no autenticado"]);
    }
}


http_response_code(404);
echo json_encode(["error" => "Ruta no encontrada", "status" => 404]);

//demas rutas



?>