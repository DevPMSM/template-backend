# 📦 Projeto Laravel API

Este é um projeto desenvolvido com **Laravel**, que utiliza **Laravel Breeze** para autenticação e **Swagger (OpenAPI)** para documentação da API.

---

## 🚀 Tecnologias Utilizadas

* **PHP** >= 8.2
* **Laravel** >= 12
* **Laravel Breeze** (Autenticação)
* **Swagger / OpenAPI** (Documentação da API)
* **MySQL** (Bando de Dados)
* **Composer**

---

## 🔐 Autenticação

A autenticação do projeto foi implementada utilizando **Laravel Breeze**, fornecendo:

* Registro de usuários
* Login
* Logout
* Proteção de rotas autenticadas

### Middleware

As rotas protegidas utilizam o middleware:

```php
->middleware('auth')
```

Ou, no caso de API:

```php
->middleware('auth:sanctum')
```

---

## 📑 Documentação da API (Swagger)

A API deve está documentada utilizando **Swagger (OpenAPI)**, facilitando a visualização e testes dos endpoints.

### Acesso à Documentação
Para gerar a página de documentação do Swagger utilize o seguinte comando no terminal:
```
php artisan l5-swagger:generate
```

Após subir o projeto, e gerar a página de documentação a mesma pode ser acessada em:

```
http://localhost:8000/api/documentation
```

### Exemplo de Anotação Swagger

```php
/**
 * @OA\Get(
 *   path="/api/users",
 *   summary="Lista usuários",
 *   tags={"Users"},
 *   security={{"bearerAuth":{}}},
 *   @OA\Response(
 *     response=200,
 *     description="Sucesso"
 *   )
 * )
 */
```
 O arquivo UserContrller contém mais exemplo das anotações do Swagger.

---

## ⚙️ Instalação do Projeto

### 1️⃣ Clonar o repositório

```bash
git clone <url-do-repositorio>
cd nome-do-projeto
```

### 2️⃣ Instalar dependências

```bash
composer install
```

### 3️⃣ Configurar o ambiente

```bash
cp .env.example .env
php artisan key:generate
```

Configure o banco de dados no arquivo `.env`.

### 4️⃣ Rodar as migrations

```bash
php artisan migrate
```

### 5️⃣ Iniciar o servidor

```bash
php artisan serve
```

---

## 📌 Boas Práticas Utilizadas

* Separação de responsabilidades (Controllers, Requests, Resources)
* Validação de dados via Form Requests
* Autenticação baseada em middleware
* Documentação padronizada com OpenAPI

---

## 🧠 Observações

* Certifique-se de que o Swagger está corretamente configurado antes de acessar a documentação.
* Caso utilize autenticação via **Bearer Token**, informe o token no Swagger.

---

