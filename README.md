# Keyring
###User credentials storage application created with Laravel 4.2

**What is Keyring?**

Keyring is a host / username / password storage application where users can securely store and edit their online account credentials and access them from any web browser.

**Why would I/we use it?**

So that you have a convenient, central and reasonably secure way to store and access your account data from any device, as opposed to it being scattered across multiple devices or stored (insecurely) on, say, a spreadsheet or text document.

**How is it secured?**

Your Keyring account is password protected twice - once to log in and then again using your own 'Master Key', which you use to lock or unlock the account data.  By using high complexity hashing algorithms, your account data can only be decrypted by you or someone who knows both your Keyring passwords.

**What's a good way to deploy it?**

Keyring would be an excellent workgroup solution when installed on a secure (https) web server behind a firewall, with optionally a connection to the web via a Virtual Private Network.

**How to get it running?**

* Copy this repo's files into a new folder on your web host 
* Install Laravel 4.2 with composer (bash_shell:$ composer update)
* Create a (MySQL recommended) database and user for the application
* Edit the database config file (app/config/database.php) to match the above
* Edit the application config file (app/config/app.php) and set your web host's url
* Edit the mail config file (app/config/mail.php) to point to your preferred mail service  
* Run the database migration and seed files (bash_shell:$ php artisan migrate && php artisan db:seed)
* Enable your web server to serve the application (usually involves creating and enabling a new vhost) 
* Reload your web server's config e.g. Apache (bash_shell:$ sudo service apache2 reload)
* Log in to the application as 'foo@bar.org / passwd01' and use the Master Key 'master01'
* If all looks ok, go ahead and create your own user accounts

**Licence / guarantee etc**

This is FREE software which you can use and abuse as you see fit and comes with no guarantee whatsoever ;)
