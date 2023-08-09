const formData = 
    {
        "selectCar": {
            "oneWayTrip": {
                "vehicle": {
                    "carId": "mn-van",
                    "carName": "Minivan",
                    "availableCars": "1",
                    "carStartPrice": "50.00",
                    "carImage": "vehicle-minivan.png"
                }
            },
            "roundTrip": {
                "vehicle": null
            }
        },
        "reservation": {
            "oneWayTrip": {
                "origin": {
                    "description": "Disneyland Park, Anaheim, CA, USA",
                    "matched_substrings": [
                        {
                            "length": 10,
                            "offset": 0
                        }
                    ],
                    "place_id": "ChIJa147K9HX3IAR-lwiGIQv9i4",
                    "reference": "ChIJa147K9HX3IAR-lwiGIQv9i4",
                    "structured_formatting": {
                        "main_text": "Disneyland Park",
                        "main_text_matched_substrings": [
                            {
                                "length": 10,
                                "offset": 0
                            }
                        ],
                        "secondary_text": "Anaheim, CA, USA"
                    },
                    "terms": [
                        {
                            "offset": 0,
                            "value": "Disneyland Park"
                        },
                        {
                            "offset": 17,
                            "value": "Anaheim"
                        },
                        {
                            "offset": 26,
                            "value": "CA"
                        },
                        {
                            "offset": 30,
                            "value": "USA"
                        }
                    ],
                    "types": [
                        "tourist_attraction",
                        "amusement_park",
                        "point_of_interest",
                        "establishment"
                    ]
                },
                "destination": {
                    "description": "11371 Lampson Avenue, Garden Grove, CA, USA",
                    "matched_substrings": [
                        {
                            "length": 5,
                            "offset": 0
                        },
                        {
                            "length": 7,
                            "offset": 6
                        }
                    ],
                    "place_id": "ChIJYdCLrwUo3YARaD4yJKauRu0",
                    "reference": "ChIJYdCLrwUo3YARaD4yJKauRu0",
                    "structured_formatting": {
                        "main_text": "11371 Lampson Avenue",
                        "main_text_matched_substrings": [
                            {
                                "length": 5,
                                "offset": 0
                            },
                            {
                                "length": 7,
                                "offset": 6
                            }
                        ],
                        "secondary_text": "Garden Grove, CA, USA"
                    },
                    "terms": [
                        {
                            "offset": 0,
                            "value": "11371"
                        },
                        {
                            "offset": 6,
                            "value": "Lampson Avenue"
                        },
                        {
                            "offset": 22,
                            "value": "Garden Grove"
                        },
                        {
                            "offset": 36,
                            "value": "CA"
                        },
                        {
                            "offset": 40,
                            "value": "USA"
                        }
                    ],
                    "types": [
                        "premise",
                        "geocode"
                    ]
                },
                "miles": 0,
                "pickup": {
                    "date": "2023-07-15",
                    "time": "21:00:00"
                },
                "originSearch": "Disneyland Park, Anaheim, CA, USA",
                "destinationSearch": "11371 Lampson Avenue, Garden Grove, CA, USA",
                "passengers": "6"
            },
            "roundTrip": {
                "origin": null,
                "destination": null,
                "miles": 0,
                "pickup": {
                    "date": null,
                    "time": null
                },
                "originSearch": null,
                "destinationSearch": null,
                "passengers": 0
            },
            "tripType": "one-way"
        },
        "chooseOptions": {
            "oneWayTrip": {
                "extras": [
                    {
                        "configId": "cfg-opt-E1kOI",
                        "configName": "Pets included",
                        "configValue": "90.00",
                        "configActive": "1",
                        "configEditable": "1",
                        "configTypeId": "cfg-01",
                        "configTypeName": "Dolar",
                        "configGroupId": "cfg-gr-opt",
                        "configGroupName": "Extras"
                    },
                    {
                        "configId": "crst",
                        "configName": "Car seat",
                        "configValue": "20.00",
                        "configActive": "1",
                        "configEditable": "1",
                        "configTypeId": "cfg-01",
                        "configTypeName": "Dolar",
                        "configGroupId": "cfg-gr-opt",
                        "configGroupName": "Extras"
                    },
                    {
                        "configId": "mt-n-grt",
                        "configName": "Meet and greet",
                        "configValue": "40.00",
                        "configActive": "1",
                        "configEditable": "1",
                        "configTypeId": "cfg-01",
                        "configTypeName": "Dolar",
                        "configGroupId": "cfg-gr-opt",
                        "configGroupName": "Extras"
                    }
                ],
                "protection": [
                    {
                        "configId": "bk-insurance",
                        "configName": "Booking Insurance",
                        "configValue": "90.00",
                        "configActive": "1",
                        "configEditable": "1",
                        "configTypeId": "cfg-01",
                        "configTypeName": "Dolar",
                        "configGroupId": "cfg-gr-prt",
                        "configGroupName": "Protection"
                    }
                ]
            },
            "roundTrip": {
                "extras": [],
                "protection": []
            }
        },
        "review": {
            "customer": {
                "firstName": "le",
                "lastName": "minh quan",
                "dob": null,
                "contact": {
                    "mobileNumber": "0941610700",
                    "email": "minhquanw3c@gmail.com"
                }
            },
            "airline": {
                "brand": {
                    text: 'Sun Country Airlines',
                    value: 11,
                },
                "flightNumber": "119755ACF"
            },
            "routes": {
                "oneWayTrip": {
                    "miles": "4"
                },
                "roundTrip": {
                    "miles": 0
                }
            },
            "prices": {
                "oneWayTrip": 338,
                "roundTrip": 0,
                "total": 216.2,
                "totalNotDiscount": "338.00",
                "discountAmount": "150.00",
                "tipDriverAmountOther": null,
                "tipDriverAmount": 0.15
            },
            "agreeTermsConditions": true,
            "appliedCoupons": [
                "{\n  \"couponId\": \"b1a6eff8-f45f-4ba7-8508-73398178bb02\",\n  \"couponCode\": \"HcFon3g3CV\",\n  \"couponDiscountAmount\": \"150.00\",\n  \"couponIsPercentage\": \"no\",\n  \"couponStartDate\": \"2023-07-15\",\n  \"couponEndDate\": \"2023-07-17\"\n}"
            ],
            "additionalNotes": "pick up and packaging goods and services"
        }
    };

