# Kanban Board Application

A modern Kanban board application built with Laravel, Alpine.js, and Tailwind CSS. This project allows users to create boards, categories, and tasks to manage their workflow efficiently.

*Read this in other languages: [Português](README.pt-BR.md)*

## Table of Contents

- [Requirements](#requirements)
- [Installation](#installation)
- [Setup with Docker](#setup-with-docker)
- [Manual Setup](#manual-setup)
- [Running the Application](#running-the-application)
- [Project Structure](#project-structure)
- [Features](#features)
- [Contributing](#contributing)
- [License](#license)

## Requirements

- PHP 8.2 or higher
- Composer
- Node.js & NPM
- PostgreSQL
- Docker & Docker Compose (for containerized setup)

## Installation

### Setup with Docker

This project uses Laravel Sail for Docker containerization, making it easy to set up and run the application in a consistent environment.

1. Clone the repository:
   ```bash
   git clone <repository-url>
   cd kanban-app
   ```

2. Install Composer dependencies using the Laravel Sail installer container:
   ```bash
   docker run --rm \
       -u "$(id -u):$(id -g)" \
       -v "$(pwd):/var/www/html" \
       -w /var/www/html \
       laravelsail/php84-composer:latest \
       composer install --ignore-platform-reqs
   ```

3. Copy the environment file:
   ```bash
   cp .env.example .env
   ```

4. Configure the environment variables in `.env` file:
   ```
   DB_CONNECTION=pgsql
   DB_HOST=pgsql
   DB_PORT=5432
   DB_DATABASE=kanban
   DB_USERNAME=sail
   DB_PASSWORD=password
   ```

5. Start the Docker containers:
   ```bash
   ./vendor/bin/sail up -d
   ```

6. Generate application key:
   ```bash
   ./vendor/bin/sail artisan key:generate
   ```

7. Run migrations:
   ```bash
   ./vendor/bin/sail artisan migrate
   ```

8. Install NPM dependencies and build assets:
   ```bash
   ./vendor/bin/sail npm install
   ./vendor/bin/sail npm run dev
   ```

### Manual Setup

If you prefer to run the application without Docker:

1. Clone the repository:
   ```bash
   git clone <repository-url>
   cd kanban-app
   ```

2. Install Composer dependencies:
   ```bash
   composer install
   ```

3. Copy the environment file:
   ```bash
   cp .env.example .env
   ```

4. Configure your database connection in the `.env` file.

5. Generate application key:
   ```bash
   php artisan key:generate
   ```

6. Run migrations:
   ```bash
   php artisan migrate
   ```

7. Install NPM dependencies and build assets:
   ```bash
   npm install
   npm run dev
   ```

## Running the Application

### With Docker

```bash
# Start the containers
./vendor/bin/sail up -d

# Run development server with Vite
./vendor/bin/sail npm run dev

# Access the application at http://localhost
```

### Without Docker

```bash
# Start the Laravel development server
php artisan serve

# In another terminal, start Vite for frontend assets
npm run dev

# Access the application at http://localhost:8000
```

## Project Structure

The application follows a standard Laravel project structure with the following key components:

- **Models**: `Board`, `Category`, `Task`, and `User`
- **Controllers**: Handle CRUD operations for boards, categories, and tasks
- **Views**: Blade templates with Alpine.js for interactivity
- **Routes**: API and web routes for the application

## Features

- User authentication and registration
- Create and manage multiple Kanban boards
- Add, edit, and delete categories within boards
- Create, update, and delete tasks
- Drag and drop functionality for tasks between categories
- AJAX-powered interactions with no page refreshes
- Real-time updates using asynchronous requests
- Responsive design with Tailwind CSS

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the LICENSE file for details.
