cp .env.example .env
composer install
php artisan key:generate
php artisan migrate:refresh --seed
php artisan serve

use 'admin/manager/staff1/staff2@gmail.com' and password 12345678 to sign in
