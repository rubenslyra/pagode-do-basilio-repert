CREATE DATABASE IF NOT EXISTS pagode_basilio CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE pagode_basilio;

CREATE TABLE cancoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    trecho TEXT,
    interprete VARCHAR(255),
    genero_bpm VARCHAR(100),
    link_referencia VARCHAR(512),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE musicos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    instrumento VARCHAR(100),
    dia DATE NOT NULL
);

ALTER TABLE cancoes ADD COLUMN bloco VARCHAR(50) DEFAULT NULL;
ALTER TABLE cancoes ADD COLUMN ordem INT DEFAULT 0;