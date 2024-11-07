CREATE TABLE usuario (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(255) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL
);

CREATE TABLE livro (
    id SERIAL PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    autor VARCHAR(100) NOT NULL,
    usuario_id INTEGER NOT NULL,
    urlimagem TEXT,
    comentario TEXT,
    nota INTEGER,
    status VARCHAR(20), NOT NULL 
);