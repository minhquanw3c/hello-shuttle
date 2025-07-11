const { required, requiredIf, minLength, email, minValue } = window.validators;
const windowScope = window;
Vue.component('multiselect', window.VueMultiselect.default)

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
                accountId: null,
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
                            luggages: 0,
                            hasRestStop: null,
                            restStop: null,
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
                            luggages: 0,
                            hasRestStop: null,
                            restStop: null,
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
                            registerAccount: false,
                            account: {
                                sameAsContactEmail: false,
                                email: null,
                                password: null,
                                confirmPassword: null,
                            },
                        },
                        airline: {
                            brand: {
                                text: null,
                                value: null,
                            },
                            flightNumber: null,
                        },
                        routes: {
                            oneWayTrip: {
                                miles: 0,
                                milesFromBaseToPickup: 0,
                            },
                            roundTrip: {
                                miles: 0,
                                milesFromBaseToPickup: 0,
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
                            adminFee: {
                                oneWayTrip: 0,
                                roundTrip: 0
                            },
                            pickupFee: {
                                oneWayTrip: 0,
                                roundTrip: 0
                            },
                            luggages: {
                                oneWayTrip: {
                                    extras: 0,
                                    prices: 0,
                                },
                                roundTrip: {
                                    extras: 0,
                                    prices: 0,
                                },
                            },
                            passengers: {
                                oneWayTrip: {
                                    extras: 0,
                                    prices: 0,
                                },
                                roundTrip: {
                                    extras: 0,
                                    prices: 0,
                                },
                            },
                        },
                        agreeTermsConditions: null,
                        appliedCoupons: [],
                        additionalNotes: null,
                    },
                },
                loginForm: {
                    registeredAccount: {
                        email: null,
                        password: null,
                    },
                    hasRegistered: false,
                    errorMessages: [],
                },
            },
            errorMessages: {
                required: 'This field is required',
            },
            formActiveTabIndex: 0,
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
                oneWayTrip: {
                    extras: [],
                    protection: [],
                },
                roundTrip: {
                    extras: [],
                    protection: [],
                },
            },
            airlineBrands: [
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
                    restStop: {
                        show: false,
                        sessionToken: null,
                    },
                    origins: [],
                    destinations: [],
                    restStops: [],
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
                    restStop: {
                        show: false,
                        sessionToken: null,
                    },
                    origins: [],
                    destinations: [],
                    restStops: [],
                },
            },
            coupon: null,
            skipValidation: true,
            showCheckoutNotice: false,
            tipDriverOptions: [
                {
                    text: 'None',
                    value: null,
                },
                {
                    text: '20%',
                    value: 0.2,
                },
                {
                    text: '25%',
                    value: 0.25,
                },
                {
                    text: '30%',
                    value: 0.3,
                },
                {
                    text: 'Other',
                    value: 'other',
                },
            ],
            modals: {
                loginForm: {
                    show: false,
                },
            },
            alerts: {
                emailAlreadyExisted: {
                    show: false,
                }
            },
        }
    },
    mounted: async function () {
        const self = this;
        console.log('app mounted');

        self.form.bookingId = bookingId;
        self.getOptionsList();
        self.scrollToFormSteps();

        setTimeout(() => {
            self.dropdowns.oneWayTrip.origin.sessionToken = self.generateSearchSessionToken();
            self.dropdowns.oneWayTrip.destination.sessionToken = self.generateSearchSessionToken();
            self.dropdowns.oneWayTrip.restStop.sessionToken = self.generateSearchSessionToken();

            self.dropdowns.roundTrip.origin.sessionToken = self.generateSearchSessionToken();
            self.dropdowns.roundTrip.destination.sessionToken = self.generateSearchSessionToken();
            self.dropdowns.roundTrip.restStop.sessionToken = self.generateSearchSessionToken();
        }, 2000);

        if (window.location.origin === 'http://localhost' && env === 'development') {
            self.form.bookingRequirements = formDataRoundTrip;
            self.form.loginForm = loginForm;
        }
    },
    methods: {
        increasePassengers: function (tripType, maxPassengers = 20) {
            const self = this;
            let passengers = self.form.bookingRequirements.reservation[tripType].passengers;

            if (passengers < maxPassengers) {
                self.form.bookingRequirements.reservation[tripType].passengers++;
            }
        },
        increaseLuggages: function (tripType, maxLuggages = 40) {
            const self = this;
            let luggages = self.form.bookingRequirements.reservation[tripType].luggages;

            if (luggages < maxLuggages) {
                self.form.bookingRequirements.reservation[tripType].luggages++;
            }
        },
        decreaseLuggages: function (tripType) {
            const self = this;
            let luggages = self.form.bookingRequirements.reservation[tripType].luggages;

            if (luggages >= 1) {
                self.form.bookingRequirements.reservation[tripType].luggages--;
            }
        },
        decreasePassengers: function (tripType) {
            const self = this;
            let passengers = self.form.bookingRequirements.reservation[tripType].passengers;

            if (passengers >= 1) {
                self.form.bookingRequirements.reservation[tripType].passengers--;
            }
        },
        generateSearchSessionToken: function () {
            const self = this;

            const uniqueString = new windowScope.google.maps.places.AutocompleteSessionToken;

            return uniqueString;
        },
        updateSearchResult: function (location, tripType, placeType) {
            const self = this;

            self.form.bookingRequirements.reservation[tripType][placeType] = location;
            // self.form.bookingRequirements.reservation[tripType][placeType + 'Search'] = location.description;
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
                    // alert(status);
                    return;
                }

                if (tripType === 'oneWayTrip') {
                    if (placeType === 'origin') {
                        self.dropdowns.oneWayTrip.origins = predictions;
                    }

                    if (placeType === 'destination') {
                        self.dropdowns.oneWayTrip.destinations = predictions;
                    }

                    if (placeType === 'restStop') {
                        self.dropdowns.oneWayTrip.restStops = predictions;
                    }
                }

                if (tripType === 'roundTrip') {
                    if (placeType === 'origin') {
                        self.dropdowns.roundTrip.origins = predictions;
                    }

                    if (placeType === 'destination') {
                        self.dropdowns.roundTrip.destinations = predictions;
                    }

                    if (placeType === 'restStop') {
                        self.dropdowns.roundTrip.restStops = predictions;
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
        saveReservation: async function () {
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
            self.getAvailableCars();

            let tripType = self.form.bookingRequirements.reservation.tripType;

            let oneWayTripData = self.form.bookingRequirements.reservation.oneWayTrip;
            self.form.bookingRequirements.review.routes.oneWayTrip.miles = await self.fetchRoutesData(oneWayTripData);

            let oneWayTripPickup = {
                origin: {
                    place_id: self.transformedConfigs['cfg-base-location']
                },
                destination: {
                    place_id: oneWayTripData.origin.place_id
                }
            };
            self.form.bookingRequirements.review.routes.oneWayTrip.milesFromBaseToPickup = await self.fetchRoutesData(oneWayTripPickup);

            if (tripType === 'round-trip') {
                let roundTripData = self.form.bookingRequirements.reservation.roundTrip;
                let roundTripPickup = {
                    origin: {
                        place_id: self.transformedConfigs['cfg-base-location']
                    },
                    destination: {
                        place_id: roundTripData.origin.place_id
                    }
                };

                self.form.bookingRequirements.review.routes.roundTrip.milesFromBaseToPickup = await self.fetchRoutesData(roundTripPickup);
                self.form.bookingRequirements.review.routes.roundTrip.miles = await self.fetchRoutesData(roundTripData);
            }

            setTimeout(() => {
                self.formActiveTabIndex = 1;
                self.scrollToFormSteps();
            }, 500);
        },
        getAvailableCars: function () {
            const self = this;

            var payload = {
                form: { ...self.form.bookingRequirements.reservation }
            }

            axios
                .post(baseURL + '/api/car/list', payload)
                .then(res => {
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

            setTimeout(() => {
                self.formActiveTabIndex = 2;
                self.scrollToFormSteps();
            }, 500);
        },
        getOptionsList: function () {
            const self = this;

            var payload = {}

            axios
                .get(baseURL + '/api/configurations/list', payload)
                .then(res => {

                    self.options.oneWayTrip.extras = _.map(
                        _.filter(res.data.configs, (option) => { return option.configGroupId === 'cfg-gr-opt' }),
                        (option) => { return {...option, quantity: 1} }
                    );

                    self.options.roundTrip.extras = _.map(
                        _.filter(res.data.configs, (option) => { return option.configGroupId === 'cfg-gr-opt' }),
                        (option) => { return {...option, quantity: 1} }
                    );

                    self.options.oneWayTrip.protection = _.map(
                        _.filter(res.data.configs, (option) => { return option.configGroupId === 'cfg-gr-prt' }),
                        (option) => { return {...option, quantity: 1} }
                    );

                    self.options.roundTrip.protection = _.map(
                        _.filter(res.data.configs, (option) => { return option.configGroupId === 'cfg-gr-prt' }),
                        (option) => { return {...option, quantity: 1} }
                    );

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
                self.formActiveTabIndex = 3;
                self.scrollToFormSteps();
            }, 500);
        },
        submitBooking: async function () {
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

            let customerData = self.form.bookingRequirements.review.customer;
            if (customerData.registerAccount) {
                let emailPayload = {
                    email: customerData.account.email
                };

                await axios
                    .post(baseURL + '/api/email/validate', emailPayload)
                    .then(res => {
                        self.alerts.emailAlreadyExisted.show = !res.data.result;
                    })
                    .catch(error => {
                        console.log(error);
                    });

                if (self.alerts.emailAlreadyExisted.show) {
                    self.scrollToInvalidFields();
                    return;
                }
            }

            self.showCheckoutNotice = true;

            var payload = {
                form: { ...self.form }
            }

            axios
                .post(baseURL + '/api/booking/save', payload)
                .then(res => {
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

            var invalidFields = $(
                '.tab-content .tab-pane.active form .form-group.is-invalid .d-block.invalid-feedback,' +
                '.tab-content .tab-pane.active form .alert.alert-danger'
            );

            if (invalidFields.length > 0) {
                invalidFields[0].scrollIntoView({
                    behavior: 'smooth',
                    block: 'center',
                });
            }
        },
        scrollToFormSteps: function() {
            const self = this;

            setTimeout(function() {
                let formSteps = $('#form-steps');
                formSteps[0].scrollIntoView({
                    behavior: 'smooth',
                    block: 'start',
                });
            }, 500);
        },
        fetchRoutesData: async function (routeData) {
            const self = this;

            const routeUrlAPI = 'https://routes.googleapis.com/directions/v2:computeRoutes?key=' + apiKey;
            const oneMeterPerMile = 0.000621371;

            let routeMiles = 0;
            let routeHasRestStop = routeData.hasRestStop && routeData.hasRestStop === '1';

            let payload = {
                origin: {
                    placeId: routeData.origin.place_id
                },
                destination: {
                    placeId: routeData.destination.place_id
                },
                travelMode: "DRIVE",
                computeAlternativeRoutes: false,
                languageCode: "en-US",
                units: "IMPERIAL",
            };

            if (routeHasRestStop) {
                payload.intermediates = [
                    {
                        placeId: routeData.restStop.place_id
                    }
                ];
            }

            await axios
                .post(
                    routeUrlAPI,
                    payload,
                    {
                        headers: {
                            'X-Goog-FieldMask': 'routes.distanceMeters'
                        }
                    }
                )
                .then((res) => {
                    if (res.data.routes) {
                        routeMiles = res.data.routes[0].distanceMeters;
                    }
                })
                .catch((err) => {
                    console.log(err);
                });

            return parseFloat((oneMeterPerMile * parseFloat(routeMiles)).toFixed(0));
        },
        computeRoutes: function () {
            const self = this;

            let tripData = self.form.bookingRequirements;
            var tripType = tripData.reservation.tripType;

            let oneWayTrip = {};

            oneWayTrip.routeMiles = tripData.review.routes.oneWayTrip.miles;
            oneWayTrip.passengers = tripData.reservation.oneWayTrip.passengers;
            oneWayTrip.packages = tripData.reservation.oneWayTrip.luggages;
            oneWayTrip.chosenOptions = [...tripData.chooseOptions.oneWayTrip.extras, ...tripData.chooseOptions.oneWayTrip.protection];
            oneWayTrip.pickupTime = tripData.reservation.oneWayTrip.pickup.time;
            oneWayTrip.carConfig = tripData.selectCar.oneWayTrip.vehicle;
            oneWayTrip.milesFromBaseToPickup = tripData.review.routes.oneWayTrip.milesFromBaseToPickup;

            self.form.bookingRequirements.review.prices.oneWayTrip = self.calculateRoutePrice(
                oneWayTrip.routeMiles,
                oneWayTrip.passengers,
                oneWayTrip.packages,
                oneWayTrip.chosenOptions,
                oneWayTrip.pickupTime,
                oneWayTrip.carConfig,
                'oneWayTrip',
                oneWayTrip.milesFromBaseToPickup
            );

            if (tripType === 'round-trip') {
                let roundTrip = {};

                roundTrip.routeMiles = tripData.review.routes.roundTrip.miles;
                roundTrip.passengers = tripData.reservation.roundTrip.passengers;
                roundTrip.packages = tripData.reservation.roundTrip.luggages;
                roundTrip.chosenOptions = [...tripData.chooseOptions.roundTrip.extras, ...tripData.chooseOptions.roundTrip.protection];
                roundTrip.pickupTime = tripData.reservation.roundTrip.pickup.time;
                roundTrip.carConfig = tripData.selectCar.roundTrip.vehicle;
                roundTrip.milesFromBaseToPickup = tripData.review.routes.roundTrip.milesFromBaseToPickup;

                self.form.bookingRequirements.review.prices.roundTrip = self.calculateRoutePrice(
                    roundTrip.routeMiles,
                    roundTrip.passengers,
                    roundTrip.packages,
                    roundTrip.chosenOptions,
                    roundTrip.pickupTime,
                    roundTrip.carConfig,
                    'roundTrip',
                    roundTrip.milesFromBaseToPickup
                );
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
        calculateMilesPrice: function (config, miles) {
            const self = this;
            let price = 0;
            let routeMiles = parseFloat(miles);

            if (config.firstMilesPriceActive && routeMiles > 0) {
                const firstMiles = parseFloat(config.firstMiles);
                const firstMilesPrice = parseFloat(config.firstMilesPrice);

                price += (firstMilesPrice * (routeMiles >= firstMiles ? firstMiles : routeMiles));
                routeMiles -= firstMiles;
            }

            if (config.secondMilesPriceActive && routeMiles > 0) {
                const secondMiles = parseFloat(config.secondMiles);
                const secondMilesPrice = parseFloat(config.secondMilesPrice);

                price += (secondMilesPrice * (routeMiles >= secondMiles ? secondMiles : routeMiles));
                routeMiles -= secondMiles;
            }

            if (config.thirdMilesPriceActive && routeMiles > 0) {
                const thirdMiles = parseFloat(config.thirdMiles);
                const thirdMilesPrice = parseFloat(config.thirdMilesPrice);

                price += (thirdMilesPrice * routeMiles);
                routeMiles -= thirdMiles;
            }

            return price;
        },
        calculateAdminFee: function (config, miles, totalPrice, tripType) {
            const self = this;

            let price = 0;
            let routeMiles = parseFloat(miles);
            let routePrice = parseFloat(totalPrice);

            if (config.adminFeeActive && (routeMiles <= parseFloat(config.adminFeeLimitMiles))) {
                price += config.adminFeeType === 'fixed' ? 
                        parseFloat(config.adminFeeFixedAmount) : 
                        (routePrice * (parseFloat(config.adminFeePercentage) / 100));
            }

            price = parseFloat(price.toFixed(2));

            self.form.bookingRequirements.review.prices.adminFee[tripType] = price;

            return price;
        },
        calculatePickupFee: function (config, milesFromBaseToPickup, totalPrice, tripType) {
            const self = this;

            let price = 0;
            let routeMiles = parseFloat(milesFromBaseToPickup);
            let routePrice = parseFloat(totalPrice);

            if (config.pickupFeeActive && (routeMiles > parseFloat(config.pickupFeeLimitMiles))) {
                price += config.pickupFeeType === 'fixed' ? 
                        parseFloat(config.pickupFeeFixedAmount) : 
                        (routePrice * (parseFloat(config.pickupFeePercentage) / 100));
            }

            price = parseFloat(price.toFixed(2));

            self.form.bookingRequirements.review.prices.pickupFee[tripType] = price;

            return price;
        },
        calculatePackagesPrice: function (config, passengers, packages) {
            const self = this;

            let price = 0;
            let totalPackages = parseInt(packages);
            let freePackages = parseInt(config.freeLuggagesQuantity);
            
            // if (totalPackages > freePackages) {
            if (totalPackages > passengers) {
                let exceedAmount = totalPackages - passengers;
                price += (exceedAmount * parseFloat(config.extraLuggagesPrice));
            }

            return price;
        },
        calculatePassengersPrice: function (config, passengers) {
            const self = this;

            let price = 0;
            let totalPassengers = parseInt(passengers);
            let freePassengers = parseInt(config.freePassengersQuantity);
            
            if (totalPassengers > freePassengers) {
                let exceedAmount = totalPassengers - freePassengers;
                price += (exceedAmount * parseFloat(config.extraPassengersPrice));
            }

            return price;
        },
        calculateRoutePrice: function (miles, passengers, packages, chosenOptions, pickupTime, carConfig, tripType, milesFromBaseToPickup) {
            const self = this;

            let totalPrice = 0;
            let milesPrice = 0;
            let openDoorPrice = parseFloat(carConfig.openDoorPrice);
            let adminFee = 0;
            let optionsPrice = 0;
            let packagesPrice = 0;
            let passengersPrice = 0;
            let pickupFee = 0;

            let trafficHoursPrice = 0;
            let isInTrafficHours = false;

            let nonTrafficHours = [];

            nonTrafficHours.push(
                self.transformedConfigs['cfg-rg-non-trfh-01'],
                self.transformedConfigs['cfg-rg-non-trfh-02'],
                self.transformedConfigs['cfg-rg-non-trfh-03']
            );

            isInTrafficHours = !self.checkHourInRanges(pickupTime, nonTrafficHours);

            milesPrice += self.calculateMilesPrice(carConfig, miles);
            packagesPrice += self.calculatePackagesPrice(carConfig, passengers, packages);
            
            if (chosenOptions.length > 0) {
                chosenOptions.forEach((option) => {
                    optionsPrice = optionsPrice + (parseFloat(option.configValue) * parseFloat(option.quantity));
                });
            }

            passengersPrice = self.calculatePassengersPrice(carConfig, passengers);
            
            totalPrice = openDoorPrice + milesPrice + optionsPrice + packagesPrice + passengersPrice;

            if (isInTrafficHours) {
                let trafficHoursExtra = self.transformedConfigs['cfg-trffh-rate'];

                trafficHoursPrice = totalPrice * (trafficHoursExtra / 100);
            }

            adminFee = self.calculateAdminFee(carConfig, miles, totalPrice, tripType);
            pickupFee = self.calculatePickupFee(carConfig, milesFromBaseToPickup, totalPrice, tripType);

            totalPrice = parseFloat(totalPrice + adminFee + pickupFee + trafficHoursPrice);

            return totalPrice.toFixed(2);
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
        toggleAccountLoginForm: function (flag) {
            const self = this;

            if (!flag) { self.$v.form.loginForm.$reset(); }

            self.modals.loginForm.show = flag;
            self.form.loginForm.hasRegistered = flag;
        },
        getRegisteredCustomerData: function () {
            const self = this;

            self.$v.form.loginForm.$touch();
            let loginFormValidity = !self.$v.form.loginForm.$invalid;

            if (loginFormValidity) {
                let payload = {
                    form: {
                        email: self.form.loginForm.registeredAccount.email,
                        password: self.form.loginForm.registeredAccount.password,
                    }
                };

                axios
                    .post(baseURL + '/api/user/get', payload)
                    .then(res => {
                        if (!res.data.result) {
                            self.form.loginForm.errorMessages = res.data.errorMessages;
                        } else {
                            let data = res.data.user;

                            self.form.accountId = data.accountId;
                            self.form.bookingRequirements.review.customer.firstName = data.firstName;
                            self.form.bookingRequirements.review.customer.lastName = data.lastName;
                            self.form.bookingRequirements.review.customer.contact.email = data.email;
                            self.form.bookingRequirements.review.customer.contact.mobileNumber = data.phone;

                            self.modals.loginForm.show = false;
                            self.form.loginForm.hasRegistered = true;
                        }
                    })
                    .catch(error => {
                        self.showToastNotification(type = 'error');
                    });
            }
        },
        toggleRegisterAccountEmail: function (val) {
            const self = this;
            let customerData = self.form.bookingRequirements.review.customer;

            if (val) {
                customerData.account.email = customerData.contact.email;
            }
        },
        populateRegisterAccountEmail: function (val) {
            const self = this;
            let customerData = self.form.bookingRequirements.review.customer;

            if (customerData.registerAccount && customerData.account.sameAsContactEmail) {
                customerData.account.email = val;
            }
        },
        formatCurrency: function (value) {
            return new Intl.NumberFormat(
                    'en-US',
                    {
                        style: 'currency',
                        currency: 'USD'
                    }
                )
                .format(value);
        }
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

            var markers = 'https://www.google.com/maps/embed/v1/directions?key=' + apiKey;
            let oneWayTrip = self.form.bookingRequirements.reservation.oneWayTrip;

            if (
                !_.isNil(oneWayTrip.origin) && !_.isNil(oneWayTrip.destination) &&
                !_.isNil(oneWayTrip.origin.place_id) && !_.isNil(oneWayTrip.destination.place_id)
            ) {
                markers += '&origin=place_id:' + oneWayTrip.origin.place_id + '&destination=place_id:' + oneWayTrip.destination.place_id;
                
                if (
                    oneWayTrip.hasRestStop === '1' &&
                    !_.isNil(oneWayTrip.restStop) &&
                    !_.isNil(oneWayTrip.restStop.place_id)
                ) {
                    markers += '&waypoints=place_id:' + oneWayTrip.restStop.place_id;
                }
            } else {
                markers = 'https://www.google.com/maps/embed/v1/place?key=' + apiKey + '&q=United+States';
            }

            return markers;
        },
        returnMapPreview: function () {
            const self = this;

            var markers = 'https://www.google.com/maps/embed/v1/directions?key=' + apiKey;
            let roundTrip = self.form.bookingRequirements.reservation.roundTrip;

            if (
                !_.isNil(roundTrip.origin) && !_.isNil(roundTrip.destination) &&
                !_.isNil(roundTrip.origin.place_id) && !_.isNil(roundTrip.destination.place_id)
            ) {
                markers += '&origin=place_id:' + roundTrip.origin.place_id + '&destination=place_id:' + roundTrip.destination.place_id;
                
                if (
                    roundTrip.hasRestStop === '1' &&
                    !_.isNil(roundTrip.restStop) &&
                    !_.isNil(roundTrip.restStop.place_id)
                ) {
                    markers += '&waypoints=place_id:' + roundTrip.restStop.place_id;
                }
            } else {
                markers = 'https://www.google.com/maps/embed/v1/place?key=' + apiKey + '&q=United+States';
            }

            return markers;
        },
        oneWayTripOrigin: function () {
            const self = this;
            let oneWayTrip = self.form.bookingRequirements.reservation.oneWayTrip;

            return oneWayTrip.origin && oneWayTrip.origin.description ?
                oneWayTrip.origin.description :
                'Not provided';
        },
        oneWayTripRestStop: function () {
            const self = this;
            let oneWayTrip = self.form.bookingRequirements.reservation.oneWayTrip;

            return oneWayTrip.hasRestStop && oneWayTrip.restStop ?
                oneWayTrip.restStop.description :
                'Not provided';
        },
        oneWayTripDestination: function () {
            const self = this;
            let oneWayTrip = self.form.bookingRequirements.reservation.oneWayTrip;

            return oneWayTrip.destination && oneWayTrip.destination.description ?
                oneWayTrip.destination.description :
                'Not provided';
        },
        oneWayTripRouteMiles: function () {
            const self = this;

            return self.form.bookingRequirements.review.routes.oneWayTrip.miles > 0 ?
                self.form.bookingRequirements.review.routes.oneWayTrip.miles + ' miles' :
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
        roundTripRestStop: function () {
            const self = this;
            let roundTrip = self.form.bookingRequirements.reservation.roundTrip;

            return roundTrip.hasRestStop && roundTrip.restStop ?
                roundTrip.restStop.description :
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
                self.form.bookingRequirements.review.routes.roundTrip.miles + ' miles' :
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

            price = _.add(price, parseFloat(self.form.bookingRequirements.review.prices.oneWayTrip));


            if (self.form.bookingRequirements.reservation.tripType === 'round-trip') {
                price = _.add(price, parseFloat(self.form.bookingRequirements.review.prices.roundTrip));
            }

            if (self.form.bookingRequirements.review.appliedCoupons.length > 0) {
                discountAmount = self.calculateDiscountAmount(self.form.bookingRequirements.review.appliedCoupons, price);
            }

            self.form.bookingRequirements.review.prices.total = parseFloat(price - discountAmount) <= 0 ? 0 : parseFloat(price - discountAmount);
            self.form.bookingRequirements.review.prices.totalNotDiscount = parseFloat(price).toFixed(2);
            self.form.bookingRequirements.review.prices.discountAmount = discountAmount;

            let tipDriverAmount = self.form.bookingRequirements.review.prices.tipDriverAmount;
            if (tipDriverAmount) {
                let subTotal = parseFloat(self.form.bookingRequirements.review.prices.total);

                if (tipDriverAmount === 'other') {
                    let tipAmountOther = self.form.bookingRequirements.review.prices.tipDriverAmountOther;
                    tipAmountOther = tipAmountOther ? parseFloat(tipAmountOther) : 0;
                    self.form.bookingRequirements.review.prices.total = _.add(subTotal, tipAmountOther);
                } else {
                    self.form.bookingRequirements.review.prices.total = _.add(subTotal, (subTotal * tipDriverAmount));
                }
            }

            let finalPrice = parseFloat(self.form.bookingRequirements.review.prices.total).toFixed(2);
            self.form.bookingRequirements.review.prices.total = finalPrice;

            return finalPrice;
        },
        extraLuggages: function () {
            const self = this;

            let oneWayTripLuggages = self.form.bookingRequirements.reservation.oneWayTrip.luggages;
            let roundTripLuggages = self.form.bookingRequirements.reservation.roundTrip.luggages;

            let oneWayTripVehicleConfig = self.form.bookingRequirements.selectCar.oneWayTrip.vehicle;
            let roundTripVehicleConfig = self.form.bookingRequirements.selectCar.roundTrip.vehicle;

            let oneWayTripPassengers = self.form.bookingRequirements.reservation.oneWayTrip.passengers;
            let roundTripPassengers = self.form.bookingRequirements.reservation.roundTrip.passengers;

            let luggages = {
                oneWayTrip: {
                    free: oneWayTripPassengers >= oneWayTripLuggages ? oneWayTripLuggages : oneWayTripPassengers,
                    extras: oneWayTripPassengers >= oneWayTripLuggages ? 0 : oneWayTripLuggages - oneWayTripPassengers,
                    extrasPrice: oneWayTripPassengers >= oneWayTripLuggages ? 0 : self.calculatePackagesPrice(oneWayTripVehicleConfig, oneWayTripPassengers, oneWayTripLuggages),
                },
                roundTrip: {
                    // free: !_.isNil(roundTripVehicleConfig) && self.isRoundTrip ? roundTripVehicleConfig.freeLuggagesQuantity : 0,
                    // extras: !_.isNil(roundTripVehicleConfig) && self.isRoundTrip ? 
                    //     (
                    //         (parseInt(roundTripVehicleConfig.freeLuggagesQuantity) - parseInt(roundTripLuggages)) < 0 ?
                    //         Math.abs(parseInt(roundTripVehicleConfig.freeLuggagesQuantity) - parseInt(roundTripLuggages)) :
                    //         0
                    //     ) : 0,
                    // extrasPrice: !_.isNil(roundTripVehicleConfig) && self.isRoundTrip ? 
                    //     (
                    //         self.calculatePackagesPrice(roundTripVehicleConfig, null, roundTripLuggages)
                    //     ) : 0,
                    free: self.isRoundTrip ? roundTripPassengers >= roundTripLuggages ? roundTripLuggages : roundTripPassengers : 0,
                    extras: self.isRoundTrip ? roundTripPassengers >= roundTripLuggages ? 0 : roundTripLuggages - roundTripPassengers : 0,
                    extrasPrice: self.isRoundTrip ? roundTripPassengers >= roundTripLuggages ? 0 : self.calculatePackagesPrice(roundTripVehicleConfig, roundTripPassengers, roundTripLuggages) : 0,
                }
            };

            // Update free-extras for passengers and luggages
            self.form.bookingRequirements.review.prices.luggages.oneWayTrip.free = luggages.oneWayTrip.free;
            self.form.bookingRequirements.review.prices.luggages.oneWayTrip.extras = luggages.oneWayTrip.extras;
            self.form.bookingRequirements.review.prices.luggages.oneWayTrip.prices = luggages.oneWayTrip.extrasPrice;

            self.form.bookingRequirements.review.prices.luggages.roundTrip.free = luggages.roundTrip.free;
            self.form.bookingRequirements.review.prices.luggages.roundTrip.extras = luggages.roundTrip.extras;
            self.form.bookingRequirements.review.prices.luggages.roundTrip.prices = luggages.roundTrip.extrasPrice;

            return luggages;
        },
        extraPassengers: function () {
            const self = this;

            let oneWayTripPassengers = self.form.bookingRequirements.reservation.oneWayTrip.passengers;
            let roundTripPassengers = self.form.bookingRequirements.reservation.roundTrip.passengers;

            let oneWayTripVehicleConfig = self.form.bookingRequirements.selectCar.oneWayTrip.vehicle;
            let roundTripVehicleConfig = self.form.bookingRequirements.selectCar.roundTrip.vehicle;

            let passengers = {
                oneWayTrip: {
                    extras: !_.isNil(oneWayTripVehicleConfig) ? 
                        (
                            (parseInt(oneWayTripVehicleConfig.freePassengersQuantity) - parseInt(oneWayTripPassengers)) < 0 ?
                            Math.abs(parseInt(oneWayTripVehicleConfig.freePassengersQuantity) - parseInt(oneWayTripPassengers)) :
                            0
                        ) : 0,
                    extrasPrice: !_.isNil(oneWayTripVehicleConfig) ? 
                        (
                            self.calculatePassengersPrice(oneWayTripVehicleConfig, null, oneWayTripPassengers)
                        ) : 0,
                },
                roundTrip: {
                    extras: !_.isNil(roundTripVehicleConfig) && self.isRoundTrip ? 
                        (
                            (parseInt(roundTripVehicleConfig.freePassengersQuantity) - parseInt(roundTripPassengers)) < 0 ?
                            Math.abs(parseInt(roundTripVehicleConfig.freePassengersQuantity) - parseInt(roundTripPassengers)) :
                            0
                        ) : 0,
                    extrasPrice: !_.isNil(roundTripVehicleConfig) && self.isRoundTrip ? 
                        (
                            self.calculatePassengersPrice(roundTripVehicleConfig, null, roundTripPassengers)
                        ) : 0,
                }
            };

            // Update extras for passengers and passengers
            self.form.bookingRequirements.review.prices.passengers.oneWayTrip.extras = passengers.oneWayTrip.extras;
            self.form.bookingRequirements.review.prices.passengers.oneWayTrip.prices = passengers.oneWayTrip.extrasPrice;

            self.form.bookingRequirements.review.prices.passengers.roundTrip.extras = passengers.roundTrip.extras;
            self.form.bookingRequirements.review.prices.passengers.roundTrip.prices = passengers.roundTrip.extrasPrice;

            return passengers;
        },
        isRoundTrip: function () {
            const self = this;

            let isRoundTrip = self.form.bookingRequirements.reservation.tripType === 'round-trip';

            return isRoundTrip;
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
                        luggages: {},
                        hasRestStop: {},
                        restStop: {
                            requiredIf: requiredIf(function() {
                                return this.form.bookingRequirements.reservation.oneWayTrip.hasRestStop === '1';
                            })
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
                        luggages: {},
                        hasRestStop: {},
                        restStop: {
                            requiredIf: requiredIf(function () {
                                return this.form.bookingRequirements.reservation.tripType === 'round-trip'
                                        && this.form.bookingRequirements.reservation.roundTrip.hasRestStop === '1';
                            }),
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
                        registerAccount: {},
                        account: {
                            sameAsContactEmail: {},
                            email: {
                                requiredIf: validators.requiredIf(function() {
                                    let customerData = this.form.bookingRequirements.review.customer;
                                    return customerData.registerAccount === true;
                                }),
                            },
                            password: {
                                requiredIf: validators.requiredIf(function() {
                                    let customerData = this.form.bookingRequirements.review.customer;
                                    return customerData.registerAccount === true;
                                }),
                            },
                            confirmPassword: {
                                requiredIf: validators.requiredIf(function() {
                                    let customerData = this.form.bookingRequirements.review.customer;
                                    return customerData.registerAccount === true;
                                }),
                                sameAsPassword: function(val) {
                                    let customerData = this.form.bookingRequirements.review.customer;
                                    let skipValidation = true;

                                    return customerData.registerAccount === true ? val === customerData.account.password : skipValidation;
                                }
                            },
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
            loginForm: {
                hasRegistered: {

                },
                registeredAccount: {
                    email: {
                        requiredIf: validators.requiredIf(function() {
                            return this.form.loginForm.hasRegistered === true;
                        }),
                    },
                    password: {
                        requiredIf: validators.requiredIf(function() {
                            return this.form.loginForm.hasRegistered === true;
                        }),
                    },
                },
            }
        },
    },
});