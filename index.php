<?
declare(strict_types=1);
require_once __DIR__ . '/app/controllers/controlUsuario.php';
require_once __DIR__ . '/app/controllers/controlCarrito.php';
require_once __DIR__ . '/app/controllers/controlCategoria.php';
require_once __DIR__ . '/app/controllers/controlProducto.php';
require_once __DIR__ . '/app/middleware/tokenVerify.php';

//tipo de header
header("Content-Type: application/json");

//instancia de controladores
$controlador = new UsuarioControlador();
$category = new CategoryController();
$auth = new Token();
$carrito = new CarritoController();
$producto = new ProductoController();

//obtención del método http
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
        'producto' => function () use ($producto, $auth): void {
            if ($auth->verify() === 'admin') {
                $producto->create();
            } else {
                http_response_code(401);
                echo json_encode(["Error" => "Unauthorized"]);
            }
        },
        'category' => function () use ($category, $auth): void {
            if ($auth->verify() === 'admin') {
                $category->create();
            } else {
                http_response_code(401);
                echo json_encode(["Error" => "Unauthorized"]);
            }
        },
        'carrito' => function () use ($carrito, $auth): void {
            if ($auth->verify() === 'user') {
                $carrito->create();
            } else {
                http_response_code(401);
                echo json_encode(["Error" => "Unauthorized"]);
            }
        }
    ],
    'GET' => [
        'carrito' => function () use ($carrito, $auth): void {
            if ($auth->verify() === 'user') {
                $carrito->getAll();
            } else {
                http_response_code(401);
                echo json_encode(["Error" => "Unauthorized"]);
            }
        },
        'productos' => function () use ($producto, $auth): void {
            $producto->getAll();
        },
        'category' => function () use ($category): void {
            $category->getAll();
        },
    ],
    'PUT' => [
        'category' => function () use ($category, $auth) {
            if ($auth->verify() === 'admin') {
                $category->update();
            } else {
                http_response_code(401);
                echo json_encode(["Error" => "Unauthorized"]);
            }
        },
        'producto' => function () use ($producto, $auth): void {
            if ($auth->verify() === 'admin') {
                $producto->update();
            } else {
                http_response_code(401);
                echo json_encode(["Error" => "Unauthorized"]);
            }
        }
    ],
    "DELETE" => [
        'category' => function () use ($category, $auth): void {
            if ($auth->verify() === 'admin') {
                $category->delete();
            } else {
                http_response_code(401);
                echo json_encode(["Error" => "Unauthorized"]);
            }
        },
        'carrito' => function () use ($carrito, $auth): void {
            if ($auth->verify() === 'user') {
                $carrito->delete();
            } else {
                http_response_code(401);
                echo json_encode(["Error" => "Unauthorized"]);
            }
        },
        'producto' => function () use ($producto, $auth): void {
            if ($auth->verify() === 'admin') {
                $producto->delete();
            } else {
                http_response_code(401);
                echo json_encode(["Er[ror" => "Unauthorized"]);
            }
        }
    ]
];

if (isset($routes[$method][$uri[0]])) {
    $routes[$method][$uri[0]]();
} else {
    http_response_code(404);
    echo json_encode(["error" => "Not Found", "status" => 404]);
}

?>