jsonPWrapper ({
  "Features": [
    {
      "RelativeFolder": "SectionA-Overview\\1-Vision.feature",
      "Feature": {
        "Name": "A.1 - Vision",
        "Description": "To collaboratively create a trusted, easy-to-use directory of local repair businesses and\r\nindependent repairers, to provide a means for members of the public to easily gain\r\naccess to a repairer for a broken device, and to help revive and grow a network\r\nof repair shops.\r\n\r\n![](../Sketches/public_search.png)\r\n\r\nWe want to encourage people to fix their devices rather than throw them away and\r\nbuy something new. Most of the carbon footprint of a device is in manufacture.\r\nBy repairing devices, we displace manufacture and the associated environmental\r\nissues. Our community Restart Parties fill a gap in this area, but it is only\r\nthe start. We aim to stimulate demand for a wider repair economy. A huge part of\r\nthis can come from commercial repair. We want to scale up waste prevention and\r\nresource efficiency through the rebirth of a vibrant commercial repair sector.\r\n\r\nCommunity repair and commercial repair\r\n--------------------------------------\r\n\r\nAt our repair events, DIY repair is not always possible, due to the need for a\r\nspare part, or time constraints. In these situations it's important to provide\r\npeople with further options for repair. We can encourage participants to try to\r\nfix the device themselves, or to come to another Restart Party, but this is not\r\nalways viable. Our Restarters often get asked for locations for commercial repair, \r\nwhich in many cases can be the most time-efficient option.  We would like to be able\r\nto easily refer these participants on to a trusted repair business.\r\n\r\nRepair by SMEs\r\n--------------\r\n\r\nLocal/independent repair, vs repair by big stores, is positive as it fosters\r\ncommunity, and an experience - you can see the work being done on-site\r\nsometimes, you can chat with the repairer as to what the issue was. \r\n\r\nThe art of local repair is struggling in many areas (e.g. televisions) and\r\ndoing OK in others (e.g. phone and tablet repairs.) By pointing the public\r\nto local repairers we hope to encourage growth in this area. \r\n\r\nHow to do this?\r\n---------------\r\n\r\nIn order to stimulate commercial repair, we need to empower the public to know\r\nwhere to take their device. Not just finding a shop, but knowing whether to\r\ntrust it. Visitors to Restart events have said that they didn't trust the advice\r\nthey received from a commercial repair shop, and didn't understand the pricing.\r\nThese are barriers to repair. Quality criteria such as whether a business\r\nprovides a warranty are needed. Through research we have identified key criteria\r\nthat allows us to filter out businesses that do not meet a standard that will engender\r\npublic trust. \r\n\r\nThe repair directory is beneficial to individual citizens, to repair businesses,\r\nand to society as a whole.\r\n\r\nCurrent Status\r\n--------------\r\n\r\nThrough the hard work of one researcher we have already created a pilot proof of\r\nconcept directory for the 4 London boroughs of Redbridge, Barking and Dagenham,\r\nHavering and Newham. We now wish to turn this into a co-created directory,\r\nengaging our Restart volunteers in the listing of repair shops, and reducing the\r\nworkload involved in reviewing quality criteria for the businesses.  We hope to\r\nmake use of commons-based peer production in the generation of the repair directory,\r\nwith the Ushahidi platform being one possible implementation route for this.",
        "FeatureElements": [],
        "Result": {
          "WasExecuted": false,
          "WasSuccessful": false
        },
        "Tags": []
      },
      "Result": {
        "WasExecuted": false,
        "WasSuccessful": false
      }
    },
    {
      "RelativeFolder": "SectionA-Overview\\2-Goals.feature",
      "Feature": {
        "Name": "A.2 - Goals",
        "Description": "----\r\n\r\n*This section lists high-level statements that focus on the value and\r\nopportunities provided by the directory. They describe specifically what we're\r\ntrying to do, and describes why we want to do this and outlines the \r\nbenefits we're trying to achieve by doing so.*\r\n\r\n----\r\n\r\n**Increase number of devices fixed in the world**\r\n\r\nBy offering more options for repair, we aim to increase the number of devices fixed,\r\nwith all the environmental and social benefits that come this.\r\n\r\n**Increase footfall to commercial repairers, to help regrow repair economy**\r\n\r\nBy increasing footfall to commercial repairers, we make repair a viable option for\r\nmembers of the public.\r\n\r\n**Foster relationship with commercial repairers**\r\n\r\nBy encouraging commercial repair, we foster a relationship with commercial repairers,\r\nand can then pursue the collection of open repair data.\r\n\r\n**Spread the workload of directory management through co-creation and automation**\r\n\r\nBy opening up the system to co-creation from our Restart volunteers, we make the \r\ndirectory management more sustainable.\r\n\r\n**Provide opportunities for increased engagement of Restart Project volunteers**\r\n\r\n**Increase satisifaction of participants at Restart Parties**",
        "FeatureElements": [],
        "Result": {
          "WasExecuted": false,
          "WasSuccessful": false
        },
        "Tags": []
      },
      "Result": {
        "WasExecuted": false,
        "WasSuccessful": false
      }
    },
    {
      "RelativeFolder": "SectionA-Overview\\3-Capabilities.feature",
      "Feature": {
        "Name": "A.3 - Capabilities",
        "Description": "*This section lists the capabilities of the software. (A capability is the\r\nability of the application to help stakeholders realize one of the business\r\ngoals.)*\r\n  \r\nDirectory Management\r\n--------------------\r\n\r\nManagement of the businesses that are included in the repair shop directory.\r\n\r\nCRUD interface for Directory Admins to add, edit and delete. To spread\r\ncollection throughout the community, Restarters are able to submit repair shop\r\nrecommendations.\r\n\r\n* Admin Add Business\r\n* Admin Edit Business\r\n* Admin Delete Business\r\n* Restarters submit repair shop data\r\n* Admins verify submitted repair shops\r\n* Reviews/ratings can be automatically pulled in by calls to review APIs\r\n* Trusted business filter\r\n\r\n----\r\n\r\nFind Repair Business\r\n--------------------\r\n\r\nSimple search for public users that shows shop results on a map and in a list.\r\nShops that are included in the results are determined by fixed, predetermined\r\nquality criteria. Public user can click on a result to see further information\r\nabout the business.  Only the repair shops that pass the quality criteria are\r\ndisplayed in results.\r\n\r\n* Search for businesses\r\n\r\n  Search by product type and postcode radius.  Postcode radius is optional, as in some cases\r\n  a repair business may not be in the locality.\r\n\r\n* View map of results\r\n* View list of results\r\n* View business details\r\n\r\n**Future**: \r\n\r\n* Ability for the public user to change the quality criteria?\r\n\r\n----\r\n\r\nAccess/Integration\r\n------------------\r\n\r\n* Public search is available as standalone site.\r\n* Admins/Restarters log in via back-end integrated into community.therestartproject.org to input data.\r\n\r\n**Future**:\r\n\r\n* The ability for 3rd parties to embed their own version of the search. For example, councils.\r\n\r\n----\r\n\r\nResponsive\r\n----------\r\n\r\n* Good mobile/tablet user experience for public search.\r\n\r\n**Future**:\r\n\r\n* Directory Management viewable on mobile.",
        "FeatureElements": [],
        "Result": {
          "WasExecuted": false,
          "WasSuccessful": false
        },
        "Tags": []
      },
      "Result": {
        "WasExecuted": false,
        "WasSuccessful": false
      }
    },
    {
      "RelativeFolder": "SectionA-Overview\\4-Glossary.feature",
      "Feature": {
        "Name": "A.4 - Glossary",
        "Description": "**Public User**: \r\nA member of the public who wants to fix a broken device in their possession.\r\n\r\n**Participant**: \r\nA member of the public who attends a Restart Party to get their device fixed.\r\n\r\n**Restart Fixer**:\r\nA volunteer of the Restart Project that fixes devices at Restart Parties.\r\n\r\n**Restart Host**:\r\nA volunteer of the Restart Project that organises and hosts Restart Parties.\r\n\r\n**Restart Supporter**:\r\nPeople who care about the cause of the Restart Project, but may not have the skills\r\nto be a Restarter or Restart Host, or may not live in an area where they can attend\r\nRestart Parties.\r\n\r\n**Restarter**:\r\nAnyone who is a Restart Fixer, a Restart Host, or a Restart Supporter.\r\n\r\n**Restart Party**:\r\nCommunity repair events organised by the Restart Project.\r\n\r\n**Restart Project**:\r\nThe Restart Project is a people-powered platform for change, helping demand emerge for more sustainable, better electronics.\r\n\r\n**Directory Admin**:\r\nA person who has access to the administration of the directory.\r\n\r\n**Repair Business**:\r\nA business that fixes devices commercially.  Ideally the business is local\r\nto the member of the public, but in some cases for particular devices there are \r\nonly a few specialists in the country.\r\n\r\n**Local Authority**:\r\nLocal authorities support local businesses, and wish to reduce the amount of devices\r\nsent to landfill in their authority.\r\n\r\n**Quality criteria**:\r\nA set of criteria to determine the trustworthiness of a business.",
        "FeatureElements": [],
        "Result": {
          "WasExecuted": false,
          "WasSuccessful": false
        },
        "Tags": []
      },
      "Result": {
        "WasExecuted": false,
        "WasSuccessful": false
      }
    },
    {
      "RelativeFolder": "SectionB-Features\\B.1 - Directory Management\\1-LogInToDirectory.feature",
      "Feature": {
        "Name": "B.1.1 - Log in to directory & permissions",
        "Description": "----\r\n\r\nIn order to control who can amend the business directory,\r\n\r\nAs the Restart Project,\r\n\r\nWe want to restrict directory management access to permitted users only.\r\n\r\n----\r\n\r\nDirectory Admins can manage the directory of businesses.\r\nRestarters can submit businesses to the directory.\r\n\r\nBoth of these actions need to be behind an authorised login,\r\nand the user has to have the required permissions in order\r\nto perform each of the actions.",
        "FeatureElements": [],
        "Result": {
          "WasExecuted": false,
          "WasSuccessful": false
        },
        "Tags": [
          "@mvp"
        ]
      },
      "Result": {
        "WasExecuted": false,
        "WasSuccessful": false
      }
    },
    {
      "RelativeFolder": "SectionB-Features\\B.1 - Directory Management\\2-ListOfBusinesses.feature",
      "Feature": {
        "Name": "B.1.2 - List of businesses",
        "Description": "----\r\n\r\nIn order to easily manage the businesses in the directory,\r\n\r\nAs a Directory Admin,\r\n\r\nI want to be able to navigate and search the list of businesses.\r\n\r\n----\r\n\r\n![](../Sketches/directory_list.png)",
        "FeatureElements": [],
        "Result": {
          "WasExecuted": false,
          "WasSuccessful": false
        },
        "Tags": [
          "@mvp"
        ]
      },
      "Result": {
        "WasExecuted": false,
        "WasSuccessful": false
      }
    },
    {
      "RelativeFolder": "SectionB-Features\\B.1 - Directory Management\\3-AddBusinessToDirectory.feature",
      "Feature": {
        "Name": "B.1.3 - Add business to directory",
        "Description": "----\r\n  \r\nIn order to populate the list of businesses,\r\n\r\nAs a Directory Admin,\r\n\r\nI want to be able to add businesses to the directory.\r\n\r\n----\r\n\r\nThe Directory Admin can add businesses directly.\r\n\r\n![](../Sketches/add_business.png)\r\n\r\nFields\r\n------\r\n\r\n* Geolocation\t\r\n51.5503563, 0.1989772\t\r\nLatitude, longitude (used for marker placement in mapping)\r\n\r\n* Name\t\r\nHans Electric\t\r\nBusiness name\r\n\r\n* Description\t\r\nVacuum cleaner servicing and repairs, family-run business since 1966\t\r\nBusiness description\r\n\r\n* Address\t\r\n22 The Broadway, RM12 4RW\t\r\nSingle-line address, including postcode (can also be used for mapping)\r\n\r\n* Landline\t\r\n01708 446060\t\r\nPhone number\r\n\r\n* Mobile\t\t\r\nPhone number\r\n\r\n* Website\t\r\nhttp://www.hanselectric.co.uk/\t\r\nWebsite\r\n\r\n* Email\t\r\nmail@hanselectric.co.uk\t\r\nEmail\r\n\r\n* Borough\t\r\nHavering\t\r\nSelected from drop-down list\r\n\r\n* Category\t\r\nKitchen and household\t\r\nSelected from drop-down list, main category only.  \r\nCategories derived from Fixometer (Kitchen & Household includes White Goods, Electronic Gadget includes Consoles)\r\n**TODO**: \"Where businesses repair items in more than one category then the MAIN category they offer is chosen.\" This feels wrong to me.  Shouldn't we list primary category and then secondary?\r\n\r\n* Products repaired\t\r\nVacuum cleaner\t\r\nComma-separated list of products (can be searched in map)\r\n**TODO** this is currently freetext?\r\n\r\n* Authorised repairer\t\r\nNo\t\r\nList of brands the business is an authorised repairer for (only checked for Apple, Sony, Samsung)\r\n\r\n* Qualifications\t\t\r\nStaff qualifications as stated on website\r\n\r\n* Independent review link\t\r\nhttps://www.facebook.com/HansElectric/reviews/\t\r\nWeblink to main review source for this business\r\n\r\n* Other review link\t\r\nhttps://www.google.co.uk/maps/place/Hans+Electric+Ltd/@51.5503563,0.1989772,15z/data=!4m7!3m6!1s0x0:0x6325ee7eacc538a1!8m2!3d51.5503563!4d0.1989772!9m1!1b1\t\r\nWeblink to secondary review source or testimonials for this business\r\n\r\n* Positive review %\t\r\n80%\t\r\nPercentage of reviews which are 3,4 or 5 star\r\nTODO: needs to be updated regularly or made dynamic calculation\r\n\r\n* Warranty offered\t\r\n\"6 months warranty on all parts and labour\" by phone\t\r\nText describing warranty offer and source (eg by phone or from website)\r\n\r\n* Pricing information\t\r\n£5 deposit, agreed price limit\t\r\nText describing pricing info and source (eg by phone or from website)\r\n\r\n* Categories\t\r\nKitchen & Household\t\r\nList of categories\r\n\r\n* Review source\t\r\nFacebook reviews\t\r\nName of review source\r\n\r\n* No of reviews\t\r\n6\t\r\nNo of reviews (may include 2 sources)\r\n\r\n* Avg score (out of 5)\t\r\n4.80\t\r\nMost sites score from 1-5.  Trustpilot scores from 1-10 are divided by two.\r\n\r\n* Restart community endorsments\t\t\r\nText indicating endorsement\r\n\r\n* Notes\t\t\r\nNotes requiring action\r\n\r\n* Include?\t\r\nYes\t\r\nYes, Maybe, No with notes - summary of the 3 criteria C1-C3\r\n\r\n* C1 Address?\t\r\nYes\t\r\nYes (has an address in the area, No (address outside area or no address) used as a criteria\r\n\r\n* C2 Reviews?\t\r\nYes, (Google 2 & Facebook 4)\t\r\nYes, Maybe, No with notes\r\n\r\n* C3 Warranty?\t\r\nYes, by phone\tYes, Maybe, No with notes and source\r\n\r\nWebsite?\t\r\nYes\t\r\nYes or No or No data (could be used as a criteria)\r\n\r\n* Clear about parts used?\t\r\nNo data\t\r\nYes or No or No data (could be used as a criteria)\r\n\r\n* Clear which products repaired?\t\r\nYes\t\r\nYes or No or No data (could be used as a criteria)\r\n\r\n* Issue receipts?\t\r\nNo data\t\r\nYes or No or No data (could be used as a criteria)\r\n\t\t\r\n* Public?\r\nIf, for whatever reason, we want to override all other criteria\r\nand hide this business.",
        "FeatureElements": [],
        "Result": {
          "WasExecuted": false,
          "WasSuccessful": false
        },
        "Tags": [
          "@mvp"
        ]
      },
      "Result": {
        "WasExecuted": false,
        "WasSuccessful": false
      }
    },
    {
      "RelativeFolder": "SectionB-Features\\B.1 - Directory Management\\4-EditBusiness.feature",
      "Feature": {
        "Name": "B.1.4 - Edit business",
        "Description": "----\r\n\r\nIn order to keep the list of businesses current,\r\n\r\nAs a Directory Admin,\r\n\r\nI want to be able to edit businesses in the directory.\r\n\r\n----\r\n\r\nWe need to keep the directory up to date, and will periodically\r\nneed to amend the details of the businesses.",
        "FeatureElements": [],
        "Result": {
          "WasExecuted": false,
          "WasSuccessful": false
        },
        "Tags": [
          "@mvp"
        ]
      },
      "Result": {
        "WasExecuted": false,
        "WasSuccessful": false
      }
    },
    {
      "RelativeFolder": "SectionB-Features\\B.1 - Directory Management\\5-DeleteBusiness.feature",
      "Feature": {
        "Name": "B.1.5 - Delete business",
        "Description": "----\r\n\r\nIn order to keep the directory up to date,\r\n\r\nAs a Directory Admin,\r\n\r\nI want to be able to delete businesses from the directory.\r\n\r\n----",
        "FeatureElements": [],
        "Result": {
          "WasExecuted": false,
          "WasSuccessful": false
        },
        "Tags": [
          "@mvp"
        ]
      },
      "Result": {
        "WasExecuted": false,
        "WasSuccessful": false
      }
    },
    {
      "RelativeFolder": "SectionB-Features\\B.1 - Directory Management\\6-RestarterSubmitBusiness.feature",
      "Feature": {
        "Name": "B.1.6 - Restarter submit business",
        "Description": "----\r\n\r\nIn order to foster community engagement,\r\n\r\nAs the Restart Project,\r\n\r\nWe want Restarters to be able to submit businesses to the directory.\r\n\r\n----",
        "FeatureElements": [],
        "Result": {
          "WasExecuted": false,
          "WasSuccessful": false
        },
        "Tags": []
      },
      "Result": {
        "WasExecuted": false,
        "WasSuccessful": false
      }
    },
    {
      "RelativeFolder": "SectionB-Features\\B.1 - Directory Management\\7-AdminApproveBusiness.feature",
      "Feature": {
        "Name": "B.1.7  - Directory Admin approve business",
        "Description": "----\r\n\r\nIn order to ensure the publicly listed businesses are legitimate,\r\n\r\nAs a Directory Admin,\r\n\r\nI want to be able to have final approval on which businesses are displayed publicly.\r\n\r\n----\r\n\r\nWhen businesses are submitted by Restarters, a Directory Admin should give them\r\nfinal approval before they are visible on the public search results.",
        "FeatureElements": [],
        "Result": {
          "WasExecuted": false,
          "WasSuccessful": false
        },
        "Tags": []
      },
      "Result": {
        "WasExecuted": false,
        "WasSuccessful": false
      }
    },
    {
      "RelativeFolder": "SectionB-Features\\B.1 - Directory Management\\8-TrustedBusinessFilter.feature",
      "Feature": {
        "Name": "B.1.8 - Trusted business filter",
        "Description": "----\r\n\r\nIn order to ensure we maintain confidence in our recommendations,\r\n\r\nAs the Restart Project,\r\n\r\nWe want to only display trusted businesses in search results.\r\n\r\n----\r\n\r\nBusinesses are filtered such that only those which meet certain criteria are\r\nincluded in the results.\r\n\r\nThe filters are as follows:\r\n\r\n* Having a registered business address \r\n* Having >= 80% positive independent reviews or testimonials.\r\n* Offering a minimum of three month’s warranty on repairs.\r\n\r\nThose which don't meet the criteria are hidden from the public search.",
        "FeatureElements": [],
        "Result": {
          "WasExecuted": false,
          "WasSuccessful": false
        },
        "Tags": [
          "@mvp"
        ]
      },
      "Result": {
        "WasExecuted": false,
        "WasSuccessful": false
      }
    },
    {
      "RelativeFolder": "SectionB-Features\\B.1 - Directory Management\\9-AuditingTheChanges.feature",
      "Feature": {
        "Name": "B.1.9 - Auditing the changes",
        "Description": "As a user\r\nI should be able to see the changes made to the businesses in the database.",
        "FeatureElements": [
          {
            "Name": "Auditing the changes made tobusinesses",
            "Slug": "auditing-the-changes-made-tobusinesses",
            "Description": "",
            "Steps": [
              {
                "Keyword": "When",
                "NativeKeyword": "When ",
                "Name": "a user wants to edit or add a new business",
                "StepComments": [],
                "AfterLastStepComments": []
              },
              {
                "Keyword": "Then",
                "NativeKeyword": "Then ",
                "Name": "the name of the user, and who last updated details should be logged in the database along with the date.",
                "StepComments": [],
                "AfterLastStepComments": []
              }
            ],
            "Tags": [],
            "Result": {
              "WasExecuted": false,
              "WasSuccessful": false
            }
          }
        ],
        "Result": {
          "WasExecuted": false,
          "WasSuccessful": false
        },
        "Tags": []
      },
      "Result": {
        "WasExecuted": false,
        "WasSuccessful": false
      }
    },
    {
      "RelativeFolder": "SectionB-Features\\B.2 - Find Repair Business\\1-SearchForBusiness.feature",
      "Feature": {
        "Name": "B.2.1 - Search for repair business",
        "Description": "----\r\n\r\nIn order to get my broken device fixed,\r\n\r\nAs a public user,\r\n\r\nI want to be able to search for repair shops that fix my type of device.\r\n\r\n----\r\n\r\nMembers of the public wish to find businesses that they can trust to repair their device.\r\nMost frequently they would like to find a local business, however in some\r\ncases it may be that the best (or only) business is located further afield.\r\n\r\n![](../Sketches/public_search.png)\r\n\r\n----",
        "FeatureElements": [
          {
            "Name": "Search by device, place or postcode, and radius",
            "Slug": "search-by-device-place-or-postcode-and-radius",
            "Description": "",
            "Steps": [
              {
                "Keyword": "When",
                "NativeKeyword": "When ",
                "Name": "a user enters the place or postcode, selects the device and search radius",
                "StepComments": [],
                "AfterLastStepComments": []
              },
              {
                "Keyword": "And",
                "NativeKeyword": "And ",
                "Name": "clicks on search button",
                "StepComments": [],
                "AfterLastStepComments": []
              },
              {
                "Keyword": "Then",
                "NativeKeyword": "Then ",
                "Name": "the user will see the results according to the search details given.",
                "StepComments": [],
                "AfterLastStepComments": []
              }
            ],
            "Tags": [],
            "Result": {
              "WasExecuted": false,
              "WasSuccessful": false
            }
          },
          {
            "Name": "Search by device and radius without place or postcode",
            "Slug": "search-by-device-and-radius-without-place-or-postcode",
            "Description": "",
            "Steps": [
              {
                "Keyword": "When",
                "NativeKeyword": "When ",
                "Name": "a user does not enter the place or postcode, and selects the device and search radius",
                "StepComments": [],
                "AfterLastStepComments": []
              },
              {
                "Keyword": "Then",
                "NativeKeyword": "Then ",
                "Name": "the search button becomes disabled and cannot preform search action, place or postcode filed is mandatory.",
                "StepComments": [],
                "AfterLastStepComments": []
              }
            ],
            "Tags": [],
            "Result": {
              "WasExecuted": false,
              "WasSuccessful": false
            }
          },
          {
            "Name": "Ways of search",
            "Slug": "ways-of-search",
            "Description": "",
            "Steps": [
              {
                "Keyword": "When",
                "NativeKeyword": "When ",
                "Name": "a user enters the mandatory field place and does not select the radius or device",
                "StepComments": [],
                "AfterLastStepComments": []
              },
              {
                "Keyword": "Then",
                "NativeKeyword": "Then ",
                "Name": "the radius or device fields are set to default values i.e., All of london and Everything repectivley",
                "StepComments": [],
                "AfterLastStepComments": []
              },
              {
                "Keyword": "And",
                "NativeKeyword": "And ",
                "Name": "can perform the search action.",
                "StepComments": [],
                "AfterLastStepComments": []
              }
            ],
            "Tags": [],
            "Result": {
              "WasExecuted": false,
              "WasSuccessful": false
            }
          }
        ],
        "Result": {
          "WasExecuted": false,
          "WasSuccessful": false
        },
        "Tags": [
          "@mvp"
        ]
      },
      "Result": {
        "WasExecuted": false,
        "WasSuccessful": false
      }
    },
    {
      "RelativeFolder": "SectionB-Features\\B.2 - Find Repair Business\\2-MapOfResults.feature",
      "Feature": {
        "Name": "B.2.2 - Map of results",
        "Description": "----\r\n\r\nIn order to easily visualise repair shops near me,\r\n\r\nAs a public user,\r\n\r\nI want to see the results of my search on map.\r\n\r\n----\r\n\r\n\r\n![](../Sketches/public_search.png)\r\n\r\n\r\n----",
        "FeatureElements": [
          {
            "Name": "View results on map",
            "Slug": "view-results-on-map",
            "Description": "",
            "Steps": [
              {
                "Keyword": "When",
                "NativeKeyword": "When ",
                "Name": "a user enters the place name and other other fileds",
                "StepComments": [],
                "AfterLastStepComments": []
              },
              {
                "Keyword": "And",
                "NativeKeyword": "And ",
                "Name": "click on search button",
                "StepComments": [],
                "AfterLastStepComments": []
              },
              {
                "Keyword": "Then",
                "NativeKeyword": "Then ",
                "Name": "the user will see the results on the map with location pointers accordingly.",
                "StepComments": [],
                "AfterLastStepComments": []
              }
            ],
            "Tags": [],
            "Result": {
              "WasExecuted": false,
              "WasSuccessful": false
            }
          }
        ],
        "Result": {
          "WasExecuted": false,
          "WasSuccessful": false
        },
        "Tags": []
      },
      "Result": {
        "WasExecuted": false,
        "WasSuccessful": false
      }
    },
    {
      "RelativeFolder": "SectionB-Features\\B.2 - Find Repair Business\\3-ListOfResults.feature",
      "Feature": {
        "Name": "B.2.3 - List of Results",
        "Description": "----\r\n\r\nIn order to easily read the results of my repair shop search,\r\n\r\nAs a public user,\r\n\r\nI want to see a list of my search lists, ordered by proximity.\r\n\r\n----\r\n\r\nOK to order by proximity, as long as we are saying every included shop\r\nis trusted.\r\n\r\n![](../Sketches/public_search.png)\r\n\r\n----",
        "FeatureElements": [
          {
            "Name": "View the list of results",
            "Slug": "view-the-list-of-results",
            "Description": "",
            "Steps": [
              {
                "Keyword": "When",
                "NativeKeyword": "When ",
                "Name": "a user enters all the fields according to his requirements and clicks on search button",
                "StepComments": [],
                "AfterLastStepComments": []
              },
              {
                "Keyword": "Then",
                "NativeKeyword": "Then ",
                "Name": "the user will see the list of results i.e., list of business ordered by proximity on the page.",
                "StepComments": [],
                "AfterLastStepComments": []
              }
            ],
            "Tags": [],
            "Result": {
              "WasExecuted": false,
              "WasSuccessful": false
            }
          }
        ],
        "Result": {
          "WasExecuted": false,
          "WasSuccessful": false
        },
        "Tags": []
      },
      "Result": {
        "WasExecuted": false,
        "WasSuccessful": false
      }
    },
    {
      "RelativeFolder": "SectionB-Features\\B.2 - Find Repair Business\\4-ViewBusinessDetails.feature",
      "Feature": {
        "Name": "B.2.4 - View business details",
        "Description": "---\r\n\r\nIn order to contact the repair business,\r\n\r\nAs a public user,\r\n\r\nI want to be able to view further business details.\r\n\r\n----\r\n  \r\nDetails to view\r\n---------------\r\n\r\n* Name\r\n* Website\r\n* Phone Number\r\n* Address\r\n* Reviews and ratings\r\n\r\n![](../Sketches/public_search.png)\r\n\r\n----",
        "FeatureElements": [
          {
            "Name": "To view and contact the repair business",
            "Slug": "to-view-and-contact-the-repair-business",
            "Description": "",
            "Steps": [
              {
                "Keyword": "When",
                "NativeKeyword": "When ",
                "Name": "a user either clicks on the location pointer on the map or on the list of repair business",
                "StepComments": [],
                "AfterLastStepComments": []
              },
              {
                "Keyword": "Then",
                "NativeKeyword": "Then ",
                "Name": "a pop up screen appears with the name, ratings, website, phone number, and address of the repair business",
                "StepComments": [],
                "AfterLastStepComments": []
              },
              {
                "Keyword": "And",
                "NativeKeyword": "And ",
                "Name": "the website, contact number are clickable, directly take to their website or open contact screen respectively.",
                "StepComments": [],
                "AfterLastStepComments": []
              }
            ],
            "Tags": [],
            "Result": {
              "WasExecuted": false,
              "WasSuccessful": false
            }
          }
        ],
        "Result": {
          "WasExecuted": false,
          "WasSuccessful": false
        },
        "Tags": [
          "@mvp"
        ]
      },
      "Result": {
        "WasExecuted": false,
        "WasSuccessful": false
      }
    },
    {
      "RelativeFolder": "SectionB-Features\\B.2 - Find Repair Business\\5-ShareResults.feature",
      "Feature": {
        "Name": "B.2.5 - Sharing the results",
        "Description": "As a user\r\nThey can be able to share the search results easily.",
        "FeatureElements": [
          {
            "Name": "Sharing search results",
            "Slug": "sharing-search-results",
            "Description": "",
            "Steps": [
              {
                "Keyword": "When",
                "NativeKeyword": "When ",
                "Name": "a user wants to share the list of search results",
                "StepComments": [],
                "AfterLastStepComments": []
              },
              {
                "Keyword": "Then",
                "NativeKeyword": "Then ",
                "Name": "the user can click on the share results button and copy the URL and share it.",
                "StepComments": [],
                "AfterLastStepComments": []
              }
            ],
            "Tags": [],
            "Result": {
              "WasExecuted": false,
              "WasSuccessful": false
            }
          },
          {
            "Name": "Sharing specific repair business",
            "Slug": "sharing-specific-repair-business",
            "Description": "",
            "Steps": [
              {
                "Keyword": "When",
                "NativeKeyword": "When ",
                "Name": "a user wants to share the result of a sepecific repair business",
                "StepComments": [],
                "AfterLastStepComments": []
              },
              {
                "Keyword": "Then",
                "NativeKeyword": "Then ",
                "Name": "the user can click on the share results button on the pop up screen of the business",
                "StepComments": [],
                "AfterLastStepComments": []
              },
              {
                "Keyword": "And",
                "NativeKeyword": "And ",
                "Name": "share the repair business.",
                "StepComments": [],
                "AfterLastStepComments": []
              }
            ],
            "Tags": [],
            "Result": {
              "WasExecuted": false,
              "WasSuccessful": false
            }
          }
        ],
        "Result": {
          "WasExecuted": false,
          "WasSuccessful": false
        },
        "Tags": []
      },
      "Result": {
        "WasExecuted": false,
        "WasSuccessful": false
      }
    },
    {
      "RelativeFolder": "SectionB-Features\\B.3 - Non-functional\\1-ResponsiveDesign.feature",
      "Feature": {
        "Name": "B.3.1 - Responsive design",
        "Description": "----\r\n\r\nIn order to easily refer participants at Restart Parties,\r\n\r\nAs a Restarter/Restart Host,\r\n\r\nI want to be able to easily search for businesses on my phone.\r\n\r\n----\r\n\r\n**MVP**: \r\n\r\n* Responsive front-end to the website.\r\n\r\n**Future**: \r\n\r\n* Responsive directory management.\r\n* Potentially an installable app (either hybrid or native).",
        "FeatureElements": [],
        "Result": {
          "WasExecuted": false,
          "WasSuccessful": false
        },
        "Tags": []
      },
      "Result": {
        "WasExecuted": false,
        "WasSuccessful": false
      }
    },
    {
      "RelativeFolder": "SectionB-Features\\B.3 - Non-functional\\2-SiteIntegration.feature",
      "Feature": {
        "Name": "B.3.2 - Site integration",
        "Description": "----\r\n\r\nIn order to engage Restarters,\r\n\r\nAs the Restart Project,\r\n\r\nWe want volunteers to access the directory through our existing community site.\r\n\r\n----\r\n\r\nWe have an existing application, the Fixometer, as part of community.therestartproject.org.\r\nWe want to avoid multiple logins for our community members, so the ability to submit repair\r\nbusinesses should be a module that is accessible behind the same login.",
        "FeatureElements": [],
        "Result": {
          "WasExecuted": false,
          "WasSuccessful": false
        },
        "Tags": []
      },
      "Result": {
        "WasExecuted": false,
        "WasSuccessful": false
      }
    },
    {
      "RelativeFolder": "SectionB-Features\\B.3 - Non-functional\\3-Implementation.feature",
      "Feature": {
        "Name": "B.3.3 - Implementation",
        "Description": "Ushahidi as a possible development platform.",
        "FeatureElements": [],
        "Result": {
          "WasExecuted": false,
          "WasSuccessful": false
        },
        "Tags": []
      },
      "Result": {
        "WasExecuted": false,
        "WasSuccessful": false
      }
    }
  ],
  "Summary": {
    "Tags": [
      {
        "Tag": "@mvp",
        "Total": 4,
        "Passing": 0,
        "Failing": 0,
        "Inconclusive": 4
      }
    ],
    "Folders": [
      {
        "Folder": "SectionB-Features",
        "Total": 9,
        "Passing": 0,
        "Failing": 0,
        "Inconclusive": 9
      }
    ],
    "NotTestedFolders": [
      {
        "Folder": "SectionB-Features",
        "Total": 0,
        "Passing": 0,
        "Failing": 0,
        "Inconclusive": 0
      }
    ],
    "Scenarios": {
      "Total": 9,
      "Passing": 0,
      "Failing": 0,
      "Inconclusive": 9
    },
    "Features": {
      "Total": 21,
      "Passing": 0,
      "Failing": 0,
      "Inconclusive": 21
    }
  },
  "Configuration": {
    "SutName": "Restart Community Software",
    "SutVersion": "4.0.0(Beta)",
    "GeneratedOn": "13 December 2018 16:24:01"
  }
});