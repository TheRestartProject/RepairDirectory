@mvp
Feature: B.1.3 - Add business to directory

----
  
In order to populate the list of businesses,

As a Directory Admin,

I want to be able to add businesses to the directory.

----

The Directory Admin can add businesses directly.

![](../Sketches/add_business.png)

Fields
------

* Geolocation	
51.5503563, 0.1989772	
Latitude, longitude (used for marker placement in mapping)

* Name	
Hans Electric	
Business name

* Description	
Vacuum cleaner servicing and repairs, family-run business since 1966	
Business description

* Address	
22 The Broadway, RM12 4RW	
Single-line address, including postcode (can also be used for mapping)

* Landline	
01708 446060	
Phone number

* Mobile		
Phone number

* Website	
http://www.hanselectric.co.uk/	
Website

* Email	
mail@hanselectric.co.uk	
Email

* Borough	
Havering	
Selected from drop-down list

* Category	
Kitchen and household	
Selected from drop-down list, main category only.  
Categories derived from Fixometer (Kitchen & Household includes White Goods, Electronic Gadget includes Consoles)
**TODO**: "Where businesses repair items in more than one category then the MAIN category they offer is chosen." This feels wrong to me.  Shouldn't we list primary category and then secondary?

* Products repaired	
Vacuum cleaner	
Comma-separated list of products (can be searched in map)
**TODO** this is currently freetext?

* Authorised repairer	
No	
List of brands the business is an authorised repairer for (only checked for Apple, Sony, Samsung)

* Qualifications		
Staff qualifications as stated on website

* Independent review link	
https://www.facebook.com/HansElectric/reviews/	
Weblink to main review source for this business

* Other review link	
https://www.google.co.uk/maps/place/Hans+Electric+Ltd/@51.5503563,0.1989772,15z/data=!4m7!3m6!1s0x0:0x6325ee7eacc538a1!8m2!3d51.5503563!4d0.1989772!9m1!1b1	
Weblink to secondary review source or testimonials for this business

* Positive review %	
80%	
Percentage of reviews which are 3,4 or 5 star
TODO: needs to be updated regularly or made dynamic calculation

* Warranty offered	
"6 months warranty on all parts and labour" by phone	
Text describing warranty offer and source (eg by phone or from website)

* Pricing information	
£5 deposit, agreed price limit	
Text describing pricing info and source (eg by phone or from website)

* Categories	
Kitchen & Household	
List of categories

* Review source	
Facebook reviews	
Name of review source

* No of reviews	
6	
No of reviews (may include 2 sources)

* Avg score (out of 5)	
4.80	
Most sites score from 1-5.  Trustpilot scores from 1-10 are divided by two.

* Restart community endorsments		
Text indicating endorsement

* Notes		
Notes requiring action

* Include?	
Yes	
Yes, Maybe, No with notes - summary of the 3 criteria C1-C3

* C1 Address?	
Yes	
Yes (has an address in the area, No (address outside area or no address) used as a criteria

* C2 Reviews?	
Yes, (Google 2 & Facebook 4)	
Yes, Maybe, No with notes

* C3 Warranty?	
Yes, by phone	Yes, Maybe, No with notes and source

Website?	
Yes	
Yes or No or No data (could be used as a criteria)

* Clear about parts used?	
No data	
Yes or No or No data (could be used as a criteria)

* Clear which products repaired?	
Yes	
Yes or No or No data (could be used as a criteria)

* Issue receipts?	
No data	
Yes or No or No data (could be used as a criteria)
		
* Public?
If, for whatever reason, we want to override all other criteria
and hide this business.
