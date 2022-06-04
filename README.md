# Lumen PHP Framework

##What needs to be done to launch the application
- git clone git@github.com:bloodsiker/test_v_jet.git
- git pull
- composer install
- php artisan migrate
- php artisan db:seed

##Endpoints:
- https://domain.com/api/user/register
  —method POST
  —fields: first_name [string], last_name [string], email [string], password [string], phone [string]

- https://domain.com/api/user/sign-in
  — method POST
  — fields: email [string], password [string]

- https://domain.com/api/user/recover-password
  — method POST/PATCH
  — fields: email [string] // allow to update the password via email token

- https://domain.com/api/user/companies
  — method GET
  — fields: title [string], phone [string], description [string]
  — show the companies, associated with the user (by the relation)

- https://domain.com/api/user/companies
  — method POST
  — fields: title [string], phone [string], description [string]
  — add the companies, associated with the user (by the relation)
