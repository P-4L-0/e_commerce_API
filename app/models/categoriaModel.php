<?php
declare(strict_types=1);
require_once __DIR__ . '/../config/database.php';

class Categoría
{

    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connection();
    }

    public function obtener_categorías(): array
    {
        $stmt = $this->db->query("SELECT * FROM categoria");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // public function obtener_categoría($id): ?array
    // {
    //     $stmt = $this->db->prepare("SELECT * FROM categoria WHERE codigo = :id");
    //     $stmt->execute(["id" => $id]);
    //     return $stmt->fetch(PDO::FETCH_ASSOC) ?: NULL;
    // }

    public function crear_categoría($nombre): void
    {
        $stmt = $this->db->prepare("INSERT INTO categoria(nombre) VALUES (?)");
        $stmt->execute([$nombre]);
    }

    public function actualizar($id, $nombre): void
    {
        $stmt = $this->db->prepare("UPDATE categoria SET nombre = :nombre WHERE codigo = :id");
        $stmt->execute(["nombre" => $nombre, "id" => $id]);
    }

    public function eliminar($id): void
    {
        $stmt = $this->db->prepare("DELETE FROM categoria WHERE codigo = :id");
        $stmt->execute(["id" => $id]);
    }

    public function __destruct()
    {
        Database::disconnect();
    }

}


?>