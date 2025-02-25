<?php
declare(strict_types=1);
require_once __DIR__ . '/../config/database.php';

class Producto
{

    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connection();
    }

    public function obtener_productos(): ?array
    {
        $stmt = $this->db->query("SELECT * FROM productos");
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: NULL;
    }

    // public function obtener_producto($id): ?array
    // {
    //     $stmt = $this->db->prepare("SELECT * FROM productos WHERE id = :id");
    //     $stmt->execute(["id" => $id]);
    //     return $stmt->fetch(PDO::FETCH_ASSOC) ?: NULL;
    // }

    public function crear_producto($nombre, $descripcion, $precio, $stock, $codigo_categoria): void
    {
        $stmt = $this->db->prepare("INSERT INTO productos (nombre, descripcion, precio, stock, CodigoCategoria) VALUES (?,?,?,?,?)");
        $stmt->execute([$nombre, $descripcion, $precio, $stock, $codigo_categoria]);
    }

    public function actualizar($id, $nombre, $descripcion, $precio, $stock, $codigo_categoria): void
    {
        $stmt = $this->db->prepare("UPDATE producto SET nombre = :nombre , descripcion = :descripcion, precio = :precio, CodigoCategoria = :codigo WHERE codigo = :id");
        $stmt->execute([
            "nombre" => $nombre,
            "descripcion" => $descripcion,
            "precio" => $precio,
            "stock" => $stock,
            "codigo" => $codigo_categoria,
            "id" => $id]);
    }

    public function eliminar($id): void
    {
        $stmt = $this->db->prepare("DELETE FROM productos WHERE id = :id");
        $stmt->execute(["id" => $id]);
    }

}


?>