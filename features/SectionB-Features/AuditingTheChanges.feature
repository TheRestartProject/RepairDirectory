Feature: 
  As a user
  I should be able to see the changes made to the businesses in the database.

Scenario: Auditing the changes made tobusinesses
    When a user wants to edit or add a new business 
    Then the name of the user, and who last updated details should be logged in the database along with the date.
