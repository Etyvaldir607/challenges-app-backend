# prerequisits
ubuntu
docker

# clone repository

# execute composer install
composer install

# add sail to environment variables
alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'

# init docker
sail up -d

# copy .env.example to .env

# execute migrations from php or sail
php artisan migrate
sail artisan migrate (optional)

# execute test from php or sail
php artisan test
sail artisan test (optional)
