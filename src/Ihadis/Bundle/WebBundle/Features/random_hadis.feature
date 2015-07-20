Feature: আজকের হাদিস
  In order to know new important Hadis
  As a website user
  I need to see a random hadis from a selected set on homepage

  Background:
    Given database in default state
    And I am on "/ui2"

  Scenario: Do not see আজকের হাদিস on homepage
    When There are 0 highlighted hadis in database
    Then I should not see text matching "আজকের হাদিস"
    And the response should contain "No highlighted hadis found!"

  Scenario: See আজকের হাদিস on homepage
    When I mark 1 hadis as highlighted
    And I reload the page
    Then I should see text matching "আজকের হাদিস"
    And I should see 1 "#random-hadis" elements

  Scenario: See random hadis in আজকের হাদিস
    When I mark 3 hadis as highlighted
    Then content under ajker hadis should not be same in 5 reloads