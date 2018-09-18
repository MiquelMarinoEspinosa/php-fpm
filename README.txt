- Create file .env with your ip address based on .env.dist
- docker-compose up
- Edit /etc/hosts adding site.org to the localhost entry like this
        127.0.0.1       localhost site.org
- docker exec -i -t miquel.php-fpm composer install
- docker exec -i -t miquel.php-fpm vendor/bin/behat
- Access to the url extract from acceptance test via browser
         Then the user should have been created  # Php\Fpm\Tests\Acceptance\UserInterface\Api\Behat\SiteContext::theUserShouldHaveBeenCreated()
               │ https://site.org/user/60452bfc-963b-4c59-a5a9-11caaa39c1a2