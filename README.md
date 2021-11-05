# 🇯🇵 Bizmates - Travel and Weather App

You should have a **PHP 8+** and **Node 16+** installed in your machine to run the application. Clone the repository then install the dependencies using composer and npm. I will send via email the credentials for OpenWeather and Foursquare APIs.

```bash
git clone git@github.com:plmrlnsnts/bizmates-travel.git
cd bizmates-travel
cp .env.example .env
composer install && php artisan key:generate
npm install && npm run dev
php artisan serve
```

## 🥞 Tech Stack

 We are using Inertia.js and its Vue 3 adapter, paired with Tailwind CSS to build the frontend application.

 We are using Laravel for backend and server side rendering. We have a caching strategy to avoid exhausting the API quota of OpenWeather and Foursquare APIS.

## 🚀 Features

Here's a gif to showcase the overall experience of the application.

![Demo GIF](./docs/demo.gif)

- 🤖 This is a single page application so every visit is snappy.
- 💨 We cache all requests from third-party APIs so it's blazing fast after your first visit.
- ⌨️ Keyboard accessibility is taken into consideration. Meaning you can easily navigate throughout the page using your keyboard.
- ✨ All the UI design are custom. The icons are from [Heroicons](https://heroicons.com/]).
