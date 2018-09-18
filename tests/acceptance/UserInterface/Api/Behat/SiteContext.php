<?php

namespace Php\Fpm\Tests\Acceptance\UserInterface\Api\Behat;

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;

class SiteContext implements Context
{
    /** @var string */
    private $name;
    /** @var string */
    private $id;

    /**
     * @Given /^a user name "([^"]*)"$/
     */
    public function aUserName($name)
    {
        $this->name = $name;
    }

    /**
     * @When /^make the request to create an user$/
     */
    public function makeTheRequestToCreateAnUser()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://site.org/user");
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt(
            $ch,
            CURLOPT_POSTFIELDS,
            [
                'name' => $this->name
            ]
        );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        $user = json_decode($response, true);
        $this->id = $user['user']['id'];
        curl_close($ch);
    }

    /**
     * @Then /^the user should have been created$/
     */
    public function theUserShouldHaveBeenCreated()
    {
        $ch = curl_init();
        $url = 'https://site.org/user/' . $this->id;
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false
        ]);
        echo $url;
        $response = curl_exec($ch);
        $user = json_decode($response, true);
        if ($this->name !== $user['user']['name']) {
            throw new \Exception(
                'The user does not match. Expected: '
                . $this->name . ', Actual: ' . $user['user']['name']
            );
        }
    }
}