<?php
class Database {
    private $conn;

    public function getConnection() {
        $this->conn = null;

        // Evitar el uso de parse_url con @ en el usuario
        $host = "metodos-metodosbd-ljnklx";
        $port = 3306;
        $user = "dilansalas200@gmail.com";
        $pass = "qx7u83jvoxcfkanb";
        $dbname = "apimetodos";

        try {
            $this->conn = new PDO(
                "mysql:host=$host;port=$port;dbname=$dbname",
                $user,
                $pass
            );
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>
