CREATE DATABASE IF NOT EXISTS db_suite_romantica
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE db_suite_romantica;

-- 1. Tabela de Suítes / Acomodações
CREATE TABLE IF NOT EXISTS apartamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    numero VARCHAR(10) NOT NULL,
    bloco_andar VARCHAR(30) NOT NULL,
    categoria VARCHAR(50) DEFAULT 'Suíte Romântica',
    limite_hospedes INT NOT NULL DEFAULT 2,
    status ENUM('Disponivel', 'Ocupado') DEFAULT 'Disponivel',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 2. Tabela de Hóspedes (Identificação Anônima)
CREATE TABLE IF NOT EXISTS moradores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    apartamento_id INT NOT NULL,
    cpf VARCHAR(14) NOT NULL,
    telefone VARCHAR(20) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_morador_apartamento
        FOREIGN KEY (apartamento_id)
        REFERENCES apartamentos(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
) ENGINE=InnoDB;

-- 3. Tabela de Ocorrências (Suíte ou Hóspede)
CREATE TABLE IF NOT EXISTS ocorrencias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    apartamento_id INT NOT NULL,
    morador_id INT NULL,
    titulo VARCHAR(120) NOT NULL,
    descricao TEXT NOT NULL,
    tipo_ocorrencia ENUM('Quarto', 'Pertence Esquecido', 'Atendimento', 'Outros') DEFAULT 'Quarto',
    status ENUM('Pendente', 'Em Andamento', 'Resolvido') DEFAULT 'Pendente',
    data_registro DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_ocorrencia_apartamento
        FOREIGN KEY (apartamento_id)
        REFERENCES apartamentos(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT fk_ocorrencia_morador
        FOREIGN KEY (morador_id)
        REFERENCES moradores(id)
        ON DELETE SET NULL
        ON UPDATE CASCADE
) ENGINE=InnoDB;
