## Laravel Black Hand Tools

This is a Laravel 5.5 Admin Panel for the Imperium 

Black Hand Agent Tracking System

## Usage

Add User > Assign Handler > Allocate Agents to Reporting Group.

## License

MIT

## Notice

I blame Izzy, (Rawr!)

## Functionality

### Management of Active Groups 

1. Management of Alliances/Corporations
2. Details of Alliance/Corporations
3. Home System / Staging Information

### Handlers ###

1. Assign Handlers to a User Account
2. Track Agents/Activity/Relays through each handler.

### Agents ###

1. Add Agents to each Handler
2. Record Agent Details
3. Management of Agent including Checklist/Relay status.
4. Submission of Contact Notes for Agent History.
5. Tag Agents with Spymaster Generated Tags

### Agent Tags

1. Generate Tags for adding to Agents
2. Color Coded
3. Can be hidden

### User Creation ###

1. No Registration Allowed.
2. Accounts created by a Spymaster.

### Roles & Permissions ###

1. Creation & Management of Roles.
2. Permissions & Management of Roles.

### Management of Staff ###

1. Management of Agents
2. Management of Handlers
3. Management of Groups
4. Management of Spymasters

### Tracking ###

1. Tracking of Users & Actions
2. Recording of Sessions / IPs

### Metrics ###

1. Users Accounts including Activity
2. Handlers, Active Agents & Latest Registrations
3. Agents, Active/Inactive & Activity Metrics
4. Groups Active Agents/Relays

### Spymaster Posts ###

1. Submission of Posts to inform all handlers of Black Hand Updates / Reminders

### Contact Notifications ###

1. Notify Handler/Spymaster of certain Agent Contact Notes for Attention

### Requirements ###

PHP >= 7.1.3
OpenSSL PHP Extension
PDO PHP Extension
Mbstring PHP Extension
Tokenizer PHP Extension
Ctype PHP Extension
JSON PHP Extension
XML PHP Extension
GD PHP Extension
Fileinfo PHP Extension
Xdebug Max Nesting Level (>= 500)

### Installation ###

1. git clone > from bitbucket repo.
2. Rename env-example to .env and configure with local enviroment variables.
3. composer install
4. composer update
5. php artisan key:generate
6. php artisan migrate
7. php artisan db:seed
8. storage and subfolders including settings.json require 777.
9. Login with spymaster account. - Username: Spymaster : password: blackhand.
10. Change admin user password.
11. Configure discord webhooks in .env to enable discord notifications.


### Debugging ###

1. To enable debug bar, change .env variables
2. enviroment = local
3. debug = true


### Configured for platform.sh

1. Update .platform.app.yaml as required and deploy.
