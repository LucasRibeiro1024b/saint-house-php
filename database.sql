CREATE DATABASE santacasa;

CREATE TABLE `santacasa`.`paciente` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `nome` VARCHAR(130) NOT NULL,
    `sexo` char(1) NOT NULL,
    `dt_nascimento` DATE NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `santacasa`.`ptendtime` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `id_paciente` INT NOT NULL,
    `tipo_at` VARCHAR(1) NOT NULL,
    `dt_atendimento` DATE NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (id_paciente) REFERENCES paciente(id)
) ENGINE = InnoDB;