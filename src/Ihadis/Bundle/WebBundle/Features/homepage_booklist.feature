Feature: Homepage booklist
  In order to browse hadis by books
  As a website user
  I need to see list of available hadis books

  Background:
    Given I am on "/ui2"

  Scenario: See list of books
    Given the following Hadis books are in database
      | title         | collector     | numberOfHadis | slug | published |
      | সহিহ বুখারি   | ইমাম বুখারি   | 7450          | bukhari | 1         |
      | সহিহ মুসলিম   | ইমাম মুসলিম   | 5430          | muslim  | 1         |
      | সহিহ আবু দাউদ | ইমাম আবু দাউদ | 17450         | abu-daud | 1         |
    When I reload the page
    Then I should see 3 ".book" elements
    And I should see "সহিহ বুখারি" in the "#booklist > div:first-child h3" element
    And I should see "সহিহ মুসলিম" in the "#booklist > div:nth-child(2) h3" element
    And I should see "সহিহ আবু দাউদ" in the "#booklist > div:last-child h3" element



  Scenario: Do not show unpublished books
    Given the following Hadis books are in database
      | title         | collector     | numberOfHadis | slug | published |
      | সহিহ বুখারি   | ইমাম বুখারি   | 7450          | bukhari | 0         |
      | সহিহ মুসলিম   | ইমাম মুসলিম   | 5430          | muslim  | 1         |
      | সহিহ আবু দাউদ | ইমাম আবু দাউদ | 17450         | abu-daud | 1         |
    When I reload the page
    Then I should see 2 ".book" elements
    And I should not see "সহিহ বুখারি" in the ".book h3" element

