Feature: Book page chapters list
  In order to browse chapters of a book
  As a website user
  I need to see links to chapters

  Background:
    Given database is empty
    And the following Hadis books are in database
      | title | description      | collector   | numberOfHadis | slug    | published |
      | সহিহ বুখারি | সহিহ বুখারি সম্পর্কে| ইমাম বুখারি (রহঃ)| 7563          | bukhari | 1         |
      | সহিহ মুসলিম | সহিহ মুসলিম সম্পর্কে| ইমাম মুসলিম (রহঃ)| 5460          | muslim | 1         |
    And the following Chapters are in database
      | book_id | title              | number | range     |
      | 1       | ওহীর সূচনা অধ্যায় | 1      | 1 - 7     |
      | 1       | ঈমান               | 2      | 8 - 58    |
      | 1       | ইল্‌ম              | 3      | 59 - 134  |
      | 2       | ওজু                | 1      | 135 - 247 |
      | 2       | বৃষ্টির জন্য দোয়া | 2      | 248 - 303 |

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



