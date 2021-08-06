cp .env.example .env <br>
composer install <br>
php artisan key:generate <br>
php artisan migrate:refresh --seed <br>
php artisan serve <br>

use 'admin/manager/staff1/lghp1998@gmail.com' and password 12345678 to sign in <br>
admin ->role admin <br>
manager -> role manager <br>
lghp1998 -> role accounting staff <br>
staff1 -> role staff <br>

edit phần này cho file .env <br>
MAIL_MAILER=smtp <br>
MAIL_HOST=smtp.mailtrap.io<br>
MAIL_PORT=2525      <br>
MAIL_USERNAME=9c855d125375c2<br>
MAIL_PASSWORD=c0c993fef373aa<br>
MAIL_ENCRYPTION=tls<br>
//may dong tren kia thi lay tu mailtrap.io (phan Laravel 7+)<br>
MAIL_FROM_ADDRESS=namdt.98@gmail.com //email của m <br>
MAIL_FROM_NAME="${APP_NAME}"<br>




