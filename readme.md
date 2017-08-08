<p align="center"><h1>MarketPlace</h1></p>

## About MarketPlace

MarketPlace is a filemarket place where users can buy or sell files.
Based on the development branch of the Laravel framework. (5.5).
Redis database for jobs with a Laravel Horizon dashboard.
<i>Experiment the Bulma framework.</i>

## Features

<ul>
    <li>Send emails and sms when a sale occured</li>
    <li>Show monthly and lifetime commission for the admin of the website</li>
    <li>Show monthly and lifetime earning for each users</li>
</ul>

## Installation

<ol>
    <li>`git clone https://github.com/yovanoc/marketplace`</li>
    <li>`cd marketplace`</li>
    <li>`cp .env.example .env`</li>
    <li>`php artisan key:generate`</li>
    <li>Fill correctly the .env file with database, nexmo, stripe, pusher and other infos.</li>
    <li>Keep running a redis database and fill connection informations too.</li>
    <li>`composer install && composer update`</li>
    <li>`npm install && npm update`</li>
    <li>`npm run dev` for compiling assets (js & css)</li>
    <li>`php artisan migrate`</li>
    <li>Always keep running `php artisan horizon` for jobs</li>
    <li>Enjoy :)</li>
</ol>

## References

- [Laravel](https://laravel.com)
- [Laravel Horizon](https://horizon.laravel.com/)
- [Stripe](https://stripe.com)
- [Bulma](http://bulma.io/)
- [Dropzone](http://www.dropzonejs.com/)
- [Pusher](https://pusher.com/)
- [Nexmo](https://www.nexmo.com)

## License

This project take the same License as the Laravel framework. Is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
