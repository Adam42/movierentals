## Stepstone Movie Rentals

This mini-app allows users to rent movies via API calls. Some movies may have a tag applied to indicate that they are particualrly popular, in which case they have an upcharge applied, or have a discount applied.

We are using Laravel 11 and the latest PHP (8.4.2 as of this commit) and a SQLite database as our tech stack.

To run this app locally ensure you have composer and PHP installed and then clone this repo.

Once you have the repo locally go into the app directory, create a sqlite database and ensure you have a .env with this line present `DB_CONNECTION=sqlite`.

Then you'll install depedendies, geneerate an app key and setup the database and seed it with sample data. Below are the setup commands to run:

```
git clone git@github.com:Adam42/stepstonemovies.git
cd stepstonemovies
touch database/database.sqlite
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate
php artisan db:seed
```
