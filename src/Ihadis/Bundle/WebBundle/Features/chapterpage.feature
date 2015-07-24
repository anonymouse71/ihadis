Feature: Chapter page - Basic information
  In order to browse hadis of chapter
  As a website user
  I want to see sections and hadths of a chapter

  Background:
    Given database in default state
    And I am on "/ui2/book/bukhari"

  Scenario Outline: Browse chapters
    When I follow "<title>"
    Then I should be on "<url>"
    And I should see "<title>" in the "h2" element
    And I should see <sections> ".section" elements
    And I should see <hadiths> ".hadith" elements

    Examples:
      | title              | url                 | sections | hadiths |
      | ওহীর সূচনা অধ্যায় | /ui2/book/bukhari/1 | 6        | 6       |
      | ঈমান               | /ui2/book/bukhari/2 | 2        | 1       |

