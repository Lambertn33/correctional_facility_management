# About correctional facility management

This is a simple correctional facility management that helps the visitors to visit their family members who are imprisoned online
through video call.
visitors request appointments, make the payments and receive the code and the date when they will be joining the call.

after cloning the project run:
1. composer install --ignore-platform-reqs
2. cp .env.example .env
3. php artisan key:generate
4. php artisan storage:link
5. php artisan migrate --seed

The project is ready
