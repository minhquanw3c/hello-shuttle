const { required, requiredIf, minLength, email, minValue } = window.validators;
const windowScope = window;

var app = new Vue({
    el: '#main-app',
    data: function () {
        return {
            options: {
                YESNO: [
                    {
                        text: 'Yes',
                        value: true,
                    },
                    {
                        text: 'No',
                        value: false,
                    },
                ],
            },
            form: {
                bookingId: null,
                bookingRequirements: {
                    selectCar: {
                        oneWayTrip: {
                            vehicle: null,
                        },
                        roundTrip: {
                            vehicle: null,
                        },
                    },
                    reservation: {
                        oneWayTrip: {
                            origin: null,
                            destination: null,
                            miles: 0,
                            pickup: {
                                date: null,
                                time: null,
                            },
                            originSearch: null,
                            destinationSearch: null,
                            passengers: 0,
                        },
                        roundTrip: {
                            origin: null,
                            destination: null,
                            miles: 0,
                            pickup: {
                                date: null,
                                time: null,
                            },
                            originSearch: null,
                            destinationSearch: null,
                            passengers: 0,
                        },
                        tripType: 'one-way',
                    },
                    chooseOptions: {
                        oneWayTrip: {
                            extras: [],
                            protection: [],
                        },
                        roundTrip: {
                            extras: [],
                            protection: [],
                        },
                    },
                    review: {
                        customer: {
                            firstName: null,
                            lastName: null,
                            dob: null,
                            contact: {
                                mobileNumber: null,
                                email: null,
                            },
                        },
                        airline: {
                            brand: null,
                            flightNumber: null,
                        },
                        routes: {
                            oneWayTrip: {
                                miles: 0,
                            },
                            roundTrip: {
                                miles: 0
                            }
                        },
                        prices: {
                            oneWayTrip: 0,
                            roundTrip: 0,
                            total: 0,
                            totalNotDiscount: 0,
                            discountAmount: 0,
                            tipDriverAmountOther: null,
                            tipDriverAmount: null,
                        },
                        agreeTermsConditions: null,
                        appliedCoupons: [],
                        additionalNotes: null,
                    },
                },
            },
            errorMessages: {
                required: 'This field is required',
            },
            formActiveTab: 0,
            completedTabs: {
                reservation: true,
                selectCar: false,
                chooseOptions: false,
                review: false,
            },
            vehicles: {
                oneWayTrip: [],
                roundTrip: [],
            },
            tripTypes: [
                {
                    text: 'One-way trip',
                    value: 'one-way'
                },
                {
                    text: 'Round trip',
                    value: 'round-trip'
                }
            ],
            options: {
                extras: [],
                protection: [],
            },
            airlineBrands: [
                {
                    text: 'Select airline',
                    value: null,
                },
                {
                    text: 'American Airlines',
                    value: 1,
                },
                {
                    text: 'Southwest',
                    value: 2,
                },
                {
                    text: 'Alaska Airlines',
                    value: 3,
                },
                {
                    text: 'United Airlines',
                    value: 4,
                },
                {
                    text: 'Delta Air Lines',
                    value: 5,
                },
                {
                    text: 'Hawaiian Airlines',
                    value: 6,
                },
                {
                    text: 'JetBlue',
                    value: 7,
                },
                {
                    text: 'Spirit Airlines',
                    value: 8,
                },
                {
                    text: 'Frontier Airlines',
                    value: 9,
                },
                {
                    text: 'Allegiant Air',
                    value: 10,
                },
                {
                    text: 'Sun Country Airlines',
                    value: 11,
                },
                {
                    text: 'Alaska',
                    value: 12,
                },
                {
                    text: 'Air Canada',
                    value: 13,
                },
                {
                    text: 'Boutique Air',
                    value: 14,
                },
                {
                    text: 'EVA Air',
                    value: 15,
                },
                {
                    text: 'California Pacific Airlines',
                    value: 16,
                },
                {
                    text: 'Air California',
                    value: 17,
                },
                {
                    text: 'Air Premia',
                    value: 18,
                },
                {
                    text: 'United Express',
                    value: 19,
                },
                {
                    text: 'Advanced Air',
                    value: 20,
                },
                {
                    text: 'Contour Airlines',
                    value: 21,
                },
            ],
            configurations: [],
            transformedConfigs: {},
            dropdowns: {
                oneWayTrip: {
                    origin: {
                        show: false,
                        sessionToken: null,
                    },
                    destination: {
                        show: false,
                        sessionToken: null,
                    },
                    origins: [],
                    destinations: [],
                },
                roundTrip: {
                    origin: {
                        show: false,
                        sessionToken: null,
                    },
                    destination: {
                        show: false,
                        sessionToken: null,
                    },
                    origins: [],
                    destinations: [],
                },
            },
            coupon: null,
            skipValidation: true,
            showCheckoutNotice: false,
            tipDriverOptions: [
                {
                    text: '5%',
                    value: 0.05,
                },
                {
                    text: '10%',
                    value: 0.1,
                },
                {
                    text: '15%',
                    value: 0.15,
                },
                {
                    text: 'Other',
                    value: 'other',
                },
            ],
        }
    },
    mounted: async function () {
        const self = this;
        console.log('app mounted');

        this.form.bookingId = bookingId;

        setTimeout(() => {
            self.dropdowns.oneWayTrip.origin.sessionToken = self.generateSearchSessionToken();
            self.dropdowns.oneWayTrip.destination.sessionToken = self.generateSearchSessionToken();
            self.dropdowns.roundTrip.origin.sessionToken = self.generateSearchSessionToken();
            self.dropdowns.roundTrip.destination.sessionToken = self.generateSearchSessionToken();
        }, 2000);
    },
    methods: {
        generateSearchSessionToken: function () {
            const self = this;

            const uniqueString = new windowScope.google.maps.places.AutocompleteSessionToken;

            return uniqueString;
        },
        updateSearchResult: function (location, tripType, placeType) {
            const self = this;

            self.form.bookingRequirements.reservation[tripType][placeType] = location;
            self.form.bookingRequirements.reservation[tripType][placeType + 'Search'] = location.description;
            self.dropdowns[tripType][placeType].show = false;

            self.dropdowns[tripType][placeType].sessionToken = self.generateSearchSessionToken();
        },
        fetchSearchResultFromGoogle: function (value, tripType, placeType) {
            const self = this;

            self.dropdowns[tripType][placeType].show = true;

            var sessionToken = self.dropdowns[tripType][placeType].sessionToken;
            var userSearch = value;
            const options = {
                componentRestrictions: {
                    country: 'us'
                },
            };

            const displaySuggestions = function (predictions, status) {
                if (status != google.maps.places.PlacesServiceStatus.OK || !predictions) {
                    console.log(status);
                    alert(status);
                    return;
                }

                if (tripType === 'oneWayTrip') {
                    if (placeType === 'origin') {
                        self.dropdowns.oneWayTrip.origins = predictions;
                    }

                    if (placeType === 'destination') {
                        self.dropdowns.oneWayTrip.destinations = predictions;
                    }
                }

                if (tripType === 'roundTrip') {
                    if (placeType === 'origin') {
                        self.dropdowns.roundTrip.origins = predictions;
                    }

                    if (placeType === 'destination') {
                        self.dropdowns.roundTrip.destinations = predictions;
                    }
                }
            };

            autocompleteService.getPlacePredictions({
                input: userSearch,
                componentRestrictions: options.componentRestrictions,
                sessionToken: sessionToken
            }, displaySuggestions
            );
        },
        validateInputField: function (input) {
            const self = this;

            return input.$dirty ? !input.$invalid : null;
        },
        saveReservation: function () {
            const self = this;

            self.$v.form.bookingRequirements.reservation.$touch();
            var formValid = !self.$v.form.bookingRequirements.reservation.$invalid;

            if (!formValid) {
                self.showToastNotification(type = 'error');

                setTimeout(function () {
                    self.scrollToInvalidFields();
                }, 1000);

                return;
            }

            self.completedTabs.selectCar = true;
            self.fetchRoutesData();
            self.getAvailableCars();

            setTimeout(() => {
                self.formActiveTab = 1;
            }, 500);
        },
        getAvailableCars: function () {
            const self = this;

            var payload = {
                form: { ...self.form.bookingRequirements.reservation }
            }

            console.log(payload);

            axios
                .post(baseURL + '/api/car/list', payload)
                .then(res => {
                    console.log(res);
                    self.vehicles.oneWayTrip = res.data.oneWayCars;
                    self.vehicles.roundTrip = res.data.roundTripCars;
                    var toastType = res.data.result ? 'success' : 'error';
                    self.showToastNotification(toastType);
                })
                .catch(error => {
                    console.log(error);
                });
        },
        saveSelectCar: function () {
            const self = this;

            self.$v.form.bookingRequirements.selectCar.$touch();
            var formValid = !self.$v.form.bookingRequirements.selectCar.$invalid;

            if (!formValid) {
                self.showToastNotification(type = 'error', message = 'Please select at least one');

                setTimeout(function () {
                    self.scrollToInvalidFields();
                }, 1000);

                return;
            }

            self.completedTabs.chooseOptions = true;
            self.getOptionsList();

            setTimeout(() => {
                self.formActiveTab = 2;
            }, 500);
        },
        getOptionsList: function () {
            const self = this;

            var payload = {}

            axios
                .get(baseURL + '/api/configurations/list', payload)
                .then(res => {
                    self.options.extras = _.filter(res.data.configs, (option) => { return option.configGroupId === 'cfg-gr-opt' });
                    self.options.protection = _.filter(res.data.configs, (option) => { return option.configGroupId === 'cfg-gr-prt' });
                    self.configurations = _.filter(res.data.configs, (option) => { return option.configGroupId === 'cfg-gr-sys' });
                    self.transformedConfigs = self.constructConfigDictionary();

                    var toastType = res.data.result ? 'success' : 'error';
                    self.showToastNotification(toastType);
                })
                .catch(error => {
                    console.log(error);
                });
        },
        saveChooseOptions: function () {
            const self = this;

            self.computeRoutes();
            self.completedTabs.review = true;

            setTimeout(() => {
                self.formActiveTab = 3;
            }, 500);
        },
        submitBooking: function () {
            const self = this;

            self.$v.form.bookingRequirements.review.$touch();
            var formValid = !self.$v.form.bookingRequirements.review.$invalid;

            if (!formValid) {
                self.showToastNotification(type = 'error');

                setTimeout(function () {
                    self.scrollToInvalidFields();
                }, 1000);

                return;
            }

            self.showCheckoutNotice = true;

            var payload = {
                form: { ...self.form }
            }

            axios
                .post(baseURL + '/api/booking/save', payload)
                .then(res => {
                    console.log(res);
                    var toastType = res.data.result ? 'success' : 'error';
                    self.showToastNotification(toastType);

                    if (res.data.result === true) {
                        setTimeout(() => {
                            window.location.href = res.data.paymentLink;
                        }, 5000);
                    }
                })
                .catch(error => {
                    console.log(error);
                });
        },
        showToastNotification: function (type = 'error', message = '') {
            const self = this;

            var titleType = type === 'error' ? 'Error' : 'Success';
            var variantType = type === 'error' ? 'danger' : 'success';
            var toastMessage = "";

            if (type === 'error') {
                toastMessage = message ? message : 'There are errors occured';
            }

            if (type === 'success') {
                toastMessage = message ? message : 'Data is saved';
            }

            self.$bvToast.toast(
                toastMessage,
                {
                    title: titleType,
                    autoHideDelay: 3000,
                    variant: variantType,
                    solid: true,
                    noCloseButton: true,
                    appendToast: true,
                }
            );
        },
        scrollToInvalidFields: function () {
            const self = this;

            var invalidFields = $('.tab-content .tab-pane.active form .form-group.is-invalid .d-block.invalid-feedback, .tab-content .tab-pane.active form .alert.alert-danger');

            if (invalidFields.length > 0) {
                invalidFields[0].scrollIntoView({
                    behavior: 'smooth',
                    block: 'center',
                });
            }
        },
        fetchRoutesData: async function () {
            const self = this;

            const routeUrl = 'https://routes.googleapis.com/directions/v2:computeRoutes?key=AIzaSyBEGGWz3KOsiPnxuygccrvKGBJEJgxih3s'
            const oneMeterPerMile = 0.000621371;
            var tripType = self.form.bookingRequirements.reservation.tripType;

            let oneWayTripRouteMiles = 0;
            let roundTripRouteMiles = 0;

            const oneWayTripPayload = {
                origin: {
                    placeId: self.form.bookingRequirements.reservation.oneWayTrip.origin.place_id
                },
                destination: {
                    placeId: self.form.bookingRequirements.reservation.oneWayTrip.destination.place_id
                },
                travelMode: "DRIVE",
                // transitPreferences: {
                //     allowedTravelModes: [
                //         "LIGHT_RAIL",
                //         "RAIL",
                //     ]
                // },
                computeAlternativeRoutes: false,
                languageCode: "en-US",
                units: "IMPERIAL",
            };

            await axios
                .post(
                    routeUrl,
                    oneWayTripPayload,
                    {
                        headers: {
                            'X-Goog-FieldMask': 'routes.distanceMeters'
                        }
                    }
                )
                .then((res) => {
                    console.log(res.data);
                    if (res.data.routes) {
                        oneWayTripRouteMiles = res.data.routes[0].distanceMeters;
                    }
                })
                .catch((err) => {
                    console.log(err);
                });

            self.form.bookingRequirements.review.routes.oneWayTrip.miles = parseFloat(oneMeterPerMile * parseInt(oneWayTripRouteMiles)).toFixed(0);

            if (tripType === 'round-trip') {

                const roundTripPayload = {
                    origin: {
                        placeId: self.form.bookingRequirements.reservation.roundTrip.origin.place_id
                    },
                    destination: {
                        placeId: self.form.bookingRequirements.reservation.roundTrip.destination.place_id
                    },
                    travelMode: "DRIVE",
                    // transitPreferences: {
                    //     allowedTravelModes: [
                    //         "LIGHT_RAIL",
                    //         "RAIL",
                    //     ]
                    // },
                    computeAlternativeRoutes: false,
                    languageCode: "en-US",
                    units: "IMPERIAL",
                };

                await axios
                    .post(
                        routeUrl,
                        roundTripPayload,
                        {
                            headers: {
                                'X-Goog-FieldMask': 'routes.distanceMeters'
                            }
                        }
                    )
                    .then((res) => {
                        console.log(res.data);
                        if (res.data.routes) {
                            roundTripRouteMiles = res.data.routes[0].distanceMeters;
                        }
                    })
                    .catch((err) => {
                        console.log(err);
                    });

                self.form.bookingRequirements.review.routes.roundTrip.miles = parseFloat(oneMeterPerMile * parseInt(roundTripRouteMiles)).toFixed(0);
            }
        },
        computeRoutes: function () {
            const self = this;

            var tripType = self.form.bookingRequirements.reservation.tripType;

            var oneWayTripRouteMiles = self.form.bookingRequirements.review.routes.oneWayTrip.miles;
            var oneWayTripPassengers = self.form.bookingRequirements.reservation.oneWayTrip.passengers;
            var oneWayTripCarPrice = self.form.bookingRequirements.selectCar.oneWayTrip.vehicle.carStartPrice;
            var oneWayTripChosenOptions = [...self.form.bookingRequirements.chooseOptions.oneWayTrip.extras, ...self.form.bookingRequirements.chooseOptions.oneWayTrip.protection];
            var oneWayTripPickupTime = self.form.bookingRequirements.reservation.oneWayTrip.pickup.time;

            self.form.bookingRequirements.review.prices.oneWayTrip = self.calculateRoutePrice(oneWayTripRouteMiles, oneWayTripPassengers, oneWayTripCarPrice, oneWayTripChosenOptions, oneWayTripPickupTime);

            if (tripType === 'round-trip') {
                var roundTripRouteMiles = self.form.bookingRequirements.review.routes.roundTrip.miles;
                var roundTripPassengers = self.form.bookingRequirements.reservation.roundTrip.passengers;
                var roundTripCarPrice = self.form.bookingRequirements.selectCar.roundTrip.vehicle.carStartPrice;
                var roundTripChosenOptions = [...self.form.bookingRequirements.chooseOptions.roundTrip.extras, ...self.form.bookingRequirements.chooseOptions.roundTrip.protection];
                var roundTripPickupTime = self.form.bookingRequirements.reservation.roundTrip.pickup.time;

                self.form.bookingRequirements.review.prices.roundTrip = self.calculateRoutePrice(roundTripRouteMiles, roundTripPassengers, roundTripCarPrice, roundTripChosenOptions, roundTripPickupTime);
            }
        },
        constructConfigDictionary: function () {
            const self = this;

            const arrayOfObjects = [...self.configurations];

            // New object to store the key-value pairs
            var newObject = {};

            // Iterate over the array
            for (let i = 0; i < arrayOfObjects.length; i++) {
                const currentObject = arrayOfObjects[i];

                // Iterate over the key-value pairs of the current object
                for (const key in currentObject) {
                    if (currentObject.hasOwnProperty(key) && key === 'configId') {
                        const objectKey = currentObject['configId'];
                        const objectValue = currentObject['configValue'];

                        // Add the key-value pair to the new object
                        newObject[objectKey] = objectValue;
                    }
                }
            }

            console.log(newObject);
            return newObject;
        },
        checkHourInRanges: function (hour, ranges) {
            const [hourValue] = hour.split(':').map(Number);
            
            for (const range of ranges) {
                const [start, end] = range.split('-').map(Number);
                if (hourValue >= start && hourValue <= end) {
                    return true;
                }
            }
            
            return false;
        },
        calculateRoutePrice: function (miles, passengers, carPrice, chosenOptions, pickupTime) {
            const self = this;

            var totalPrice = 0;
            var milesPrice = 0;
            var passengersPrice = 0;
            var adminFee = 0;
            var optionsPrice = 0;

            var trafficHoursPrice = 0;
            var isInTrafficHours = false;

            var pricePassengersGT4 = parseFloat(self.transformedConfigs['cfg-psr-gt-4']);
            var priceMilesLT30 = parseFloat(self.transformedConfigs['cfg-pr-ml']);
            var priceMilesGT30 = parseFloat(self.transformedConfigs['cfg-pr-ml-gt-30']);
            var priceAdmin = parseFloat(self.transformedConfigs['cfg-admin-fee']);
            var trafficHoursExtra = parseFloat(self.transformedConfigs['cfg-trffh-rate']);

            var nonTrafficHours = [];

            nonTrafficHours.push(
                self.transformedConfigs['cfg-rg-non-trfh-01'],
                self.transformedConfigs['cfg-rg-non-trfh-02'],
                self.transformedConfigs['cfg-rg-non-trfh-03']
            );

            isInTrafficHours = !self.checkHourInRanges(pickupTime, nonTrafficHours);

            var parsedCarPrice = parseFloat(carPrice);

            passengersPrice = passengers <= 4 ? parsedCarPrice : parsedCarPrice + ((passengers - 4) * pricePassengersGT4);
            milesPrice = miles <= 30 ? (priceMilesLT30 * miles) : (priceMilesLT30 * 30) + (priceMilesGT30 * (miles - 30));
            adminFee = priceAdmin * miles;
            
            if (chosenOptions.length > 0) {
                chosenOptions.forEach((option) => {
                    optionsPrice = optionsPrice + parseFloat(option.configValue);
                });
            }

            totalPrice = passengersPrice + milesPrice + adminFee + optionsPrice;

            if (isInTrafficHours) {
                trafficHoursPrice = totalPrice * (trafficHoursExtra / 100);
            }

            totalPrice = totalPrice + trafficHoursPrice;

            return totalPrice;
        },
        applyCoupon: function () {
            const self = this;

            if (_.isEmpty(self.coupon)) {
                self.showToastNotification(type = 'error', message = 'Invalid coupon');
                return;
            }

            var payload = {
                couponCode: self.coupon
            }

            axios
                .post(baseURL + '/api/coupons/validate', payload)
                .then(res => {
                    var toastType = res.data.result ? 'success' : 'error';
                    self.showToastNotification(toastType, res.data.message);

                    if (res.data.result) {
                        const couponObject = res.data.coupon;

                        self.form.bookingRequirements.review.appliedCoupons.push(couponObject);
                        self.coupon = null;
                    }
                })
                .catch(error => {
                    self.showToastNotification(type = 'error');
                });
        },
        calculateDiscountAmount: function (coupons, totalPrice) {
            const self = this;
            let discountAmount = 0;

            coupons.forEach(couponItem => {
                let coupon = _.isString(couponItem) ? JSON.parse(couponItem) : couponItem;

                if (coupon.couponIsPercentage === 'yes') {
                    discountAmount += totalPrice * (parseFloat(coupon.couponDiscountAmount) / 100);
                } else {
                    discountAmount += parseFloat(coupon.couponDiscountAmount);
                }
            });

            return discountAmount;
        },
    },
    computed: {
        errorMessageEmail: function () {
            if (!this.$v.form.bookingRequirements.review.customer.contact.email.required) {
                return this.errorMessages.required;
            }

            if (!this.$v.form.bookingRequirements.review.customer.contact.email.email) {
                return 'Invalid email address';
            }
        },
        errorMessagePassengers: function () {
            // if (!this.$v.form.bookingRequirements.passengers.required) {
            //     return this.errorMessages.required;
            // }

            // if (!this.$v.form.bookingRequirements.passengers.minValue) {
            //     return 'Number of passengers must be greater than 0';
            // }
        },
        pickingUpMapPreview: function () {
            const self = this;

            var markers = 'https://www.google.com/maps/embed/v1/directions?key=AIzaSyBEGGWz3KOsiPnxuygccrvKGBJEJgxih3s';

            if (
                !_.isNil(self.form.bookingRequirements.reservation.oneWayTrip.origin) && !_.isNil(self.form.bookingRequirements.reservation.oneWayTrip.destination) &&
                !_.isNil(self.form.bookingRequirements.reservation.oneWayTrip.origin.place_id) && !_.isNil(self.form.bookingRequirements.reservation.oneWayTrip.destination.place_id)
            ) {
                markers += '&origin=place_id:' + self.form.bookingRequirements.reservation.oneWayTrip.origin.place_id + '&destination=place_id:' + self.form.bookingRequirements.reservation.oneWayTrip.destination.place_id;
            } else {
                markers = 'https://www.google.com/maps/embed/v1/place?key=AIzaSyBEGGWz3KOsiPnxuygccrvKGBJEJgxih3s&q=United+States';
            }

            return markers;
        },
        returnMapPreview: function () {
            const self = this;

            var markers = 'https://www.google.com/maps/embed/v1/directions?key=AIzaSyBEGGWz3KOsiPnxuygccrvKGBJEJgxih3s';

            if (
                !_.isNil(self.form.bookingRequirements.reservation.roundTrip.origin) && !_.isNil(self.form.bookingRequirements.reservation.roundTrip.destination) &&
                !_.isNil(self.form.bookingRequirements.reservation.roundTrip.origin.place_id) && !_.isNil(self.form.bookingRequirements.reservation.roundTrip.destination.place_id)
            ) {
                markers += '&origin=place_id:' + self.form.bookingRequirements.reservation.roundTrip.origin.place_id + '&destination=place_id:' + self.form.bookingRequirements.reservation.roundTrip.destination.place_id;
            } else {
                markers = 'https://www.google.com/maps/embed/v1/place?key=AIzaSyBEGGWz3KOsiPnxuygccrvKGBJEJgxih3s&q=United+States';
            }

            return markers;
        },
        oneWayTripOrigin: function () {
            const self = this;
            return self.form.bookingRequirements.reservation.oneWayTrip.origin && self.form.bookingRequirements.reservation.oneWayTrip.origin.description ?
                self.form.bookingRequirements.reservation.oneWayTrip.origin.description :
                'Not provided';
        },
        oneWayTripDestination: function () {
            const self = this;
            return self.form.bookingRequirements.reservation.oneWayTrip.destination && self.form.bookingRequirements.reservation.oneWayTrip.destination.description ?
                self.form.bookingRequirements.reservation.oneWayTrip.destination.description :
                'Not provided';
        },
        oneWayTripRouteMiles: function () {
            const self = this;

            return self.form.bookingRequirements.review.routes.oneWayTrip.miles > 0 ?
                self.form.bookingRequirements.review.routes.oneWayTrip.miles + ' mile(s)' :
                'Not provided';
        },
        oneWayTripPickup: function () {
            const self = this;

            return self.form.bookingRequirements.reservation.oneWayTrip.pickup ?
                moment(
                    self.form.bookingRequirements.reservation.oneWayTrip.pickup.date + ' ' + self.form.bookingRequirements.reservation.oneWayTrip.pickup.time,
                    'YYYY-MM-DD hh:mm'
                ).format('LLLL') :
                'Not provided';
        },
        oneWayTripVehicle: function () {
            const self = this;

            const defaultImage = baseURL + '/static/images/vehicles/vehicle-placeholder.png';

            if (self.form.bookingRequirements.selectCar.oneWayTrip.vehicle) {
                return baseURL + '/static/images/vehicles/' + self.form.bookingRequirements.selectCar.oneWayTrip.vehicle.carImage;
            }

            return defaultImage;
        },
        roundTripPickup: function () {
            const self = this;

            return self.form.bookingRequirements.reservation.roundTrip.pickup ?
                moment(
                    self.form.bookingRequirements.reservation.roundTrip.pickup.date + ' ' + self.form.bookingRequirements.reservation.roundTrip.pickup.time,
                    'YYYY-MM-DD hh:mm'
                ).format('LLLL') :
                'Not provided';
        },
        roundTripOrigin: function () {
            const self = this;

            return self.form.bookingRequirements.reservation.roundTrip.origin && self.form.bookingRequirements.reservation.roundTrip.origin.description ?
                self.form.bookingRequirements.reservation.roundTrip.origin.description :
                'Not provided';
        },
        roundTripDestination: function () {
            const self = this;

            return self.form.bookingRequirements.reservation.roundTrip.destination && self.form.bookingRequirements.reservation.roundTrip.destination.description ?
                self.form.bookingRequirements.reservation.roundTrip.destination.description :
                'Not provided';
        },
        roundTripRouteMiles: function () {
            const self = this;

            return self.form.bookingRequirements.review.routes.roundTrip.miles > 0 ?
                self.form.bookingRequirements.review.routes.roundTrip.miles + ' mile(s)' :
                'Not provided';
        },
        roundTripVehicle: function () {
            const self = this;

            const defaultImage = baseURL + '/static/images/vehicles/vehicle-placeholder.png';

            if (self.form.bookingRequirements.selectCar.roundTrip.vehicle) {
                return baseURL + '/static/images/vehicles/' + self.form.bookingRequirements.selectCar.roundTrip.vehicle.carImage;
            }

            return defaultImage;
        },
        totalRoutesPrice: function () {
            const self = this;

            let price = 0;
            let discountAmount = 0;

            price += parseFloat(self.form.bookingRequirements.review.prices.oneWayTrip);


            if (self.form.bookingRequirements.reservation.tripType === 'round-trip') {
                price += parseFloat(self.form.bookingRequirements.review.prices.roundTrip);
            }

            if (self.form.bookingRequirements.review.appliedCoupons.length > 0) {
                discountAmount = self.calculateDiscountAmount(self.form.bookingRequirements.review.appliedCoupons, price);
            }

            self.form.bookingRequirements.review.prices.total = (price - discountAmount) <= 0 ? 0 : (price - discountAmount).toFixed(2);
            self.form.bookingRequirements.review.prices.totalNotDiscount = price.toFixed(2);
            self.form.bookingRequirements.review.prices.discountAmount = discountAmount.toFixed(2);

            let tipDriverAmount = self.form.bookingRequirements.review.prices.tipDriverAmount;
            if (tipDriverAmount) {
                let subTotal = self.form.bookingRequirements.review.prices.total;

                if (tipDriverAmount === 'other') {
                    let tipAmountOther = self.form.bookingRequirements.review.prices.tipDriverAmountOther;
                    self.form.bookingRequirements.review.prices.total = subTotal + tipAmountOther;
                } else {
                    self.form.bookingRequirements.review.prices.total = subTotal * tipDriverAmount;
                }
            }

            return self.form.bookingRequirements.review.prices.total;
        },
    },
    validations: {
        form: {
            bookingRequirements: {
                reservation: {
                    tripType: {
                        required: required,
                    },
                    oneWayTrip: {
                        pickup: {
                            date: {
                                required: required,
                            },
                            time: {
                                required: required,
                            },
                        },
                        origin: {
                            required: required,
                        },
                        destination: {
                            required: required,
                        },
                        originSearch: {},
                        destinationSearch: {},
                        passengers: {
                            required: required,
                            minValue: minValue(1),
                        },
                    },
                    roundTrip: {
                        pickup: {
                            date: {
                                requiredIf: requiredIf(function () {
                                    return this.form.bookingRequirements.reservation.tripType === 'round-trip';
                                })
                            },
                            time: {
                                requiredIf: requiredIf(function () {
                                    return this.form.bookingRequirements.reservation.tripType === 'round-trip';
                                })
                            },
                        },
                        origin: {
                            requiredIf: requiredIf(function () {
                                return this.form.bookingRequirements.reservation.tripType === 'round-trip';
                            })
                        },
                        destination: {
                            requiredIf: requiredIf(function () {
                                return this.form.bookingRequirements.reservation.tripType === 'round-trip';
                            })
                        },
                        originSearch: {},
                        destinationSearch: {},
                        passengers: {
                            requiredIf: requiredIf(function () {
                                return this.form.bookingRequirements.reservation.tripType === 'round-trip';
                            }),
                            minValue: function (value) {
                                if (!(this.form.bookingRequirements.reservation.tripType === 'round-trip')) {
                                    return this.skipValidation;
                                };

                                return parseInt(value) > 0;
                            },
                        },
                    },
                },
                selectCar: {
                    oneWayTrip: {
                        vehicle: {
                            required: required,
                        },
                    },
                    roundTrip: {
                        vehicle: {
                            requiredIf: requiredIf(function () {
                                return this.form.bookingRequirements.reservation.tripType === 'round-trip';
                            }),
                        },
                    },
                },
                chooseOptions: {
                    oneWayTrip: {
                        extras: {},
                        protection: {},
                    },
                    roundTrip: {
                        extras: {},
                        protection: {},
                    },
                },
                review: {
                    customer: {
                        firstName: {
                            required: required,
                        },
                        lastName: {
                            required: required,
                        },
                        contact: {
                            mobileNumber: {
                                required: required,
                            },
                            email: {
                                required: required,
                                email: email,
                            }
                        },
                    },
                    airline: {
                        brand: {},
                        flightNumber: {},
                    },
                    agreeTermsConditions: {
                        required: required,
                    },
                    appliedCoupons: {},
                    additionalNotes: {},
                    prices: {
                        tipDriverAmount: {},
                        tipDriverAmountOther: {
                            requiredIf: requiredIf(function() {
                                return this.form.bookingRequirements.review.prices.tipDriverAmount === 'other';
                            })
                        },
                    },
                },
            },
        },
    },
});