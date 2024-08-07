# About
Sistem ini menggunakan Laravel 11, pastikan php anda 8+ , dan sistem ini menggunaakan caching redis jadi diharapkan komputer anda sudah terinstall redis maupun ext php `php-ext-redis`

# API Documentation
```bash
https://documenter.getpostman.com/view/20628988/2sA3rzJXhK
```

# Error
jika anda mendapatkan error passport ` "message": "Personal access client not found. Please create one."`
jalankan command ini
```bash
php artisan passport:client --personal
```
kemudian enter sampai selesai


# Path 
Untuk logika bisnis anda bisa melohat pada folder reposiotires

    ├── ...
    ├── App                      
    │   ├── Repositories         # Bussinese logic here
    └── ...

# Installation

```bash
git clone https://github.com/MRizki28/Payment-Technical-Test
```

install composer

```bash
composer install
```

generate key

```bash
php artisan key:generate
```

### Migration table and seeder

```bash
php artisan migrate::fresh --seed
```

### Run Project

```bash
php artisan serve
```

queue run
```bash
php artisan queue:work
```

### Unit test
```bash
php artisan test
```

### Horizon 
silahkan akses `http://localhost:8000/horizon` jika anda mengunakan docker ubah port ke `8888`
```bash
php artisan horizon
```

### Docker
Jika anda menggunakan docker 

```bash
docker-compose up -d
```

open terminal apps in docker
```bash
docker exec -it e-payment bash
```
setelah berhasil silahkan jalankan command artisan seperti biasa

jika anda menggunakan docker database sudah di setup via phpmyadmin dengan user dan password default 
`root` dan password `12345678` jika anda ingin menggubah silahkan ubah pada .env yang tertera komentar

```bash
http://localhost:8083
```

untuk mengakses redis pada docker
```bash
docker exec -it e-payment-redis bash
```

setelah itu jalankan command redis seperti biasa
```bash
redis-cli
```
