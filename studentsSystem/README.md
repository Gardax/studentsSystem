<h1>Setup:</h1>


<h3>Install php</h3>

```
sudo apt-get install php5-cli

```
<h3>Install curl</h3>
```
sudo apt-get install curl
sudo apt-get install php5-curl

```
<h3>Install Composer</h3>
To install Composer on Linux or Mac OS X, execute the following two commands:
```
$ curl -sS https://getcomposer.org/installer | php
$ sudo mv composer.phar /usr/local/bin/composer

```

<h3>Install symfony</h3>
```
sudo curl -LsS https://symfony.com/installer -o /usr/local/bin/symfony
sudo chmod a+x /usr/local/bin/symfony
```

<h3>Clone the repository</h3>
```
git clone <url-to-the-repo>
```

<h3>Install webkittopdf</h3>
```
sudo aptitude install openssl build-essential xorg libssl-dev

wget http://wkhtmltopdf.googlecode.com/files/wkhtmltopdf-0.9.9-static-amd64.tar.bz2
tar xvjf wkhtmltopdf-0.9.9-static-amd64.tar.bz2
sudo mv wkhtmltopdf-amd64 /usr/local/bin/wkhtmltopdf
sudo chmod +x /usr/local/bin/wkhtmltopdf
```

<h3>Install depending packages</h3>
```
composer update
```

<h3>Create database</h3>
```
$ php bin/console doctrine:database:create
```

<h3>Update database schema</h3>
```
$ php bin/console doctrine:schema:update --force
```

<h3>Load fixtures</h3>
```
$ php bin/console doctrine:fixtures:load
```

<h1>Running the Symfony Application</h1>

Then, open your browser and access the http://localhost:8000 URL to see the Welcome page of Symfony
```
$ cd my_project_name/
$ php bin/console server:run <optional IP>
```

