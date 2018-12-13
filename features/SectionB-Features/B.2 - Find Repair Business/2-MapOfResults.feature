Feature: B.2.2 - Map of results
  
----

In order to easily visualise repair shops near me,

As a public user,

I want to see the results of my search on map.

----


![](../Sketches/public_search.png)


----

Scenario: View results on map
    When a user enters the place name and other other fileds
    And click on search button
    Then the user will see the results on the map with location pointers accordingly.