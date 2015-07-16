Feature: Site Status

  Scenario: Site loading with OK status
    Given I am on "_/status"
    Then I should see text matching "OK"