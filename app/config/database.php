<?php
//manejo de errores para variables
declare(strict_types=1);

class Database
{

    private static ?PDO $connection = null;
    private static int $instancias = 0;

    //variables de entorno
    private const HOST = "db";
    private const DBNAME = "e_commerce";
    private const USER = "user";
    private const PASSWD = "secret";

    public static function connection(): PDO
    {
        /**
         * @param object $DBC database connection
         * crea la conexión con la base de datos mysql
         */
        //conexión a la bd
        try {
            if (self::$connection === null) {

                self::$connection = new PDO("mysql:host=" . self::HOST . ";dbname=" . self::DBNAME . ";", self::USER, self::PASSWD);

                //manejo de errores
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                //Desactiva oa emulación de sentencias preparadas
                self::$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

                // echo json_encode(["message" => "Conexión exitosa"]);
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            error_log("Error en la conexion " . $e->getMessage());
            // return null;
        }

        self::$instancias++;
        return self::$connection;
    }

    public static function disconnect(): void
    {
        self::$instancias--;
        if (self::$instancias <= 0) {
            self::$connection = null;
        }
    }
}

?>