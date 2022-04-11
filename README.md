<p align="center"><a href="https://paperweights.io" target="_blank"><img src="https://raw.githubusercontent.com/james-geiger/paper-weights/main/art/paperweights-white-lockout.png" width="600"></a></p>

## About Paper Weights

Paper Weights is a workout log and planner app designed to provide a quick and intutitive experience to tracking your workouts.  It is designed with the ease of paper logs in mind while providing advanced tracking and trend capabilities.

## Account and Beta Access

Users may access the current dev branch of this app to use for their own workout tracking purposes at [app.paperweights.io](https://app.paperweights.io).  The services is provided without warranty of any kind, and is subject to change.

## Development

To install Paper Weights locally for development or self-hosting, first clone the repository, `cd` into the directory, and follow the instructions below.

1. Create .env file

``` bash
mv .env.example .env
```

2. Install Composer dependencies

``` bash
composer install
```

3. Install NPM and build assets for development

``` bash
npm install && npm run dev
```

4. Generate application key

``` bash
php artisan key:generate
```

4. Run database migrations

``` bash
php artisan migrate
```

5. Link app storage directory with public diretory to serve profile photos

``` bash
php artisan storage:link
```

5. Run Laravel Scout import script for searchable exercises, if using scaffolded exercises.

``` bash
php artisan scout:import "App\Models\Exercise"
```

## Contributing

Thank you for considering contributing to Paper Weights! Please review the [contribution code of conduct](https://github.com/james-geiger/paper-weights/blob/main/CODE_OF_CONDUCT.md).

## Security Vulnerabilities

If you discover a security vulnerability within the Paper Weights app, please send an e-mail to our vulnerability inbox via [security@paperweights.io](mailto:security@paperweights.io). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [New BSD License](https://github.com/james-geiger/paper-weights/blob/main/LICENSE.md).
