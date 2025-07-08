
## Estrutura do Banco de Dados (MySQL)

CREATE TABLE administradores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE doadores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_completo VARCHAR(255) NOT NULL,
    cpf VARCHAR(14) NOT NULL UNIQUE, -- Formato: 123.456.789-00
    data_nascimento DATE NOT NULL,
    cep VARCHAR(9) NOT NULL, -- Formato: 12345-678
    tipo_sanguineo VARCHAR(5) NOT NULL,
    email VARCHAR(255) UNIQUE,
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    -- Campos do Questionário de Triagem --
    pesa_mais_50kg BOOLEAN NOT NULL,
    teve_febre_7dias BOOLEAN NOT NULL,
    fez_tatuagem_12meses BOOLEAN NOT NULL
);

CREATE TABLE locais_doacao (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_local VARCHAR(255) NOT NULL,
    cep VARCHAR(9) NOT NULL,
    endereco VARCHAR(255) NOT NULL,
    cidade VARCHAR(100) NOT NULL,
    estado VARCHAR(2) NOT NULL
);

CREATE TABLE doacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    doador_id INT NOT NULL,
    local_id INT NOT NULL,
    data_doacao DATE NOT NULL,
    volume_ml INT DEFAULT 450,
    observacoes TEXT,
    FOREIGN KEY (doador_id) REFERENCES doadores(id) ON DELETE CASCADE,
    FOREIGN KEY (local_id) REFERENCES locais_doacao(id)
);
