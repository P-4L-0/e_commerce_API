<?
declare(strict_types=1);
require_once __DIR__ . '/app/controllers/controlUsuario.php';
require_once __DIR__ . '/app/controllers/controlCarrito.php';
require_once __DIR__ . '/app/controllers/controlCategoria.php';
require_once __DIR__ . '/app/controllers/controlProducto.php';
require_once __DIR__ . '/app/controllers/controlReseña.php';
require_once __DIR__ . '/app/middleware/tokenVerify.php';

header("Content-Type: application/json");

$controlador = new UsuarioControlador();
$auth = new tokenVerify();

//obtencion del metodo
$method = $_SERVER["REQUEST_METHOD"];
$uri = explode("/", trim($_SERVER["REQUEST_URI"], "/"));

//rutas de la api

$routes = [
    'POST' => [
        'register' => function () use ($controlador): void {
            $controlador->register();
        },
        'login' => function () use ($controlador): void {
            $controlador->login();
        },
        'producto' => function():void{

        },
        'category' => function():void{
            
        },
        'carrito' => function():void{

        },
        'reseña' => function():void{

        }
    ],
    'GET' => [
        'carrito'=> function():void{

        },
        'productos' => function():void{

        },
        'reseñas' => function():void{
            
        }
    ]
];

if (isset($routes[$method][$uri])) {
    $routes[$method][$uri[0]]();
} else {
    http_response_code(404);
    echo json_encode(["error" => "Ruta no encontrada", "status" => 404]);
}

?>