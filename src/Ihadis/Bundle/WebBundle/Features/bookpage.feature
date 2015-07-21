Feature: Book page - Basic information
  In order to get overview of a Hadis book
  As a website user
  I want to see basic information about a book

  Background:
    Given database is empty
    And the following Hadis books are in database
      | title | description      | collector   | numberOfHadis | slug    | published |
      | সহিহ বুখারি | সহিহ বুখারি সম্পর্কে| ইমাম বুখারি (রহঃ)| 7563          | bukhari | 1         |
      | সহিহ মুসলিম | সহিহ মুসলিম সম্পর্কে| ইমাম মুসলিম (রহঃ)| 5460          | muslim | 1         |

  Scenario Outline: The book is available
    When I go to "/ui2/book/<slug>"
    Then I should see "<title>" in the "h2" element
    And I should see "<description>"
    And I should see "<collector>"

  Examples:
    | slug |  title | description | collector |
    | bukhari | সহিহ বুখারি | সহিহ বুখারি সম্পর্কে| ইমাম বুখারি (রহঃ) |
    | muslim | সহিহ মুসলিম | সহিহ মুসলিম সম্পর্কে| ইমাম মুসলিম (রহঃ) |


  Scenario: Book has downloadable pdf links
    Given book id 1 has the following content as links:
      """
      Part 1 | http://the-book-link.com/part-1.pdf
      Part 2 | http://the-book-link.com/part-2.pdf
      Part 3 | http://the-book-link.com/part-3.pdf
      """
    When I go to "/ui2/book/bukhari"
    Then I should see "PDF ডাউনলোড"
    And I should see 3 "#downloads table tr" elements
    And I should see "Part 1" in the "#downloads tr:first-child th" element

  Scenario: Book has no pdf links
    When I go to "/ui2/book/bukhari"
    Then I should not see "PDF ডাউনলোড"



