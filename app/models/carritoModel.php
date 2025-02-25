<?php
declare(strict_types=1);
require_once __DIR__ . '/../config/database.php';

class Carrito
{

    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connection();
    }

    public function obtener_carrito($id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM carrito WHERE usuario_id = :id");
        $stmt->execute(["id" => $id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: NULL;
    }

    public function crear_carrito($usuario_id, $producto_id, $cantidad, $precio): void
    {
        $stmt = $this->db->prepare("INSERT INTO carrito (usuario_id, producto_id, cantidad_producto, precio) VALUES (?,?,?,?)");
        $stmt->execute([$usuario_id, $producto_id, $cantidad, $precio]);
    }

    public function eliminar($id): void
    {
        $stmt = $this->db->prepare("DELETE FROM carrito WHERE id = :id");
        $stmt->execute(["id" => $id]);
    }

}


?>