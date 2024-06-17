### Project Description

This Laravel application manages a movie database, allowing users to interact with movies and their broadcast schedules via a RESTful API. It includes endpoints for listing movies, retrieving specific movies by ID, adding new movies, adding broadcast schedules for movies, and deleting movies.
### Project Setup Instructions

#### 1. Clone the Repository

Clone your Laravel project repository and navigate to the project folder:
```bash
git clone <repository_url> 
cd <project_folder>
```
#### 2. Install Dependencies

Ensure PHP and Composer are installed, then install Laravel dependencies:
```bash
composer install
```
#### 3. Environment Configuration

Copy the `.env.example` file to `.env` and configure your database connection:
```bash
cp .env.example .env
```
Update `.env` file with your database credentials:
```dotenv
DB_CONNECTION=mysql 
DB_HOST=127.0.0.1 
DB_PORT=3306 
DB_DATABASE=your_database_name 
DB_USERNAME=your_database_username 
DB_PASSWORD=your_database_password
```
#### 4. Generate Application Key

Generate the Laravel application key:
```bash
php artisan key:generate
```
#### 5. Run Migrations

Run database migrations to create necessary tables:
```bash
php artisan migrate
```
Or run database migration to create necessary tables and fill database with test data:
```bash
php artisan migrate --seed
```
#### 6. Start Development Server

Launch the Laravel development server:
```bash
php artisan serve
```

**Your application will be accessible at `http://localhost:8000` by default.**

### API Endpoints

**To see all available API Endpoints you need to import into Postman application using provided API_routes.postman_collection.json file in application base directory**
### Adding/Changing Roles and Abilities

#### 1. Define Enums

Firstly, define enums for roles and abilities. To add new Abilities to roles you need to provide them in RolesEnum.php file in abilities() function
```php
// app/Enums/AbilitiesEnum.php
namespace App\Enums;

enum AbilitiesEnum

{
    public const ViewMovies = 'movies:view';
    public const CreateMovies = 'movies:create';
    public const UpdateMovies = 'movies:update';
    public const DeleteMovies = 'movies:delete';
    public const ViewMovieBroadcast = 'movie-broadcast:view';
    public const CreateMovieBroadcast = 'movie-broadcast:create';
    // Add mor abilities as needed
}

```
```php
// app/Enums/RolesEnum.php 
namespace App\Enums; 

class RolesEnum 
{ 
	const EDITOR = 'editor'; 
	const ADMINISTRATOR = 'admin'; 
	// Add more roles as needed

    public function abilities(): array
    {
        return match ($this) {
            self::Editor => [
                AbilitiesEnum::ViewMovies,
                AbilitiesEnum::CreateMovies,
                AbilitiesEnum::UpdateMovies,
                AbilitiesEnum::ViewMovieBroadcast,
            ],
            self::Administrator => [
                AbilitiesEnum::ViewMovies,
                AbilitiesEnum::CreateMovies,
                AbilitiesEnum::UpdateMovies,
                AbilitiesEnum::DeleteMovies,
                AbilitiesEnum::ViewMovieBroadcast,
                AbilitiesEnum::CreateMovieBroadcast,
            ],
            default => [],
        };
    }
}
```
