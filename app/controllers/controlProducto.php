<?php
declare(strict_types=1);
require_once __DIR__ . "/../models/productoModel.php";

class ProductoController
{

    private Producto $producto;

    public function __construct()
    {
        $this->producto = new Producto;
    }

    public function getAll(): void
    {
        $data = json_decode(file_get_contents("php://input"), true);

        $categorías = $this->producto->obtener_productos();
        echo json_encode($categorías);
    }

    public function create(): void
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['nombre'])) {
            http_response_code(400);
            echo json_encode(["Error" => "Nombre es requerido"]);
            return;
        }

        try {
            $this->producto->crear_categoría($data['nombre']);
        } catch (PDOException $e) {
            echo json_encode(["Error" => $e]);
        }
    }

    public function update(): void
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if(!isset($data['id'], $data['nombre'])){
            http_response_code(400);
            echo json_encode(["Error" => "Campos requeridos"]);
            return;
        }

        try {
            $this->producto->actualizar($data['id'], $data['nombre']);
        } catch (PDOException $e) {
            echo json_encode(["Error" => $e]);
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
            $this->producto->eliminar($data['id']);
        } catch (PDOException $e) {
            echo json_encode(["Error" => $e]);
        }
    }

}

?>