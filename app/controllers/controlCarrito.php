<?php
declare(strict_types=1);
require_once __DIR__ . "/../models/carritoModel.php";

class CarritoController
{

    private Carrito $carrito;

    public function __construct()
    {
        $this->carrito = new Carrito();
    }

    public function getAll(): void
    {
        $data = json_decode(file_get_contents("php://input"), true);

        $carritos = $this->carrito->obtener_carrito($data['id']);
        echo json_encode($carritos);
    }

    public function create(): void
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['usuario_id'], $data["producto_id"],$data['cantidad'], $data['precio'])) {
            http_response_code(400);
            echo json_encode(["Error" => "Todos los campos son requeridos"]);
            return;
        }

        try {
            $this->carrito->crear_carrito($data['usuario_id'], $data["producto_id"],$data['cantidad'], $data['precio']);
        } catch (PDOException $e) {
            echo json_encode(["Error" => $e->getMessage()]);
        }
    }

    public function delete(): void
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if(!isset($data['id'])){
            http_response_code(400);
            echo json_encode(["Error" => "Identificador requerido"]);
            return;
        }

        try {
            $this->carrito->eliminar($data['id']);
        } catch (PDOException $e) {
            echo json_encode(["Error" => $e->getMessage()]);
        }
    }

}

?>