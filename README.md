# Crypto Balance Monitor
User's personal cabinet with registration and authorization.
Crypto Wallet and Balance changes History.

## Technology included

* `nginx:1.14`
* `mysql:5.7`
* `php-fpm7.2`

## Requirements

* [Docker Native](https://www.docker.com/products/overview)

## Running

Clone the repository.

Change directory into the cloned project.

Run the following commands:

```sh
$ cp docker-compose.override.yml.dist docker-compose.override.yml
$ docker-compose up -d
$ docker-compose exec php composer install
$ docker-compose exec php phing
```
If you want to create a super admin user, execute the following command:

```sh
$ docker-compose exec php phing create-superadmin
```

The super admin user will be generated with the following params:
* username: `admin`
* email:    `admin@admin.com`
* password: `admin`

Super admin has access to all parts of the system and data on all users.

An ordinary user sees only information about his/her wallets.


## Example

Go to `http://localhost`

## Results

You will be able to register and authorize in the Crypto Balance Monitor system.

**For testing period were added some hack:**
random generation of Wallet balance value byt updating user wallet form edit form.

**The command that allows you to collect statistics on the balance of wallets.**

can be added to crontab:

```sh
$ docker-compose exec php service cron start
```

or started manually:

```sh
$ docker-compose exec php bin/console app:balance-statistic
```

The results will be stored in the **Balance History** page.

Run the command below if you want to stop crontab execution:

```sh
$ docker-compose exec php service cron stop
```

## Email sending

If you want to send an emails to users about changes their wallet's balances
update `.env` file and then **restart docker service php**:

* set `MAILER_URL` environment variable value to `gmail://username:password@localhost`
where your should set your own gmail username (email) and password. 

If you will get problem with authentication (blocking by gmail) 
take a look into [symfony official doc](https://symfony.com/doc/current/email.html#using-gmail-to-send-emails)
