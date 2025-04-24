CREATE TABLE IF NOT EXISTS imoveis (
    id SERIAL PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    preco DECIMAL(10,2),
    descricao TEXT NOT NULL,
    endereco VARCHAR(255),
    garagem INT,
    imagem VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
