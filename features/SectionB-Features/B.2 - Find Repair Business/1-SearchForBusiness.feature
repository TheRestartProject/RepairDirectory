@mvp
Feature: B.2.1 - Search for repair business
  
----

In order to get my broken device fixed,

As a public user,

I want to be able to search for repair shops that fix my type of device.

----

Members of the public wish to find businesses that they can trust to repair their device.
Most frequently they would like to find a local business, however in some
cases it may be that the best (or only) business is located further afield.

![](../Sketches/public_search.png)

----

Scenario: Search by device, place or postcode, and radius
    When a user enters the place or postcode, selects the device and search radius
    And clicks on search button
    Then the user will see the results according to the search details given.

Scenario: Search by device and radius without place or postcode
    When a user does not enter the place or postcode, and selects the device and search radius
    Then the search button becomes disabled and cannot preform search action, place or postcode filed is mandatory.

Scenario: Ways of search
    When a user enters the mandatory field place and does not select the radius or device
    Then the radius or device fields are set to default values i.e., All of london and Everything repectivley
    And can perform the search action.
