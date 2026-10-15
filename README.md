# Atividade Básica de API

Atividade da disciplina com três partes: consumo de uma API gratuita, criação de uma API RESTful e um projeto consumidor (desafio).

**Autor:** Gabriel Krupek

## Estrutura do repositório

```
.
├── consumo-api/           # Parte 1: Laravel consumindo a PokéAPI
├── api-produtos/          # Parte 2: API RESTful de produtos (Laravel)
├── consumidor-produtos/   # Desafio: projeto Vue que consome a api-produtos
└── postman/
    └── API-Produtos.postman_collection.json
```

---

## Parte 1: Consumo de API gratuita (PokéAPI)

Projeto Laravel que consome a [PokéAPI](https://pokeapi.co/) e devolve os dados de um Pokémon em JSON.

### Como rodar

```bash
cd consumo-api
composer install
cp .env.example .env
php artisan key:generate
php artisan serve
```

### Rota

| Método | URI | Descrição |
|---|---|---|
| GET | `/pokemon/{nome}` | Retorna nome, altura, peso, tipos e imagem do Pokémon |

Exemplo: `http://127.0.0.1:8000/pokemon/pikachu`

---

## Parte 2: Criação da API (Produtos)

API REST em Laravel com CRUD de produtos, usando:

- **Rotas RESTful** (`Route::apiResource`)
- **Resource** (`ProdutoResource`) para padronizar a saída JSON
- **Form Request** (`ProdutoRequest`) para validação
- **Testes com Postman**

### Como rodar

```bash
cd api-produtos
composer install
cp .env.example .env
php artisan key:generate
```

No `.env`, use SQLite para simplificar:

```
DB_CONNECTION=sqlite
```

Depois:

```bash
touch database/database.sqlite
php artisan migrate
php artisan serve
```

A API fica disponível em `http://127.0.0.1:8000/api`.

### Rotas

| Método | URI | Ação | Status esperado |
|---|---|---|---|
| GET | `/api/produtos` | Lista todos os produtos | 200 |
| POST | `/api/produtos` | Cria um produto | 201 |
| GET | `/api/produtos/{id}` | Mostra um produto | 200 |
| PUT/PATCH | `/api/produtos/{id}` | Atualiza um produto | 200 |
| DELETE | `/api/produtos/{id}` | Remove um produto | 204 |

### Exemplo de corpo (POST/PUT)

```json
{
  "nome": "Teclado Mecânico",
  "descricao": "Switch azul, ABNT2",
  "preco": 249.90,
  "estoque": 15
}
```

### Validação

| Campo | Regra |
|---|---|
| nome | obrigatório, texto, máx. 255 |
| descricao | opcional, texto |
| preco | obrigatório, numérico, mínimo 0 |
| estoque | inteiro, mínimo 0 |

Dados inválidos retornam `422 Unprocessable Entity`.

> Nas requisições, envie o header `Accept: application/json`.

### Testes no Postman

A collection está em `postman/API-Produtos.postman_collection.json`.

1. Abra o Postman e clique em **Import**.
2. Selecione o arquivo da collection.
3. Com a API rodando, execute as requisições (criar, listar, buscar, atualizar, excluir e o teste de validação com `nome` vazio).

Prints dos testes: pasta `postman/prints/` (se aplicável).

---

## Desafio: Projeto consumidor (Vue)

Projeto em Vue 3 (Vite) que consome a API de produtos criada na Parte 2, listando, cadastrando e excluindo produtos.

### Pré-requisito: CORS

Na `api-produtos`, libere a origem do Vue em `config/cors.php`:

```php
'paths' => ['api/*'],
'allowed_origins' => ['http://localhost:5173'],
```

### Como rodar

Primeiro, deixe a `api-produtos` rodando (`php artisan serve`). Depois:

```bash
cd consumidor-produtos
npm install
npm run dev
```

Acesse `http://localhost:5173`.

---

## Tecnologias

- PHP / Laravel
- SQLite
- Vue 3 + Vite + Axios
- Postman
- [PokéAPI](https://pokeapi.co/)

Sim eu pedi pro chat deixar bonitinho
