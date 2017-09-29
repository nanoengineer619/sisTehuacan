-- MySQL Script generated by MySQL Workbench
-- 09/18/17 21:00:34
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
CREATE TABLE `proveedor` (
  `idproveedor` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nombre` VARCHAR(80) NOT NULL,
  `direccion` VARCHAR(70) NOT NULL,
  `telefono` VARCHAR(10) NOT NULL,
  `email` VARCHAR(50) NOT NULL)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`usuario`
-- -----------------------------------------------------
CREATE TABLE `usuario` (
  `idusuario` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  `direccion` VARCHAR(70) NOT NULL,
  `telefono` VARCHAR(10) NOT NULL,
  `email` VARCHAR(50) NOT NULL,
  `cargo` VARCHAR(20) NOT NULL,
  `login` VARCHAR(20) NOT NULL,
  `clave` VARCHAR(64) NOT NULL,
  `imagen` VARCHAR(80) NOT NULL,
  `condicion` TINYINT(1) NOT NULL)
ENGINE = InnoDB;

INSERT INTO `usuario` (`idusuario`, `nombre`, `direccion`, `telefono`, `email`, `cargo`, `login`, `clave`, `imagen`, `condicion`) VALUES
(1, 'Lorenzo Bautista Gonzalez','juan de la luz - tonalapan', '9241402229', 'Lorenz_bg@hotmail.com', 'Admin', 'admin', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', '1487132068.jpg', 1);
-- -----------------------------------------------------
-- Table `mydb`.`ingreso`
-- -----------------------------------------------------
CREATE TABLE `ingreso` (
  `idingreso` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `idproveedor` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `tipo_comprobante` varchar(20) NOT NULL,
  `serie_comprobante` varchar(7) DEFAULT NULL,
  `num_comprobante` varchar(10) NOT NULL,
  `fecha_hora` date NOT NULL,
  `impuesto` decimal(4,2) NOT NULL,
  `total_compra` decimal(11,2) NOT NULL,
  `estado` varchar(20) NOT NULL,
  INDEX `fk_proveedor_idx` (`idproveedor` ASC),
  INDEX `fk_usuario_idx` (`idusuario` ASC),
  CONSTRAINT `fk_proveedor`
    FOREIGN KEY (`idproveedor`)
    REFERENCES `proveedor` (`idproveedor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario`
    FOREIGN KEY (`idusuario`)
    REFERENCES `usuario` (`idusuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`detalle_ingreso`
-- -----------------------------------------------------
CREATE TABLE `detalle_ingreso` (
  `iddetalle_ingreso` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `idingreso` int(11) NOT NULL,
  `idarticulo` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_compra` decimal(11,2) NOT NULL,
  INDEX `fk_detalle_ingreso_idx` (`idingreso` ASC),
  CONSTRAINT `fk_detalle_ingreso`
    FOREIGN KEY (`idingreso`)
    REFERENCES `ingreso` (`idingreso`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`categoria`
-- -----------------------------------------------------
CREATE TABLE `categoria` (
  `idcategoria` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nombre` VARCHAR(80) NOT NULL,
  `descripcion` VARCHAR(256) NOT NULL,
  `condicion` TINYINT(1) NOT NULL)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`articulo`
-- -----------------------------------------------------
CREATE TABLE `articulo` (
  `idarticulo` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `idcategoria` INT NOT NULL,
  `codigo` Varchar(50) NOT NULL,
  `nombre` VARCHAR(50) NOT NULL,
  `stock` INT NOT NULL,
  `descripcion` VARCHAR(256) NOT NULL,
  `imagen` VARCHAR(80) NOT NULL,
  `condicion` TINYINT(1) NOT NULL,
  INDEX `fk_articulo_categoria_idx` (`idcategoria` ASC),
  CONSTRAINT `fk_articulo_categoria`
    FOREIGN KEY (`idcategoria`)
    REFERENCES `categoria` (`idcategoria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`permiso`
-- -----------------------------------------------------
CREATE TABLE `permiso` (
  `idpermiso` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL)
ENGINE = InnoDB;

INSERT INTO `permiso` (`idpermiso`, `nombre`) VALUES
(1, 'Escritorio'),
(2, 'Almacen'),
(3, 'Compras'),
(4, 'Edificios'),
(5, 'Interior'),
(6, 'Exterior'),
(7, 'Consumo'),
(8, 'Acceso');

-- -----------------------------------------------------
-- Table `mydb`.`usuario_permiso`
-- -----------------------------------------------------
CREATE TABLE `usuario_permiso` (
  `idusuario_permiso` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `idusuario` INT NOT NULL,
  `idpermiso` INT NOT NULL)
ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `usuario_permiso` (`idusuario_permiso`, `idusuario`, `idpermiso`) VALUES
(1 ,1, 1),
(2 ,1, 2),
(3 ,1, 3),
(4 ,1, 4),
(5 ,1, 5),
(6 ,1, 6),
(7 ,1, 7),
(8 ,1, 8);
-- -----------------------------------------------------
-- Table.`edificio`
-- -----------------------------------------------------
CREATE TABLE `edificio` (
  `idedificio` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nombre` VARCHAR(80) NOT NULL,
  `condicion` TINYINT(1) NOT NULL)
ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- -----------------------------------------------------
-- Table.`departamento`
-- -----------------------------------------------------
CREATE TABLE `elemento` (
  `idelemento` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nombre` VARCHAR(80) NOT NULL,
  `condicion` TINYINT(1) NOT NULL)
ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
-- -----------------------------------------------------
-- Table `departamento`
-- -----------------------------------------------------
CREATE TABLE `departamento` (
  `iddepartamento` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `idedificio` INT NOT NULL,
  `nombre` VARCHAR(80) NOT NULL,
  `total_consumo` Decimal(7,3)Not Null,
  `fecha` Date Not Null,
  `estado` TINYINT(1) NOT NULL)
ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
-- -----------------------------------------------------
-- Table `departamento`
-- -----------------------------------------------------
CREATE TABLE `detalle_departamento` (
  `iddetalle` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `iddepartamento` INT NOT NULL,
  `idelemento` INT NOT NULL,
  `cantidad` INT(5) NOT NULL,
  `funcionando` INT(5) NOT NULL,
  `fundidas` INT(7) NOT NULL,
  `potencia_unidad` INT(7) NOT NULL,
  `potencia_total` INT(7) NOT NULL,
  `capacidad` DECIMAL(7,3) NOT NULL,
  `tiempo_operacion` INT(7)NOT NULL,
  `consumo` DECIMAL(7,3)NOT NULL,
  INDEX `fk_detalle_departamento_idx` (`iddepartamento` ASC),
  CONSTRAINT `fk_departamento_elementos`
    FOREIGN KEY (`iddepartamento`)
    REFERENCES `departamento` (`iddepartamento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

CREATE TABLE `interior` (
  `idinterior` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `idedificio` int(11) NOT NULL,
  `fecha_hora` date NOT NULL,
  `consumo_total` decimal(11,3) NOT NULL,
  `estado` TINYINT(1) NOT NULL)
  ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

CREATE TABLE `detalle_interiores` (
  `iddetalle_interiores` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `idinterior` INT(11) NOT NULL,
  `iddepartamento` INT(11) NOT NULL,
  `consumo_semanal` DECIMAL(11,3) NOT NULL,
  `consumo_mensual` DECIMAL(11,3) NOT NULL,
  `consumo_semestral` DECIMAL(11,3) NOT NULL,
  INDEX `fk_detalle_interior_idx` (`idinterior` ASC),
  CONSTRAINT `fk_interiores_departamentos`
    FOREIGN KEY (`idinterior`)
    REFERENCES `interior` (`idinterior`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
-- -----------------------------------------------------
-- Table `mydb`.`exterior`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `exterior` (
 `idexterior` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
 `nombre` varchar(50) NOT NULL,
 `cantidad` int(7) NOT NULL,
 `funcionando` int(5) NOT NULL,
 `potencia_unidad` decimal(8,4) NOT NULL,
 `instalada_watts` decimal(8,4) NOT NULL,
 `instalada_kw` decimal(8,4) NOT NULL,
 `t_operacion_sem` decimal(8,4) NOT NULL,
 `cons_semana` decimal(8,4) NOT NULL,
 `t_op_mensual` int(5) NOT NULL,
 `cons_mes` decimal(8,4) NOT NULL,
 `cons_semestre` decimal(8,4) NOT NULL,
 `fundidas` int(11) NOT NULL,
 `fecha` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
-- -----------------------------------------------------
-- Table `mydb`.`detalle_interiores`
-- -----------------------------------------------------
CREATE TABLE Resetpass (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  ncuser varchar(10) NOT NULL,
  username varchar(100) NOT NULL,
  token varchar(64) NOT NULL,
  creado timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY ncuser (ncuser)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

delimiter //
 create trigger tr_updStockIngreso after insert on detalle_ingreso
 for each row begin
     update articulo set stock = stock + new.cantidad where articulo.idarticulo = new.idarticulo;
end 
//
delimiter ; 

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
