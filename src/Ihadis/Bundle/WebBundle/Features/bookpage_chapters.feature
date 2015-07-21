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
      | সহিহ আবু দাউদ | ইমাম আবু দাউদ | ইমাম আবু দাউদ (রহঃ) |17450         | abu-daud | 1         |
    And the following Chapters are in database
      | book_id | title              | number | range     |
      | 1       | ওহীর সূচনা অধ্যায় | 1      | 1 - 7     |
      | 1       | ঈমান               | 2      | 8 - 58    |
      | 1       | ইল্‌ম              | 3      | 59 - 134  |
      | 2       | ওজু                | 1      | 135 - 247 |
      | 2       | বৃষ্টির জন্য দোয়া | 2      | 248 - 303 |

  Scenario Outline: Book has chapters
    When I go to "/ui2/book/<slug>"
    Then I should see <chapters> "#chapter-list tbody tr" elements
    And I should see "<chapter_name>" in the "#chapter-list tbody tr:first-child" element
    And I should see "<range>" in the "#chapter-list tbody tr:first-child" element

  Examples:
    | slug    | chapters | chapter_name  | range |
    | bukhari | 3        | ওহীর সূচনা অধ্যায় | ১ - ৭ |
    | muslim  | 2        | ওজু            | ১৩৫ - ২৪৭ |


  Scenario: Book has no chapters
    When I go to "/ui2/book/abu-daud"
    Then I should see 0 "#chapter-list tbody tr" elements

  @javascript
  Scenario Outline: Chapter list filtering
    Given I am on "/ui2/book/bukhari"
    And I click on "#filter-toggle" element
    When I fill in "chapter-list-filter" with "<keyword>"
    Then I should see <results> number of visible rows in "#chapter-list"

    Examples:
    | keyword | results |
    | ম       | 2 |
    | ওহীর    | 1 |
    | ক       | 0 |