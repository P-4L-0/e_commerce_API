<?php
//manejo de errores para variables
declare(strict_types=1);

class Database
{

    private static PDO $connection = null;

    public static function connection(): PDO
    {
        //variables de la bd
        if(self::$connection == null){
            $host = "";
            $dbname = "e_commerce";
            $user = "";
            $passwd = "";
        } 


        /**
         * @param object $DBC database connection
         * crea la conexión con la base de datos mysql
         */
        //conexión a la bd
        try {
            self::$connection = new PDO("mysql:host=$host;dbname=$dbname;", $user, $passwd);

            //manejo de errores
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            //Desactiva oa emulación de sentencias preparadas
            self::$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (PDOException $e) {
            //echo $e->getMessage();
            error_log("Error en la conexion ". $e->getMessage());
            return null;
        }

        return self::$connection;
    }
}









?>