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
    auto_status TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 2. Tabela de Hóspedes (Permite cadastro anônimo sem suíte vinculada de imediato)
CREATE TABLE IF NOT EXISTS moradores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    apartamento_id INT NULL, -- Ajustado para NULL para maior flexibilidade no check-in
    cpf VARCHAR(14) NOT NULL,
    telefone VARCHAR(20) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_morador_apartamento
        FOREIGN KEY (apartamento_id)
        REFERENCES apartamentos(id)
        ON DELETE SET NULL
        ON UPDATE CASCADE
) ENGINE=InnoDB;

-- 3. Tabela de Ocorrências (Obrigatório vincular a Suíte OU Hóspede OU Ambos)
CREATE TABLE IF NOT EXISTS ocorrencias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    apartamento_id INT NULL,
    morador_id INT NULL,
    titulo VARCHAR(120) NOT NULL,
    descricao TEXT NOT NULL,
    tipo_ocorrencia ENUM('Quarto', 'Pertence Esquecido', 'Atendimento', 'Outros') DEFAULT 'Quarto',
    status ENUM('Pendente', 'Em Andamento', 'Resolvido') DEFAULT 'Pendente',
    data_registro DATETIME DEFAULT CURRENT_TIMESTAMP,
    
    -- Garante no banco que pelo menos um dos dois campos seja preenchido
    CONSTRAINT chk_ocorrencia_origem 
        CHECK (apartamento_id IS NOT NULL OR morador_id IS NOT NULL),
        
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
(1, '101', 'A', 'T-Grandão', 2, 'Disponivel'),
(2, '102', 'A', 'Praia', 4, 'Disponivel'),
(3, '103', 'A', 'Familia-Sacana', 6, 'Disponivel'),
(4, '201', 'B', 'Luxo', 2, 'Disponivel'),
(5, '202', 'B', 'Premium', 4, 'Disponivel'),
(6, '301', 'AA', 'Padrão', 2, 'Disponivel'),
(7, '302', 'AA', 'Padrão', 2, 'Disponivel');

INSERT INTO moradores (id, apartamento_id, cpf, telefone) VALUES
(1, NULL, '123.456.789-00', '(11) 98888-1001'),
(2, NULL, '234.567.890-11', '(11) 97777-2002'),
(3, NULL, '345.678.901-22', '(11) 96666-3003'),
(4, NULL, '456.789.012-33', '(11) 95555-4004'),
(5, NULL, '567.890.123-44', '(11) 94444-5005');

-- Exemplo de inserção de ocorrência só para hóspede (sem suíte)
INSERT INTO ocorrencias (apartamento_id, morador_id, titulo, descricao, tipo_ocorrencia, status) VALUES
(1, 1, 'Luz do quarto falhando', 'A luminária do quarto principal está piscando e precisa de manutenção.', 'Quarto', 'Pendente'),
(2, 2, 'Chave do quarto perdida', 'O hóspede informou que perdeu a chave de acesso do apartamento.', 'Pertence Esquecido', 'Em Andamento'),
(NULL, 3, 'Objeto esquecido na recepção', 'Carteira deixada na recepção pelo hóspede durante o checkout.', 'Pertence Esquecido', 'Pendente');