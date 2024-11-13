# Insider Champions League

A Laravel and Vue.js application that simulates a football league with prediction capabilities.

## Table of Contents

- [Prerequisites](#prerequisites)
- [Installation](#installation)
  - [1. Clone the Repository](#1-clone-the-repository)
  - [2. Install Backend Dependencies](#2-install-backend-dependencies)
  - [3. Install Frontend Dependencies](#3-install-frontend-dependencies)
  - [4. Copy the Environment File](#4-copy-the-environment-file)
  - [5. Generate Application Key](#5-generate-application-key)
  - [6. Configure Environment Variables](#6-configure-environment-variables)
  - [7. Run Migrations](#7-run-migrations)
  - [8. Seed the Database](#8-seed-the-database)
  - [9. Generate Fixtures](#9-generate-fixtures)
- [Running the Application](#running-the-application)
  - [1. Start the Backend Server](#1-start-the-backend-server)
  - [2. Compile Frontend Assets](#2-compile-frontend-assets)
    - [For Development (with Hot Reloading)](#for-development-with-hot-reloading)
    - [For Production](#for-production)
- [Running Tests](#running-tests)
- [Project Structure](#project-structure)
- [API Endpoints](#api-endpoints)
- [Custom Artisan Commands](#custom-artisan-commands)
- [Additional Notes](#additional-notes)
  - [Front-End Development](#front-end-development)
  - [Back-End Development](#back-end-development)
  - [Environment Variables](#environment-variables)
  - [Asset Compilation](#asset-compilation)
  - [Database](#database)
- [Screenshots](#screenshots)


---

## Prerequisites

Before you begin, ensure you have the following installed on your system:

- **PHP** >= 8.1
- **Composer**
- **Node.js** >= 16.x
- **NPM**
- **MySQL** or another supported database
- **Git**

---

## Installation

### 1. Clone the Repository

Open your terminal and run the following command to clone the repository:

```bash
git clone https://github.com/ahmetdogukancitak/champions-league.git
cd insider-champions-league
```

### 2. Install Backend Dependencies

Use Composer to install PHP dependencies:

```bash
composer install
```

### 3. Install Frontend Dependencies

Use NPM to install JavaScript dependencies:

```bash
npm install
```

### 4. Copy the Environment File

Create a copy of the `.env.example` file and rename it to `.env`:

```bash
cp .env.example .env
```

### 5. Generate Application Key

Run the following command to generate a unique application key:

```bash
php artisan key:generate
```

This will set the `APP_KEY` value in your `.env` file.

### 6. Configure Environment Variables

Open the `.env` file in a text editor and update the following settings:

#### Database Configuration

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=insider_champions_league
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
```

*Replace `your_database_username` and `your_database_password` with your actual database credentials.*

If you're using a different database system (e.g., PostgreSQL), adjust the `DB_CONNECTION`, `DB_PORT`, and other related settings accordingly.

**Create the Database:**

Ensure that a database named `insider_champions_league` exists. You can create it using your preferred database management tool or via the command line.

### 7. Run Migrations

Create the necessary database tables by running:

```bash
php artisan migrate
```

### 8. Seed the Database

Populate the database with initial data:

```bash
php artisan db:seed
```

This command will seed the `teams` table with initial team data using the `TeamSeeder` class.

### 9. Generate Fixtures

Create the league fixtures by running:

```bash
php artisan generate:fixtures
```

This custom Artisan command generates the match schedule for the league.

*Alternatively, you can generate fixtures within the UI when you run the application.*

---

## Running the Application

### 1. Start the Backend Server

Run the Laravel development server:

```bash
php artisan serve
```

By default, the application will be accessible at [http://127.0.0.1:8000](http://127.0.0.1:8000).

### 2. Compile Frontend Assets

#### For Development (with Hot Reloading)

In a separate terminal window, run:

```bash
npm run dev
```

This will compile your assets and enable hot module replacement for a better development experience.

#### For Production

Compile and optimize the frontend assets:

```bash
npm run build
```

This command minifies and optimizes your frontend assets for production.

---

## Running Tests

Execute the automated tests to ensure everything is working correctly:

```bash
php artisan test
```

This command runs the application's test suite, including unit tests like `GameSimulatorTest`.

---

## Project Structure

```
insider-champions-league/
├── app/
│   ├── Console/
│   │   └── Commands/
│   │       └── GenerateFixtures.php       # Generates league fixtures
│   ├── Http/
│   │   └── Controllers/
│   │       └── Api/
│   │           └── LeagueController.php   # Handles API requests
│   ├── Models/
│   │   ├── Game.php                       # Game model
│   │   └── Team.php                       # Team model
│   └── Services/
│       ├── FixtureGenerator.php           # Logic for fixture generation
│       ├── GameSimulator.php              # Logic for simulating games
│       └── PredictionService.php          # Logic for predictions
├── bootstrap/
├── config/
├── database/
│   ├── migrations/                        # Database migrations
│   └── seeders/
│       └── TeamSeeder.php                 # Seeds initial team data
├── public/
│   └── index.php                          # Entry point for the application
├── resources/
│   ├── js/
│   │   ├── app.js                         # Main JavaScript file
│   │   └── components/                    # Vue.js components
│   │       ├── Controls.vue
│   │       ├── Games.vue
│   │       ├── LeagueTable.vue
│   │       └── Predictions.vue
│   └── views/
│       └── welcome.blade.php              # Main Blade template
├── routes/
│   ├── api.php                            # API routes
│   └── web.php                            # Web routes
├── tests/
│   └── Unit/
│       ├── GameSimulatorTest.php          # Unit tests for game simulation
│       └── PredictionServiceTest.php      # Unit tests for prediction service accuracy
├── .env.example                           # Example environment variables
├── composer.json                          # PHP dependencies and scripts
├── package.json                           # Node.js dependencies and scripts
├── vite.config.js                         # Vite configuration
└── README.md                              # Project documentation
```

---

## API Endpoints

The application provides the following API endpoints:

| Method | Endpoint            | Description                                 |
|--------|---------------------|---------------------------------------------|
| GET    | `/api/league-table` | Retrieve the current league standings       |
| GET    | `/api/games`        | Retrieve all games with details             |
| POST   | `/api/simulate-week`| Simulate matches for the next week          |
| POST   | `/api/simulate-all` | Simulate all remaining matches              |
| GET    | `/api/predictions`  | Get championship prediction percentages     |
| PUT    | `/api/games/{id}`   | Update the score of a specific game         |

---

## Custom Artisan Commands

The project includes custom Artisan commands for league management:

### Generate Fixtures

Generates the match schedule for the league.

```bash
php artisan generate:fixtures
```

### Simulate Games

Simulates all unplayed games in the league.

```bash
php artisan simulate:games
```

---

## Testing

### Running Unit Tests

To run all unit tests, execute:

```bash
php artisan test
```

This command will execute tests in the `tests` directory, verifying that application logic works as expected.

### Running Specific Tests

To run a specific test file, use the `--filter` option:

```bash
php artisan test --filter=GameSimulatorTest
```

*Replace `GameSimulatorTest` with the name of the test class you want to run.*

---

## Additional Notes

### Front-End Development

- **Frameworks & Libraries:**
  - **Vue.js 3**
  - **Tailwind CSS**
- **Vue Components:**
  - Located in `resources/js/components/`
  - Key Components:
    - `Controls.vue`
    - `Games.vue`
    - `LeagueTable.vue`
    - `Predictions.vue`
- **Main JavaScript Entry Point:**
  - `resources/js/app.js`

### Back-End Development

- **Architecture:**
  - Follows Laravel's MVC (Model-View-Controller) architecture.
- **Business Logic:**
  - Encapsulated within the `app/Services/` directory.
- **API Controllers:**
  - Located under `app/Http/Controllers/Api/`

### Environment Variables

Ensure all necessary environment variables are set in your `.env` file. For features like mailing, caching, etc., update the corresponding settings as needed.

### Asset Compilation

- **Development Mode:**
  - Uses Vite's hot module replacement for a better development experience.
  - Command:
    ```bash
    npm run dev
    ```
- **Production Mode:**
  - Assets are minified and optimized for performance.
  - Command:
    ```bash
    npm run build
    ```

### Database

Make sure your database is set up and running before running migrations.

- **For MySQL Users:**
  - Ensure the MySQL service is running.
- **Database Configuration:**
  - Defined in the `.env` file under `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD`.

---

## Troubleshooting

### Common Issues

#### 1. `max(): Argument #1 ($value) must contain at least one element`

**Error Message:**
```
max(): Argument #1 ($value) must contain at least one element
```

**Cause:**
The `max()` function is being called on an empty array. This typically occurs when there are no teams or no points available to calculate the maximum.

**Solution:**

- **Ensure Teams Exist:**
  - Verify that the `teams` table has entries.
  - Run migrations and seeders if necessary:
    ```bash
    php artisan migrate --seed
    ```

- **Check `getLeagueStats()` Implementation:**
  - Ensure the `getLeagueStats()` method in the `Team` model correctly calculates and returns the 'points'.

- **Add Defensive Checks in `PredictionService`:**
  - Modify the `getChampionshipOdds` method to handle empty arrays before calling `max()`.

**Example Fix:**
```php
// Before calling max()
if (empty($simulatedPoints)) {
    // Handle the empty case, e.g., skip iteration or set default values
    continue;
}

$maxPoints = max($simulatedPoints);
```

#### 2. Database Connection Issues

**Symptoms:**
- Unable to connect to the database.
- Migration or seeder commands failing.

**Solution:**

- **Verify `.env` Configuration:**
  - Ensure `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` are correct.

- **Check Database Service:**
  - Ensure the database server (e.g., MySQL) is running.

- **Create Database:**
  - Manually create the database if it doesn't exist:
    ```sql
    CREATE DATABASE insider_champions_league;
    ```

#### 3. Missing Dependencies

**Symptoms:**
- Errors related to missing classes or packages.

**Solution:**

- **Install Dependencies:**
  - Backend:
    ```bash
    composer install
    ```
  - Frontend:
    ```bash
    npm install
    ```

- **Clear and Rebuild Caches:**
  ```bash
  php artisan config:clear
  php artisan cache:clear
  php artisan route:clear
  php artisan view:clear
  ```

---

## License

This project is open-source and available under the [MIT License](LICENSE).


## Screenshots
    ![Example1](https://github.com/ahmetdogukancitak/champions-league/blob/main/screenshots/ss1.png "Example 1")
    ![Example1](https://github.com/ahmetdogukancitak/champions-league/blob/main/screenshots/ss2.png "Example 2")
    ![Example1](https://github.com/ahmetdogukancitak/champions-league/blob/main/screenshots/ss3.png "Example 3")

   


---

**Note:** Replace placeholders like  `your_database_username`, and `your_database_password` with your actual values.# champions-league
