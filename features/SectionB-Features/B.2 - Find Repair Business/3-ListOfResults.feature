Feature: B.2.3 - List of Results

----

In order to easily read the results of my repair shop search,

As a public user,

I want to see a list of my search lists, ordered by proximity.

----

OK to order by proximity, as long as we are saying every included shop
is trusted.

![](../Sketches/public_search.png)

----

Scenario: View the list of results
    When a user enters all the fields according to his requirements and clicks on search button
    Then the user will see the list of results i.e., list of business ordered by proximity on the page.
    