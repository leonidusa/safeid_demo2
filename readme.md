## SAFE BUTTON coupons demo SDK

This demo is built with Laravel. Utilizing Socialite, implements Google Aouth2 signin/signup driver, as well as SAFE SDK.

## Usage

Clone the repo. 


```
git clone https://github.com/leonidusa/safeid_demo2.git
```

Run the install: 
```
composer install
```

### Create MYSQL database, db_user and db_user_password.

Copy/rename '.env.example' to '.env' and configure database connection and other settings

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=YOUR_DB_NAME
DB_USERNAME=YOUR_DB_USER
DB_PASSWORD=YOUR_DB_USER_PASSWORD
```

Download SAFE BUTTON application and register.

Visit https://developers.thesafebutton.com/ and create developers account.

Once your developers' account has been established for your SAFE_ID, sign in to developers console and create your first app.

Fill required fields and note the app settings. Add your app credentials to .env

```
SAFE_API=https://api.thesafebutton.com/v2/
SAFE_OAUTH=https://oauth.thesafebutton.com/
SAFE_CLIENT_ID=your_app_name
SAFE_CLIENT_SECRET=your_app_secret
SAFE_CLIENT_SAFE_ID=app_owner_safeid
```


### Run the migrations and seed the database
This will create 2 demo users.

Demo Admin
+ 'email': 'admin@test.com'
+ 'password': testing!

Demo User
+ 'email': 'user@test.com'
+ 'password': testing!

```
php artisan migrate:fresh --seed
```

#### Note
You may login as a user or admin via the credentials given above, alternatively login via special routes:
+ /login-user
+ /login-admin

First route will sign you in as a user, second will get you to admin dashboard. 
Make sure to run migrations and seeders first.

#### Socialite OAuth
If you plan on utilizing authentication via Google, create your app in Google and configure .env and routes
```
GOOGLE_CLIENT_ID=your_client_id
GOOGLE_CLIENT_SECRET=your_client_secret
GOOGLE_REDIRECT=https://yoursitehere.com/g-login/callback
```

### Nginx / Apache
Set web root to /public folder.

### Endponits settings

Navigate to SAFE API settings (/admin/settings/safe)
Fill and save your app credentials:
+ client_id (your app client id)
+ client_secret (your app secret)
+ client_safe_id (your own safe id)

Fill API endpoints:
+ oauth2
+ signin
+ prompt
+ checkclientaid
+ transaction
+ consumer
+ application

For demostration purposes, above will be seeded for you.

API should be ready to go now.

### Optional Frontend

Demo runs on UIKIT modern framework https://getuikit.com/
CSS and JS compiled with webpack.
All resources are compiled for you.
If you need to make any changes, navigate to /resources/_dev
Install npm:
```
npm install -dev
```

Edit /resources/_dev/js and /resources/_dev/scss as needed
Build new assets:

```
npm run watch
```

Webpack will replace current files under /public/assets