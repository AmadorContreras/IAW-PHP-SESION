CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    admin_user BOOLEAN NOT NULL,
    usuario VARCHAR(255) NOT NULL UNIQUE,
    contrasena VARCHAR(255) NOT NULL,
    nombre VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

