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
            "vehicle": {}
        },
        "roundTrip": {
            "vehicle": {}
        }
    },
    "reservation": {
        "oneWayTrip": {
            "origin": {
                "description": "Lampson Avenue, Garden Grove, CA, USA",
                "matched_substrings": [
                    {
                        "length": 7,
                        "offset": 0
                    }
                ],
                "place_id": "EiVMYW1wc29uIEF2ZW51ZSwgR2FyZGVuIEdyb3ZlLCBDQSwgVVNBIi4qLAoUChIJ0UHmFZIo3YARY6TqyBMHHg0SFAoSCY3NHZ0_KN2AETqLD70ilpAD",
                "reference": "EiVMYW1wc29uIEF2ZW51ZSwgR2FyZGVuIEdyb3ZlLCBDQSwgVVNBIi4qLAoUChIJ0UHmFZIo3YARY6TqyBMHHg0SFAoSCY3NHZ0_KN2AETqLD70ilpAD",
                "structured_formatting": {
                    "main_text": "Lampson Avenue",
                    "main_text_matched_substrings": [
                        {
                            "length": 7,
                            "offset": 0
                        }
                    ],
                    "secondary_text": "Garden Grove, CA, USA"
                },
                "terms": [
                    {
                        "offset": 0,
                        "value": "Lampson Avenue"
                    },
                    {
                        "offset": 16,
                        "value": "Garden Grove"
                    },
                    {
                        "offset": 30,
                        "value": "CA"
                    },
                    {
                        "offset": 34,
                        "value": "USA"
                    }
                ],
                "types": [
                    "route",
                    "geocode"
                ]
            },
            "destination": {
                "description": "Lampson Elementary School, Lampson Avenue, Garden Grove, CA, USA",
                "matched_substrings": [
                    {
                        "length": 7,
                        "offset": 0
                    }
                ],
                "place_id": "ChIJcZ7_p4rX3IAR9b7UYpaPaB0",
                "reference": "ChIJcZ7_p4rX3IAR9b7UYpaPaB0",
                "structured_formatting": {
                    "main_text": "Lampson Elementary School",
                    "main_text_matched_substrings": [
                        {
                            "length": 7,
                            "offset": 0
                        }
                    ],
                    "secondary_text": "Lampson Avenue, Garden Grove, CA, USA"
                },
                "terms": [
                    {
                        "offset": 0,
                        "value": "Lampson Elementary School"
                    },
                    {
                        "offset": 27,
                        "value": "Lampson Avenue"
                    },
                    {
                        "offset": 43,
                        "value": "Garden Grove"
                    },
                    {
                        "offset": 57,
                        "value": "CA"
                    },
                    {
                        "offset": 61,
                        "value": "USA"
                    }
                ],
                "types": [
                    "primary_school",
                    "primary_school",
                    "school",
                    "point_of_interest",
                    "establishment"
                ]
            },
            "miles": 0,
            "pickup": {
                "date": "2023-09-03",
                "time": "00:00:00"
            },
            "originSearch": null,
            "destinationSearch": null,
            "passengers": 2,
            "luggages": 2,
            "hasRestStop": "1",
            "restStop": {
                "description": "Garden Grove, CA, USA",
                "matched_substrings": [
                    {
                        "length": 6,
                        "offset": 0
                    }
                ],
                "place_id": "ChIJjc0dnT8o3YAROosPvSKWkAM",
                "reference": "ChIJjc0dnT8o3YAROosPvSKWkAM",
                "structured_formatting": {
                    "main_text": "Garden Grove",
                    "main_text_matched_substrings": [
                        {
                            "length": 6,
                            "offset": 0
                        }
                    ],
                    "secondary_text": "CA, USA"
                },
                "terms": [
                    {
                        "offset": 0,
                        "value": "Garden Grove"
                    },
                    {
                        "offset": 14,
                        "value": "CA"
                    },
                    {
                        "offset": 18,
                        "value": "USA"
                    }
                ],
                "types": [
                    "locality",
                    "political",
                    "geocode"
                ]
            }
        },
        "roundTrip": {
            "origin": {
                "description": "Disneyland Park, Anaheim, CA, USA",
                "matched_substrings": [
                    {
                        "length": 6,
                        "offset": 0
                    }
                ],
                "place_id": "ChIJa147K9HX3IAR-lwiGIQv9i4",
                "reference": "ChIJa147K9HX3IAR-lwiGIQv9i4",
                "structured_formatting": {
                    "main_text": "Disneyland Park",
                    "main_text_matched_substrings": [
                        {
                            "length": 6,
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
                        "length": 3,
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
                            "length": 3,
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
                "date": "2023-09-03",
                "time": "00:00:00"
            },
            "originSearch": null,
            "destinationSearch": null,
            "passengers": 2,
            "luggages": 2,
            "hasRestStop": "1",
            "restStop": {
                "description": "Honda Center, East Katella Avenue, Anaheim, CA, USA",
                "matched_substrings": [
                    {
                        "length": 5,
                        "offset": 0
                    }
                ],
                "place_id": "ChIJXyczhHXX3IARFVUqyhMqiqg",
                "reference": "ChIJXyczhHXX3IARFVUqyhMqiqg",
                "structured_formatting": {
                    "main_text": "Honda Center",
                    "main_text_matched_substrings": [
                        {
                            "length": 5,
                            "offset": 0
                        }
                    ],
                    "secondary_text": "East Katella Avenue, Anaheim, CA, USA"
                },
                "terms": [
                    {
                        "offset": 0,
                        "value": "Honda Center"
                    },
                    {
                        "offset": 14,
                        "value": "East Katella Avenue"
                    },
                    {
                        "offset": 35,
                        "value": "Anaheim"
                    },
                    {
                        "offset": 44,
                        "value": "CA"
                    },
                    {
                        "offset": 48,
                        "value": "USA"
                    }
                ],
                "types": [
                    "tourist_attraction",
                    "stadium",
                    "point_of_interest",
                    "establishment"
                ]
            }
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
            "firstName": null,
            "lastName": null,
            "dob": null,
            "contact": {
                "mobileNumber": null,
                "email": null
            },
            "registerAccount": null,
            "hasRegistered": null,
            "registeredAccount": null,
            "account": {
                "sameAsContactEmail": null,
                "email": null,
                "password": null,
                "confirmPassword": null,
            },
        },
        "airline": {
            "brand": null,
            "flightNumber": null
        },
        "routes": {
            "oneWayTrip": {
                "miles": "4"
            },
            "roundTrip": {
                "miles": "4"
            }
        },
        "prices": {
            "oneWayTrip": "73.00",
            "roundTrip": "58.00",
            "total": "131.00",
            "totalNotDiscount": "131.00",
            "discountAmount": 0,
            "tipDriverAmountOther": null,
            "tipDriverAmount": null
        },
        "agreeTermsConditions": null,
        "appliedCoupons": [],
        "additionalNotes": null
    }
};