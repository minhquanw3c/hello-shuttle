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
                    "carId": "mn-van",
                    "carName": "Minivan",
                    "availableCars": "1",
                    "carStartPrice": "50.00",
                    "carImage": "vehicle-minivan.png"
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
                "origin": {
                    "description": "Coconut Grove, Miami, FL, USA",
                    "matched_substrings": [
                        {
                            "length": 7,
                            "offset": 0
                        }
                    ],
                    "place_id": "ChIJ21gpp8S32YgR-wAxYp87fic",
                    "reference": "ChIJ21gpp8S32YgR-wAxYp87fic",
                    "structured_formatting": {
                        "main_text": "Coconut Grove",
                        "main_text_matched_substrings": [
                            {
                                "length": 7,
                                "offset": 0
                            }
                        ],
                        "secondary_text": "Miami, FL, USA"
                    },
                    "terms": [
                        {
                            "offset": 0,
                            "value": "Coconut Grove"
                        },
                        {
                            "offset": 15,
                            "value": "Miami"
                        },
                        {
                            "offset": 22,
                            "value": "FL"
                        },
                        {
                            "offset": 26,
                            "value": "USA"
                        }
                    ],
                    "types": [
                        "neighborhood",
                        "political",
                        "geocode"
                    ]
                },
                "destination": {
                    "description": "Rose Flower, Bedford Park Boulevard, The Bronx, NY, USA",
                    "matched_substrings": [
                        {
                            "length": 11,
                            "offset": 0
                        }
                    ],
                    "place_id": "ChIJF92mknnzwokRnc-oNTkFOTw",
                    "reference": "ChIJF92mknnzwokRnc-oNTkFOTw",
                    "structured_formatting": {
                        "main_text": "Rose Flower",
                        "main_text_matched_substrings": [
                            {
                                "length": 11,
                                "offset": 0
                            }
                        ],
                        "secondary_text": "Bedford Park Boulevard, The Bronx, NY, USA"
                    },
                    "terms": [
                        {
                            "offset": 0,
                            "value": "Rose Flower"
                        },
                        {
                            "offset": 13,
                            "value": "Bedford Park Boulevard"
                        },
                        {
                            "offset": 37,
                            "value": "The Bronx"
                        },
                        {
                            "offset": 48,
                            "value": "NY"
                        },
                        {
                            "offset": 52,
                            "value": "USA"
                        }
                    ],
                    "types": [
                        "meal_delivery",
                        "restaurant",
                        "food",
                        "point_of_interest",
                        "establishment"
                    ]
                },
                "miles": 0,
                "pickup": {
                    "date": "2023-07-15",
                    "time": "01:01:00"
                },
                "originSearch": "Coconut Grove, Miami, FL, USA",
                "destinationSearch": "Rose Flower, Bedford Park Boulevard, The Bronx, NY, USA",
                "passengers": "9"
            },
            "tripType": "round-trip"
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
                    "miles": "1295"
                }
            },
            "prices": {
                "oneWayTrip": 338,
                "roundTrip": 2638.9,
                "total": 3274.59,
                "totalNotDiscount": "2976.90",
                "discountAmount": "0.00",
                "tipDriverAmountOther": null,
                "tipDriverAmount": 0.1
            },
            "agreeTermsConditions": true,
            "appliedCoupons": [],
            "additionalNotes": "pick up and packaging goods and services"
        }
    };