## Stepstone Movie Rentals

This mini-app allows users to rent movies via API calls. Some movies may have a tag applied to indicate that they are particualrly popular, in which case they have an upcharge applied, or have a discount applied.

We are using Laravel 11 and the latest PHP (8.4.2 as of this commit) and a SQLite database as our tech stack.

To run this app locally ensure you have composer and PHP installed and then clone this repo.

```
git clone git@github.com:Adam42/movierentals.git
cd movierentals
```

Once you have the repo locally go into the app directory, create a sqlite database and ensure you have a .env with the database connections setup:

```
touch database/database.sqlite
cp .env.example .env
```

Inside the .env file:
```
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database.sqlite
```

Then you'll install dependencies, geneerate an app key and setup the database and seed it with sample data. Below are the setup commands to run:

```
composer install
php artisan key:generate
php artisan migrate
php artisan db:seed
```

### Running the app

Once you've setup the app via the above steps you can run it locally via:
```
php artisan serve
```

Once up and running you can test out the POST orders endpoint by using CURL like so:

```
curl -X POST http://localhost:8000/api/v1/orders \
  -H "Content-Type: application/json" \
  -d '{"movie_ids":[1,2,3]}'
```
Ensure the list of movie_ids you pass in actually exist in the database table movies.

The above request should return back the below response using the seeded test data:

```
{"order":{"total":33.9715,"updated_at":"2025-01-23T00:12:59.000000Z","created_at":"2025-01-23T00:12:59.000000Z","id":6,"movies":[{"id":1,"title":"The Matrix","base_price":9.99,"tag":"trending_now","created_at":"2025-01-21T23:53:33.000000Z","updated_at":"2025-01-21T23:53:33.000000Z","deleted_at":null,"pivot":{"order_id":6,"movie_id":1,"created_at":"2025-01-23T00:12:59.000000Z","updated_at":"2025-01-23T00:12:59.000000Z"}},{"id":2,"title":"Interstellar","base_price":12.99,"tag":null,"created_at":"2025-01-21T23:53:33.000000Z","updated_at":"2025-01-21T23:53:33.000000Z","deleted_at":null,"pivot":{"order_id":6,"movie_id":2,"created_at":"2025-01-23T00:12:59.000000Z","updated_at":"2025-01-23T00:12:59.000000Z"}},{"id":3,"title":"The Shawshank Redemption","base_price":14.99,"tag":"under_radar","created_at":"2025-01-21T23:53:33.000000Z","updated_at":"2025-01-21T23:53:33.000000Z","deleted_at":null,"pivot":{"order_id":6,"movie_id":3,"created_at":"2025-01-23T00:12:59.000000Z","updated_at":"2025-01-23T00:12:59.000000Z"}}]}}
```
