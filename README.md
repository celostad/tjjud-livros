# 📚 Cadastro de Livros — Teste Técnico TJJUD

Sistema de cadastro de livros com CRUD completo, relatório em PDF e API REST.

## Stack

| Componente | Tecnologia |
|---|---|
| Linguagem | PHP 8.3 |
| Framework | Laravel 12 |
| Banco de Dados | MySQL 8.0 |
| Servidor Web | Apache 2.4 (mod_proxy_fcgi → PHP-FPM) |
| Containerização | Docker + Docker Compose |
| Frontend | Bootstrap 5 + Bootstrap Icons |
| PDF | barryvdh/laravel-dompdf |
| Testes | PHPUnit 11 (Unit + Feature) |

---

## Pré-requisitos

- Docker >= 24.x
- Docker Compose >= 2.x

---

## ⚡ Instalação


```bash
# 1. Copiar .env
cp src/.env.example src/.env

# 2. Subir containers
docker compose up -d --build

# 3. Instalar dependências
docker compose exec app composer install
# ou 
docker compose exec -T app composer install --no-interaction --prefer-dist --optimize-autoloader

# 4. Gerar chave
docker compose exec app php artisan key:generate

# 5. Migrations + dados de exemplo
docker compose exec app php artisan migrate --seed

# 6 Configurando cache e permissões
docker compose exec -T app php artisan config:cache
docker compose exec -T app php artisan route:cache
docker compose exec -T app php artisan view:cache
docker compose exec -T app chmod -R 775 storage bootstrap/cache
```

---

## 🌐 URLs

| Serviço | URL |
|---|---|
| Aplicação | http://localhost:8080 |
| phpMyAdmin | http://localhost:8081 |
| API REST | http://localhost:8080/api/livros |

---

## 📋 Modelo de Dados

```
Livro (Codl PK, Titulo, Editora, Edicao, AnoPublicacao, Valor)
    └── Livro_Autor (Livro_Codl FK, Autor_CodAu FK)  ──► Autor (CodAu PK, Nome)
    └── Livro_Assunto (Livro_Codl FK, Assunto_codAs FK) ──► Assunto (codAs PK, Descricao)
```

- Um livro pode ter **múltiplos autores** (N:N)
- Um livro pode ter **múltiplos assuntos** (N:N)
- Campo `Valor` adicionado conforme requisito (R$)

### View de relatório

```sql
vw_relatorio_livros_por_autor
-- Agrupa livros por autor com assuntos concatenados
-- Criada automaticamente pela migration
```

---

## 🔌 API REST

Base URL: `http://localhost:8080/api`

| Método | Endpoint | Descrição |
|---|---|---|
| GET | /livros | Lista todos os livros (paginado) |
| POST | /livros | Cria um livro |
| GET | /livros/{id} | Detalha um livro |
| PUT | /livros/{id} | Atualiza um livro |
| DELETE | /livros/{id} | Remove um livro |

**Payload POST/PUT:**
```json
{
  "Titulo": "Dom Casmurro",
  "Editora": "Companhia das Letras",
  "Edicao": 2,
  "AnoPublicacao": "1899",
  "Valor": 39.90,
  "autores": [1, 2],
  "assuntos": [1, 3]
}
```

---

## 🧪 Testes (TDD)

```bash
# Todos os testes
docker compose exec app php artisan test

# Somente unitários
docker compose exec app php artisan test --testsuite=Unit

# Somente feature
docker compose exec app php artisan test --testsuite=Feature
```

Cobertura:
- `LivroTest` (Unit) — criação, relacionamentos, validações, exclusão
- `LivroCrudTest` (Feature) — rotas HTTP, CRUD completo, API JSON
- `AutorAssuntoTest` (Feature) — CRUD de Autor e Assunto, restrições de exclusão

---

## 📄 Relatório PDF

Acesse **Relatório** no menu ou:

- Tela: `http://localhost:8080/relatorio`
- PDF: `http://localhost:8080/relatorio/pdf`

O relatório é gerado a partir da `vw_relatorio_livros_por_autor` e agrupa livros por autor com assuntos.

---

## 🛠 Comandos úteis

```bash
# Sobe containers
docker compose up -d

 # Para containers
 docker compose down

 # migrate:fresh --seed (reset completo)
docker compose exec app php artisan migrate:fresh --seed

# Tail de logs do app
docker compose logs -f app

# Limpa todos os caches
docker compose exec app php artisan optimize:clear
```

---

## 📁 Estrutura do Projeto

```
tjjud-livros/
├── docker/
│   ├── php/
│   │   ├── Dockerfile          # PHP 8.3-FPM Alpine
│   │   └── php.ini
│   ├── apache/
│   │   ├── httpd.conf
│   │   └── vhost.conf          # Proxy PHP-FPM
│   └── mysql/
│       └── init.sql
├── src/                        # Aplicação Laravel
│   ├── app/
│   │   ├── Http/
│   │   │   ├── Controllers/    # Web + Api/
│   │   │   └── Requests/       # FormRequests (validação)
│   │   └── Models/             # Livro, Autor, Assunto
│   ├── database/
│   │   ├── migrations/         # Tabelas + VIEW
│   │   └── seeders/            # Dados de exemplo
│   ├── resources/views/        # Blade templates Bootstrap 5
│   ├── routes/
│   │   ├── web.php             # Rotas web (resource)
│   │   └── api.php             # API REST
│   └── tests/
│       ├── Unit/LivroTest.php
│       └── Feature/
│           ├── LivroCrudTest.php
│           └── AutorAssuntoTest.php
├── docker-compose.yml
├── Makefile
├── setup.sh
└── README.md
```
