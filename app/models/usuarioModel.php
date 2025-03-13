<?php
declare(strict_types=1);
require_once __DIR__ . '/../config/database.php';

class Usuario
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connection();
    }

    /**
     * @param mixed $stmt statement = query sql enviado para ejecutar en l database
     * @return array la función retorna un array con los datos de los usuarios
     */
    public function obtener_usuarios(): array
    {
        $stmt = $this->db->query("SELECT * FROM usuarios");
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: NULL;
    }

    public function obtener_usuario($email): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: NULL;
        //retorna null si  no existe el dato 
    }

    public function crear_usuario($nombre, $email, $direccion, $telefono, $contraseña, $rol): void
    {
        $stmt = $this->db->prepare("INSERT INTO usuarios (nombre, email, direccion, telefono, contrasenia, rol) VALUES (?,?,?,?,?,?) ");
        $stmt->execute([$nombre, $email, $direccion, $telefono, $contraseña, $rol]);
    }

    public function __destruct()
    {
        Database::disconnect();
    }

}

/**
 * referencias:  
 * https://www.php.net/manual/en/book.pdo.php
 * PDO::query — Prepares and executes an SQL statement without placeholders
 * fetch_assoc https://www.php.net/manual/en/pdostatement.fetch.php
 */
?>