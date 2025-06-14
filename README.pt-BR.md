# Aplicação Kanban Board

Uma aplicação moderna de quadro Kanban construída com Laravel, Alpine.js e Tailwind CSS. Este projeto permite aos usuários criar quadros, categorias e tarefas para gerenciar seu fluxo de trabalho de forma eficiente.

*Leia em outros idiomas: [English](README.md)*

Fiz um pequeno vídeo de demonstração do app segue o link https://drive.google.com/file/d/1JLQaT7pAYF-e9NcJ0x5-wfEIKDl30y3f/view?usp=sharing


## Índice

- [Requisitos](#requisitos)
- [Instalação](#instalação)
- [Configuração com Docker](#configuração-com-docker)
- [Configuração Manual](#configuração-manual)
- [Executando a Aplicação](#executando-a-aplicação)
- [Estrutura do Projeto](#estrutura-do-projeto)
- [Funcionalidades](#funcionalidades)
- [Integração com IA](#integração-com-ia)
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
   git clone https://github.com/Tiagokochem/kanban
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

## Integração com IA

**Integração com Groq IA para Produtividade Aprimorada**

Um dos recursos de destaque desta aplicação Kanban é a integração com a **IA do Groq** para criação inteligente de tarefas e cartões:

- **Geração de Tarefas com IA**: Os usuários podem aproveitar a IA do Groq para gerar automaticamente descrições e conteúdo de tarefas
- **Criação Inteligente de Cartões**: O sistema utiliza o avançado modelo de linguagem do Groq para ajudar a criar cartões bem estruturados
- **Sugestões de Conteúdo**: Assistência de IA para escrever descrições de tarefas e categorização
- **Automação para Economia de Tempo**: Reduz a entrada manual permitindo que a IA sugira detalhes de tarefas com base no contexto do projeto

Esta integração melhora significativamente a produtividade ao simplificar o processo de criação de tarefas e fornecer sugestões inteligentes durante todo o fluxo de trabalho.

## Contribuindo

Contribuições são bem-vindas! Sinta-se à vontade para enviar um Pull Request.

1. Faça um fork do repositório
2. Crie sua branch de feature (`git checkout -b feature/recurso-incrivel`)
3. Faça commit de suas alterações (`git commit -m 'Adiciona algum recurso incrível'`)
4. Faça push para a branch (`git push origin feature/recurso-incrivel`)
5. Abra um Pull Request

   ![Screenshot_11](https://github.com/user-attachments/assets/936168f1-b1c0-411f-9d9f-95f5addd6622)
   ![Screenshot_1](https://github.com/user-attachments/assets/ec2eda28-d80d-4352-86b9-48ce75d4eaa7)
   ![Screenshot_3](https://github.com/user-attachments/assets/97d17d70-6255-4c25-bb75-4b893edcded6)
   ![Screenshot_4](https://github.com/user-attachments/assets/b147cc6f-6c58-4e0a-a2ef-996010d8e913)
   ![Screenshot_5](https://github.com/user-attachments/assets/0e9ae4ca-f69a-4a9f-b63c-05cf42ec2245)
![Screenshot_6](https://github.com/user-attachments/assets/03abfff7-d8fb-46da-860a-527a0484346d)

## Licença

Este projeto está licenciado sob a Licença MIT - veja o arquivo LICENSE para detalhes. 
