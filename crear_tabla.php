<?php
require_once 'config/database.php'; // Asegúrate de que este archivo exista y esté bien configurado

$db = new Database();
$conn = $db->getConnection();

$sql = "
CREATE TABLE IF NOT EXISTS quejas_taxi (
    id INT(11) NOT NULL AUTO_INCREMENT,
    atendido_por VARCHAR(100) NOT NULL,
    descripcion TEXT NOT NULL,
    categoria VARCHAR(100) NOT NULL,
    puntuacion INT(11) NOT NULL,
    fecha_evento DATE NOT NULL,
    fecha_registro TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    costo_viaje DECIMAL(10,2) NOT NULL,
    PRIMARY KEY (id)
);

drop table quejas;
";

try {
    $conn->exec($sql);
    echo "✅ Tabla 'quejas_taxi' creada correctamente.";
} catch (PDOException $e) {
    echo "❌ Error al crear la tabla: " . $e->getMessage();
}
