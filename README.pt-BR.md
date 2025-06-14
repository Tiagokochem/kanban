# Aplicação Kanban Board

Uma aplicação moderna de quadro Kanban construída com Laravel, Alpine.js e Tailwind CSS. Este projeto permite aos usuários criar quadros, categorias e tarefas para gerenciar seu fluxo de trabalho de forma eficiente.

*Leia em outros idiomas: [English](README.md)*

## Índice

- [Requisitos](#requisitos)
- [Instalação](#instalação)
- [Configuração com Docker](#configuração-com-docker)
- [Configuração Manual](#configuração-manual)
- [Executando a Aplicação](#executando-a-aplicação)
- [Estrutura do Projeto](#estrutura-do-projeto)
- [Funcionalidades](#funcionalidades)
- [Contribuindo](#contribuindo)
- [Licença](#licença)

## Requisitos

- PHP 8.2 ou superior
- Composer
- Node.js & NPM
- PostgreSQL
- Docker & Docker Compose (para configuração em contêiner)

## Instalação

### Configuração com Docker

Este projeto utiliza Laravel Sail para containerização Docker, tornando fácil configurar e executar a aplicação em um ambiente consistente.

1. Clone o repositório:
   ```bash
   git clone <repository-url>
   cd kanban-app
   ```

2. Instale as dependências do Composer usando o contêiner instalador do Laravel Sail:
   ```bash
   docker run --rm \
       -u "$(id -u):$(id -g)" \
       -v "$(pwd):/var/www/html" \
       -w /var/www/html \
       laravelsail/php84-composer:latest \
       composer install --ignore-platform-reqs
   ```

3. Copie o arquivo de ambiente:
   ```bash
   cp .env.example .env
   ```

4. Configure as variáveis de ambiente no arquivo `.env`:
   ```
   DB_CONNECTION=pgsql
   DB_HOST=pgsql
   DB_PORT=5432
   DB_DATABASE=kanban
   DB_USERNAME=sail
   DB_PASSWORD=password
   ```

5. Inicie os contêineres Docker:
   ```bash
   ./vendor/bin/sail up -d
   ```

6. Gere a chave da aplicação:
   ```bash
   ./vendor/bin/sail artisan key:generate
   ```

7. Execute as migrações:
   ```bash
   ./vendor/bin/sail artisan migrate
   ```

8. Instale as dependências NPM e compile os assets:
   ```bash
   ./vendor/bin/sail npm install
   ./vendor/bin/sail npm run dev
   ```

### Configuração Manual

Se você preferir executar a aplicação sem Docker:

1. Clone o repositório:
   ```bash
   git clone <repository-url>
   cd kanban-app
   ```

2. Instale as dependências do Composer:
   ```bash
   composer install
   ```

3. Copie o arquivo de ambiente:
   ```bash
   cp .env.example .env
   ```

4. Configure sua conexão de banco de dados no arquivo `.env`.

5. Gere a chave da aplicação:
   ```bash
   php artisan key:generate
   ```

6. Execute as migrações:
   ```bash
   php artisan migrate
   ```

7. Instale as dependências NPM e compile os assets:
   ```bash
   npm install
   npm run dev
   ```

## Executando a Aplicação

### Com Docker

```bash
# Inicie os contêineres
./vendor/bin/sail up -d

# Execute o servidor de desenvolvimento com Vite
./vendor/bin/sail npm run dev

# Acesse a aplicação em http://localhost
```

### Sem Docker

```bash
# Inicie o servidor de desenvolvimento do Laravel
php artisan serve

# Em outro terminal, inicie o Vite para os assets de frontend
npm run dev

# Acesse a aplicação em http://localhost:8000
```

## Estrutura do Projeto

A aplicação segue uma estrutura padrão de projeto Laravel com os seguintes componentes principais:

- **Models**: `Board`, `Category`, `Task` e `User`
- **Controllers**: Lidam com operações CRUD para quadros, categorias e tarefas
- **Views**: Templates Blade com Alpine.js para interatividade
- **Routes**: Rotas API e web para a aplicação

## Funcionalidades

- Autenticação e registro de usuários
- Criar e gerenciar múltiplos quadros Kanban
- Adicionar, editar e excluir categorias dentro dos quadros
- Criar, atualizar e excluir tarefas
- Funcionalidade de arrastar e soltar para tarefas entre categorias
- Interações baseadas em AJAX sem recarregamento de página
- Atualizações em tempo real usando requisições assíncronas
- Design responsivo com Tailwind CSS

## Contribuindo

Contribuições são bem-vindas! Sinta-se à vontade para enviar um Pull Request.

1. Faça um fork do repositório
2. Crie sua branch de feature (`git checkout -b feature/recurso-incrivel`)
3. Faça commit de suas alterações (`git commit -m 'Adiciona algum recurso incrível'`)
4. Faça push para a branch (`git push origin feature/recurso-incrivel`)
5. Abra um Pull Request

## Licença

Este projeto está licenciado sob a Licença MIT - veja o arquivo LICENSE para detalhes. 