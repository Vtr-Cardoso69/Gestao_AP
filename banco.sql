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

-- 4. Dados iniciais para testes
INSERT INTO apartamentos (id, numero, bloco_andar, categoria, limite_hospedes, status) VALUES
(1, '101', 'Bloco A', 'Tema: Romântica', 2, 'Disponivel'),
(2, '102', 'Bloco A', 'Tema: Praia', 3, 'Ocupado'),
(3, '201', 'Bloco B', 'Tema: Zen', 1, 'Disponivel'),
(4, '202', 'Bloco B', 'Tema: Familiar', 4, 'Ocupado'),
(5, '301', 'Bloco C', 'Tema: Urbano', 5, 'Disponivel'),
(6, '302', 'Bloco C', 'Tema: Luxo', 6, 'Ocupado');

INSERT INTO moradores (id, apartamento_id, cpf, telefone) VALUES
(1, 1, '123.456.789-00', '(11) 98888-1001'),
(2, 2, '234.567.890-11', '(11) 97777-2002'),
(3, 4, '345.678.901-22', '(11) 96666-3003'),
(4, 6, '456.789.012-33', '(11) 95555-4004'),
(5, 2, '567.890.123-44', '(11) 94444-5005');

INSERT INTO ocorrencias (id, apartamento_id, morador_id, titulo, descricao, tipo_ocorrencia, status) VALUES
(1, 1, 1, 'Luz do quarto falhando', 'A luminária do quarto principal está piscando e precisa de manutenção.', 'Quarto', 'Pendente'),
(2, 2, 2, 'Chave do quarto perdida', 'O hóspede informou que perdeu a chave de acesso do apartamento.', 'Pertence Esquecido', 'Em Andamento'),
(3, 4, 3, 'Solicitação de toalhas extras', 'O cliente pediu toalhas e kit de banho para mais dois hóspedes.', 'Atendimento', 'Resolvido');
