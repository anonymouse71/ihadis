Feature: Site Status

  Scenario: Site loading with OK status
    Given I am on "/_status"
    Then the response should contain "SUCCESS"