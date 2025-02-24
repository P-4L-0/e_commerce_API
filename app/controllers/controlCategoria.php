<?php
declare(strict_types=1);
require_once __DIR__ . "/../models/categoriaModel.php";

class CategoryController
{

    private Categoría $category;

    public function __construct()
    {
        $this->category = new Categoría;
    }

    public function getAll(): void
    {
        $data = json_decode(file_get_contents("php://input"), true);

        $categorías = $this->category->obtener_categorías();
        echo json_encode($categorías);
    }

    public function getOne(): void
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['id'])) {
            http_response_code(400);
            echo json_encode(["Error" => "Identificador invalido"]);
            return;
        }

        $category = $this->category->obtener_categoría($data['id']);

        echo json_encode($category);

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
            $this->category->crear_categoría($data['nombre']);
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
            $this->category->actualizar($data['id'], $data['nombre']);
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
            $this->category->eliminar($data['id']);
        } catch (PDOException $e) {
            echo json_encode(["Error" => $e]);
        }
    }

}

?>