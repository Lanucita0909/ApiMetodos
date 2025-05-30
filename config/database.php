<?php
class Database {
    private $conn;

    public function getConnection() {
        $this->conn = null;

        $url = "mysql://dilansalas200@gmail.com:qx7u83jvoxcfkanb@metodos-metodosbd-ljnklx:3306/apimetodos";

        $url = rtrim($url, '}');

        $parts = parse_url($url);

        $host = $parts['host'];
        $port = $parts['port'];
        $user = $parts['user'];
        $pass = $parts['pass'];
        $dbname = ltrim($parts['path'], '/');

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