const formDataRoundTrip =
{
    "selectCar": {
        "oneWayTrip": {
            "vehicle": {
                "carId": "suv",
                "carName": "SUV",
                "availableCars": "1",
                "carStartPrice": "85.00",
                "carImage": "vehicle-suv.png"
            }
        },
        "roundTrip": {
            "vehicle": {
                "carId": "tt-psgr",
                "carName": "Transit passenger",
                "availableCars": "1",
                "carStartPrice": "65.00",
                "carImage": "vehicle-passenger.png"
            }
        }
    },
    "reservation": {
        "oneWayTrip": {
            "origin": {
                "description": "Disneyland Park, Anaheim, CA, USA",
                "matched_substrings": [
                    {
                        "length": 10,
                        "offset": 0
                    }
                ],
                "place_id": "ChIJa147K9HX3IAR-lwiGIQv9i4",
                "reference": "ChIJa147K9HX3IAR-lwiGIQv9i4",
                "structured_formatting": {
                    "main_text": "Disneyland Park",
                    "main_text_matched_substrings": [
                        {
                            "length": 10,
                            "offset": 0
                        }
                    ],
                    "secondary_text": "Anaheim, CA, USA"
                },
                "terms": [
                    {
                        "offset": 0,
                        "value": "Disneyland Park"
                    },
                    {
                        "offset": 17,
                        "value": "Anaheim"
                    },
                    {
                        "offset": 26,
                        "value": "CA"
                    },
                    {
                        "offset": 30,
                        "value": "USA"
                    }
                ],
                "types": [
                    "amusement_park",
                    "tourist_attraction",
                    "point_of_interest",
                    "establishment"
                ]
            },
            "destination": {
                "description": "11371 Lampson Avenue, Garden Grove, CA, USA",
                "matched_substrings": [
                    {
                        "length": 5,
                        "offset": 0
                    },
                    {
                        "length": 5,
                        "offset": 6
                    }
                ],
                "place_id": "ChIJYdCLrwUo3YARaD4yJKauRu0",
                "reference": "ChIJYdCLrwUo3YARaD4yJKauRu0",
                "structured_formatting": {
                    "main_text": "11371 Lampson Avenue",
                    "main_text_matched_substrings": [
                        {
                            "length": 5,
                            "offset": 0
                        },
                        {
                            "length": 5,
                            "offset": 6
                        }
                    ],
                    "secondary_text": "Garden Grove, CA, USA"
                },
                "terms": [
                    {
                        "offset": 0,
                        "value": "11371"
                    },
                    {
                        "offset": 6,
                        "value": "Lampson Avenue"
                    },
                    {
                        "offset": 22,
                        "value": "Garden Grove"
                    },
                    {
                        "offset": 36,
                        "value": "CA"
                    },
                    {
                        "offset": 40,
                        "value": "USA"
                    }
                ],
                "types": [
                    "premise",
                    "geocode"
                ]
            },
            "miles": 0,
            "pickup": {
                "date": "2023-07-25",
                "time": "15:00:00"
            },
            "originSearch": "Disneyland Park, Anaheim, CA, USA",
            "destinationSearch": "11371 Lampson Avenue, Garden Grove, CA, USA",
            "passengers": "3",
            "luggages": "3",
        },
        "roundTrip": {
            "origin": {
                "description": "San Francisco International Airport (SFO) (SFO), San Francisco, CA, USA",
                "matched_substrings": [
                    {
                        "length": 11,
                        "offset": 0
                    }
                ],
                "place_id": "ChIJVVVVVYx3j4ARP-3NGldc8qQ",
                "reference": "ChIJVVVVVYx3j4ARP-3NGldc8qQ",
                "structured_formatting": {
                    "main_text": "San Francisco International Airport (SFO) (SFO)",
                    "main_text_matched_substrings": [
                        {
                            "length": 11,
                            "offset": 0
                        }
                    ],
                    "secondary_text": "San Francisco, CA, USA"
                },
                "terms": [
                    {
                        "offset": 0,
                        "value": "San Francisco International Airport (SFO) (SFO)"
                    },
                    {
                        "offset": 49,
                        "value": "San Francisco"
                    },
                    {
                        "offset": 64,
                        "value": "CA"
                    },
                    {
                        "offset": 68,
                        "value": "USA"
                    }
                ],
                "types": [
                    "airport",
                    "point_of_interest",
                    "establishment"
                ]
            },
            "destination": {
                "description": "11371 Lampson Avenue, Garden Grove, CA, USA",
                "matched_substrings": [
                    {
                        "length": 5,
                        "offset": 0
                    },
                    {
                        "length": 7,
                        "offset": 6
                    }
                ],
                "place_id": "ChIJYdCLrwUo3YARaD4yJKauRu0",
                "reference": "ChIJYdCLrwUo3YARaD4yJKauRu0",
                "structured_formatting": {
                    "main_text": "11371 Lampson Avenue",
                    "main_text_matched_substrings": [
                        {
                            "length": 5,
                            "offset": 0
                        },
                        {
                            "length": 7,
                            "offset": 6
                        }
                    ],
                    "secondary_text": "Garden Grove, CA, USA"
                },
                "terms": [
                    {
                        "offset": 0,
                        "value": "11371"
                    },
                    {
                        "offset": 6,
                        "value": "Lampson Avenue"
                    },
                    {
                        "offset": 22,
                        "value": "Garden Grove"
                    },
                    {
                        "offset": 36,
                        "value": "CA"
                    },
                    {
                        "offset": 40,
                        "value": "USA"
                    }
                ],
                "types": [
                    "premise",
                    "geocode"
                ]
            },
            "miles": 0,
            "pickup": {
                "date": "2023-07-26",
                "time": "00:30:00"
            },
            "originSearch": "San Francisco International Airport (SFO) (SFO), San Francisco, CA, USA",
            "destinationSearch": "11371 Lampson Avenue, Garden Grove, CA, USA",
            "passengers": "5",
            "luggages": "5",
        },
        "tripType": "round-trip"
    },
    "chooseOptions": {
        "oneWayTrip": {
            "extras": [],
            "protection": []
        },
        "roundTrip": {
            "extras": [],
            "protection": []
        }
    },
    "review": {
        "customer": {
            "firstName": "le",
            "lastName": "minh quan",
            "dob": null,
            "contact": {
                "mobileNumber": "0941610700",
                "email": "minhquanw3c@gmail.com"
            }
        },
        "airline": {
            "brand": {
                "text": "California Pacific Airlines",
                "value": 16
            },
            "flightNumber": "119755ACF"
        },
        "routes": {
            "oneWayTrip": {
                "miles": "4"
            },
            "roundTrip": {
                "miles": "403"
            }
        },
        "prices": {
            "oneWayTrip": "223.30",
            "roundTrip": "859.98",
            "total": "1245.77",
            "totalNotDiscount": 1083.28,
            "discountAmount": 0,
            "tipDriverAmountOther": null,
            "tipDriverAmount": null
        },
        "agreeTermsConditions": true,
        "appliedCoupons": [],
        "additionalNotes": "test lorem ipsum"
    }
};