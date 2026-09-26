# Task Manager

Simple web application for task management, developed with Laravel 13, Vue 3, Inertia.js, and MySQL.

It allows users to create, edit, delete, and reorder tasks using drag & drop. As an additional feature, tasks can be associated with projects and filtered using a project selector.

## Technologies

- PHP 8.3+
- Laravel 13
- Vue 3
- TypeScript
- Inertia.js
- Tailwind CSS
- MySQL / MariaDB
- Vite
- Composer
- Node.js / npm

## Requirements

- PHP >= 8.3
- Composer
- Node.js and npm
- MySQL or MariaDB
- Git

## Installation

### 1. Clone the project

```bash
git clone <REPOSITORY_URL>

cd task-manager
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Configure the environment

```bash
cp .env.example .env
```

Configure the database variables in `.env`:

```env
DB_CONNECTION=mysql

DB_HOST=127.0.0.1

DB_PORT=3306

DB_DATABASE=task_manager

DB_USERNAME=root

DB_PASSWORD=
```

### 4. Generate the application key

```bash
php artisan key:generate
```

### 5. Create the database

Create a MySQL database named:

```text
task_manager
```

### 6. Run migrations and test data

```bash
php artisan migrate:fresh --seed
```

This creates the tables and generates test data.

### 7. Install frontend dependencies

```bash
npm install
```

### 8. Run Vite

In one terminal:

```bash
npm run dev
```

### 9. Run Laravel

In another terminal:

```bash
php artisan serve
```

Open:

```text
http://127.0.0.1:8000
```

## Features

### Projects

- Create project
- Edit project
- Delete project
- View projects
- Associate tasks with a project

### Tasks

- Create task
- Edit task
- Delete task
- Display priority
- Persist timestamps
- Associate task with a project

### Drag & Drop

Tasks can be dragged in the browser.

The position automatically determines the priority:

```text
Position 1 → priority 1

Position 2 → priority 2

Position 3 → priority 3

...
```

The new order is sent to the backend and the priorities are updated within a database transaction.

### Project Selector

The `/tasks` view allows the user to select a project using a dropdown.

For example:

```text
/tasks?project=2
```

When a project is selected, only the tasks associated with that project are displayed.

## Application Flow

```text
Login

  ↓

Dashboard

  ↓

Task Manager

  ↓

Projects

  ↓

View Tasks

  ↓

Create / Edit / Delete / Drag & Drop
```

It is also possible to access `/tasks` directly, where the project selector is available.

## Main Structure

```text
app/

├── Http/

│   ├── Controllers/

│   │   ├── ProjectController.php

│   │   └── TaskController.php

│   └── Requests/

│       ├── StoreProjectRequest.php

│       ├── UpdateProjectRequest.php

│       ├── StoreTaskRequest.php

│       └── UpdateTaskRequest.php

└── Models/

    ├── Project.php

    └── Task.php

database/

├── factories/

├── migrations/

└── seeders/

resources/js/

├── pages/

│   ├── Dashboard.vue

│   ├── Projects/

│   └── Tasks/

└── components/

routes/

└── web.php
```

## Database

### projects

| Field | Type | Description |
|---|---|---|
| id | BIGINT | Identifier |
| name | VARCHAR(255) | Project name |
| created_at | TIMESTAMP | Creation timestamp |
| updated_at | TIMESTAMP | Last update timestamp |

### tasks

| Field | Type | Description |
|---|---|---|
| id | BIGINT | Identifier |
| project_id | BIGINT | Associated project |
| name | VARCHAR(255) | Task name |
| priority | INT | Position/priority |
| created_at | TIMESTAMP | Creation timestamp |
| updated_at | TIMESTAMP | Last update timestamp |

`project_id` is a foreign key referencing `projects.id` with cascading deletion.

## Useful Commands

Clear caches:

```bash
php artisan optimize:clear
```

Recreate the database and test data:

```bash
php artisan migrate:fresh --seed
```

Check migration status:

```bash
php artisan migrate:status
```

Run tests:

```bash
php artisan test
```

## Note

The project uses Inertia.js to keep Laravel as the main application and Vue as the presentation layer, avoiding the need to implement a separate REST API for this scope.