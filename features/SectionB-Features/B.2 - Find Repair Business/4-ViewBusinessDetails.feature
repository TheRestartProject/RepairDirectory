@mvp
Feature: B.2.4 - View business details
  
---

In order to contact the repair business,

As a public user,

I want to be able to view further business details.

----
  
Details to view
---------------

* Name
* Website
* Phone Number
* Address
* Reviews and ratings

![](../Sketches/public_search.png)

----

Scenario: To view and contact the repair business
    When a user either clicks on the location pointer on the map or on the list of repair business
    Then a pop up screen appears with the name, ratings, website, phone number, and address of the repair business
    And the website, contact number are clickable, directly take to their website or open contact screen respectively.
