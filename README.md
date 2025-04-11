
# REPERTÓRIO - PAGODE DO BASÍLIO

```lua
repertorio/
├── config/
│   └── db.php               ← Conexão com o banco de dados
├── public/
│   ├── index.php            ← Listagem de canções
│   ├── add.php              ← Cadastro de nova canção
│   ├── edit.php             ← Edição
│   ├── delete.php           ← Exclusão
│   ├── assets/
│   │   ├── css/
│   │   └── js/
├── sql/
│   └── repertorio.sql       ← Script do banco de dados
└── README.md
```

---

| BLOCOS (lado esquerdo) | CONTEÚDO |
| ---------------------- | --------- |
| ▸ Bloco 1             |           |
| - Canção A           |           |
| - Canção B           |           |
| ▸ Bloco 2             |           |
| - Canção C           |           |

---

![image](https://github.com/user-attachments/assets/9385883f-fa91-48d6-9d91-d63bf8a93f6d)

---

# Pagode do Basílio - Gerenciador de Repertório

Sistema CRUD em PHP 8.4 + MySQL + Bootstrap + jQuery para gerenciar o repertório musical do grupo **Pagode do Basílio**.

## 🌟 Recursos principais

- Cadastro, edição e exclusão de canções
- Organização por blocos com drag & drop
- Trechos com tooltip responsivo
- Registro de intérprete, tom, gênero/BPM e link de referência
- Impressão em PDF com logo e músicos do dia
- Gerenciador de músicos por data
- Layout responsivo com Bootstrap 5

---

## 📂 Tecnologias

- PHP 8.4
- MySQL 8+
- Bootstrap 5.3
- jQuery 3.7
- Dompdf (para PDF)
- Sortable.js (drag & drop)
- Nginx + WSL2 (desenvolvimento local)

---

## ⚖️ Requisitos para execução local

- PHP com FPM (8.4+)
- MySQL Server ou MariaDB
- Composer
- Nginx (ou Apache)
- WSL2 (caso esteja em Windows)

---

## 🚀 Instalação

```bash
# Clone o repositório
cd /var/www/
git clone https://github.com/seuusuario/pagode-do-basilio-repert.git

# Acesse o diretório
cd pagode-do-basilio-repert

# Instale dependências do PDF
composer install

# Crie o banco e a estrutura
mysql -u root -p < database/estrutura.sql
```

---

## 📊 Estrutura do banco (resumo)

Tabelas principais:

- `cancoes`: repertório com título, trecho, tom, intérprete, gênero, bpm, link, bloco e ordem
- `musicos`: controle de músicos por data do evento

---

## 📤 Geração do PDF

O PDF pode ser gerado acessando:

```
http://localhost/gerar_pdf.php
```

> O Dompdf renderiza o logo, título, músicos do dia e os blocos de canções organizados.

---

## 🏠 Nginx local (exemplo)

```nginx
server {
  listen 80;
  server_name pagodedobasilio.local;

  root /var/www/pagode-do-basilio-repert/public;
  index index.php;

  location / {
    try_files $uri $uri/ /index.php?$query_string;
  }

  location ~ \.php$ {
    include snippets/fastcgi-php.conf;
    fastcgi_pass unix:/run/php/php8.4-fpm.sock;
    fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    include fastcgi_params;
  }
}
```

---

## 🔧 Próximos passos

- Upload de logo customizado
- Geração de PDF por data
- Histórico de repertórios anteriores
- Login para os integrantes

---

## 👋 Autor

Desenvolvido por [Rubinho Lyra](https://github.com/rubenslyra) — integrando música e tecnologia no domínio da harmonia funcional!

---

## ✉️ Contato

- Instagram: [@rubinholyra](https://instagram.com/rubinholyra)
