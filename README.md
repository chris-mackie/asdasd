## Pusher example

This is a simple example of how to use Laravel with Vue and Pusher.

### Prerequisites
- PHP >= 8.2

## Installation

### STEP 1: Create Pusher App
- Go to [Pusher](https://pusher.com/) and create an account
- Create a new app
- Copy the `app_id`, `key`, `secret`, `cluster` and paste them in the `.env` file like this:
```
PUSHER_APP_ID=your_app_id
PUSHER_APP_KEY=your_app_key
PUSHER_APP_SECRET=your_app_secret
PUSHER_APP_CLUSTER=your_app_cluster
```

### STEP 2: Install the project
- Clone the repository
- Run `composer install`
- Run `npm install`
- Run `cp .env.example .env`
- Create a local DB and update the `.env` file with the DB credentials
- Run `php artisan migrate --seed` (this will create 2 example users)
- Run `npm run dev`
- Run `php artisan serve`

### STEP 3: Test the app
- Open http://127.0.0.1:8000 in your browser
- Open http://127.0.0.1:8000 in another browser or incognito window
- Sign into the app with different credentials (use the "Fill as User" button to fill the forms)
- Send a message from one browser to the other
- You should see the message appear in the other browser, may take a few seconds.
- Voilà! You have a working example of Laravel with Vue and Pusher
