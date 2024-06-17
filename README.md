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

#### 1. List Movies
Endpoint to retrieve a paginated list of movies, optionally filtered by title:

- **GET** `/api/movies`

Example:
```plaintext
GET http://localhost:8000/api/movies?page=1&title=example
```
#### 2. Retrieve Movie by ID
Endpoint to fetch details of a specific movie by its ID:

- **GET** `/api/movies/{id}`

Example:
```plaintext
GET http://localhost:8000/api/movies/1
```
#### 3. Add a New Movie
Endpoint to create a new movie with specified attributes:

- **POST** `/api/movies`

Example Request Body:
```json
{     
	"title": "Example Movie",     
	"description": "A description of the movie.",     
	"ageRestriction": "7", //Optional     
	"rating": 8.5,     
	"premieresAt": "2024-06-30 18:00:00" 
}
```
#### 4. Add Movie Broadcast
Endpoint to add a broadcast schedule for a specific movie:

- **POST** `/api/movies/{id}/broadcasts`

Example Request Body:
```json
{     
	"channelNr": 1,     
	"broadcastsAt": "2024-07-01 20:00:00" 
}
```
#### 5. Delete Movie
Endpoint to delete a movie by its ID:

- **DELETE** `/api/movies/{id}`

```plaintext
DELETE http://localhost:8000/api/movies/1
```

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
