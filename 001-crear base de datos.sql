CREATE DATABASE finanzas;
USE finanzas;

CREATE USER 'finanzas'@'localhost' 
IDENTIFIED BY 'finanzas';

GRANT USAGE ON *.* TO 'finanzas'@'localhost' 
REQUIRE NONE 
WITH MAX_QUERIES_PER_HOUR 0 
MAX_CONNECTIONS_PER_HOUR 0 
MAX_UPDATES_PER_HOUR 0 
MAX_USER_CONNECTIONS 0;

GRANT ALL PRIVILEGES 
ON `finanzas`.* 
TO 'finanzas'@'localhost';

CREATE TABLE `finanzas`.`movimientos` 
(
    Identificador INT(255) NOT NULL AUTO_INCREMENT , 
    fecha DATE NOT NULL , 
    titulo VARCHAR(255) NOT NULL ,
    descripcion TEXT NOT NULL ,
    ingresogasto INT(1),
    cantidad DECIMAL(10,2) NOT NULL , 
    PRIMARY KEY (`Identificador`)
) ENGINE = InnoDB;

INSERT INTO `movimientos` (
    `Identificador`, 
    `fecha`, 
    `titulo`, 
    `descripcion`, 
    `ingresogasto`, 
    `cantidad`
) VALUES (
    NULL, 
    '2024-10-21', 
    'Pago nomina', 
    'Pago mensual de la nómina laboral', 
    '0', 
    '1000.00'
);

INSERT INTO `movimientos` (
    `Identificador`, 
    `fecha`, 
    `titulo`, 
    `descripcion`, 
    `ingresogasto`, 
    `cantidad`
) VALUES (
    NULL, 
    '2024-10-22', 
    'Gasto hipoteca', 
    'Gasto mensual de la hipoteca de un piso', 
    '1', 
    '300.45'
);

