Feature: Top Navbar booklist menu
  In order to browse hadis books from any page
  As a website user
  I need to see list of available hadis books on navbar

  Scenario: List all published books
    Given database is empty
    And the following Hadis books are in database
      | title         | collector     | numberOfHadis | slug | published |
      | সহিহ বুখারি   | ইমাম বুখারি   | 7450          | bukhari | 1         |
      | সহিহ মুসলিম   | ইমাম মুসলিম   | 5430          | muslim  | 0         |
      | সহিহ আবু দাউদ | ইমাম আবু দাউদ | 17450         | abu-daud | 1         |
    When I go to "/ui2"
    Then I should see 2 "#nav-booklist li" elements
    And I should see "সহিহ বুখারি" in the "#nav-booklist li:first-child" element
    #And I should see "সহিহ মুসলিম" in the "#nav-booklist li:nth-child(2)" element
    And I should see "সহিহ আবু দাউদ" in the "#nav-booklist li:last-child" element
    When I follow "সহিহ আবু দাউদ"
    Then I should be on "/ui2/book/abu-daud"



