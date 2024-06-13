## Installation

### Prerequisites

Ensure you have the following installed:

- [Composer](https://getcomposer.org/)
- [PHP](https://www.php.net/)
- [Laravel](https://laravel.com/)
- [Vue.js](https://vuejs.org/)
- [Node.js](https://nodejs.org/)

### Steps

1. Clone the repository:
    ```bash
    git clone https://github.com/Duong8888/study-abroad.git
    ```
2. Navigate to the project directory:
    ```bash
    cd study-abroad
    ```
3. Install PHP dependencies:
    ```bash
    composer install
    ```
4. Install Node.js dependencies:
    ```bash
    npm install
    ```
5. Copy the `.env.example` file to `.env` and configure your environment variables:
    ```bash
    cp .env.example .env
    ```
6. Generate the application key:
    ```bash
    php artisan key:generate
    ```
7. Run the database migrations:
    ```bash
    php artisan migrate
    ```
8. Seed the database:
    ```bash
    php artisan db:seed
    ```
   This will create an admin account with the following credentials:
    - **Email:** admin@gmail.com
    - **Password:** 123

9. Build the front-end assets:
    ```bash
    npm run dev
    ```
10. Start the local development server:
    ```bash
    php artisan serve
    ```
### Running the Application

To start the application, use the following command:
```bash
php artisan serve
