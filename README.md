# TA-NateSare
Tugas Akhir Pemrograman Berorientasi Service. E-Learning berbayar

## Build Setup (BackEnd)

```bash
1 Setting Xampp (require php 8.1.2)
Open php.ini remove command ; in "extension=gd"

2 Setting ENV
Copy data from .env.example
Setting database name

3 Run composer install

4 Run php artisan key:generate
5 Run php artisan storage:link
6 Run php artisan migrate:fresh --seed

7 Run php artisan serve
```

## Build Setup (FrontEnd Admin)

```bash
1 Setting ENV
Copy data from .env.example

2 Run composer install

3 Run php artisan key:generate

4 Run php artisan serve --port=8001
```
