Feature: Site Acceptance Test

  Scenario: Create User
    Given a user name "miquel"
    When make the request to create an user
    Then the user should have been created
