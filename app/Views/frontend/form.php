<?= $this->extend("templates/base_layout") ?>

<?= $this->section("main-content") ?>
    <!-- SLIDER AREA START (slider-4) -->
    <div class="ltn__slider-area ltn__slider-4 ">
        <div class="ltn__slide-one-active----- slick-slide-arrow-1----- slick-slide-dots-1----- arrow-white----- ltn__slide-animation-active">
            <!-- ltn__slide-item -->
            <div class="ltn__slide-item ltn__slide-item-2 ltn__slide-item-4 text-color-white bg-image" data-bg="<?= base_url('static/images/backgrounds/bg-001.jpg') ?>">
                <div class="ltn__slide-item-inner text-center">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12 align-self-center">
                                <div class="slide-item-info">
                                    <div class="slide-item-info-inner ltn__slide-animation">
                                        <!-- <h1 class="slide-title animated ">Meet the best in<br>quality, safety, and professionalism</h1> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- SLIDER AREA END -->

    <div class="ltn__car-dealer-form-area" id="main-app" v-cloak>
        <b-overlay fixed no-wrap :show="showCheckoutNotice" z-index="1000" variant="dark">
            <template #overlay>
                <div class="card">
                    <div class="card-header">Notes</div>
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <b-spinner label="Loading"></b-spinner>
                            <p class="mb-0 ml-2">We are processing your booking...</p>
                        </div>
                        <ul class="line-height-normal">
                            <li>You will be redirected to Stripe payment gateway shortly.</li>
                            <li>In case you accidentally close the window, we have sent an email to provided email address that contains payment link.</li>
                            <li class="text-danger">After the payment is completed, do not close the window, you will be redirected to the confirmation screen afterward. And a receipt will be sent to your mailbox.</li>
                            <li>You can also cancel the booking using the link in the receipt email.</li>
                        </ul>
                    </div>
                </div>
            </template>
        </b-overlay>
        <div class="container-md">
            <div class="row">
                <div class="col-lg-12">
                    <b-tabs class="danny--form-step" nav-class="mb-4 danny--nav-tabs" v-model="formActiveTab">
                        <!-- reservation -->
                        <b-tab>
                            <template #title>
                                <span>1.</span> <span class="tab-heading">Make a reservation</span>
                            </template>

                            <b-form @submit.prevent="saveReservation" novalidate>
                                <section>
                                    <div class="row">
                                        <div class="col-12 text-center mb-1">
                                            <p class="text-danger m-0">10% Off On Roundtrip</p>
                                        </div>

                                        <div class="col-12 text-center">
                                            <b-form-group
                                                :state="validateInputField($v.form.bookingRequirements.reservation.tripType)"
                                                :invalid-feedback="errorMessages.required">
                                                <b-form-radio-group
                                                    :options="tripTypes"
                                                    text-field="text"
                                                    value-field="value"
                                                    v-model="$v.form.bookingRequirements.reservation.tripType.$model"
                                                    buttons
                                                    button-variant="outline-primary">
                                                </b-form-radio-group>
                                            </b-form-group>

                                            <!-- <b-form-group
                                                label="How many luggages do you have?"
                                                :state="validateInputField($v.form.bookingRequirements.reservation.luggagesCount)"
                                                :invalid-feedback="errorMessages.required"
                                                description="Type 0 if you have no luggages.">
                                                <b-form-input
                                                    min="0"
                                                    type="number"
                                                    v-model="$v.form.bookingRequirements.reservation.luggagesCount.$model">
                                                </b-form-input>
                                            </b-form-group> -->
                                        </div>
                                    </div>
                                </section>

                                <template v-if="form.bookingRequirements.reservation.tripType">
                                    <!-- First Origin -->
                                    <section>
                                        <div class="row">
                                            <div class="col-12">
                                                <iframe
                                                    width="100%"
                                                    height="300"
                                                    frameborder="0"
                                                    style="border:0"
                                                    referrerpolicy="no-referrer-when-downgrade"
                                                    :src="pickingUpMapPreview"
                                                    allowfullscreen>
                                                </iframe>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <h5 class="danny--group-title">picking-up</h5>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12 col-lg-6">
                                                <b-form-group
                                                    class="danny--form-group"
                                                    label="Picking up"
                                                    label-for="one-way-picking-up"
                                                    label-cols="12"
                                                    label-cols-sm="3"
                                                    content-cols="12"
                                                    content-cols-sm="9"
                                                    :invalid-feedback="errorMessages.required"
                                                    :state="validateInputField($v.form.bookingRequirements.reservation.oneWayTrip.origin)">
                                                    <b-input-group>
                                                        <b-input-group-prepend>
                                                            <div class="btn">
                                                                <b-icon icon="geo-alt"></b-icon>
                                                            </div>
                                                        </b-input-group-prepend>
                                                        <b-form-input
                                                            autocomplete="off"
                                                            id="one-way-picking-up"
                                                            placeholder="ZIP, City, Airport or Address"
                                                            type="text"
                                                            v-model="form.bookingRequirements.reservation.oneWayTrip.originSearch"
                                                            @input="fetchSearchResultFromGoogle($event, 'oneWayTrip', 'origin')">
                                                        </b-form-input>
                                                        <ul class="dropdown-menu" :class="dropdowns.oneWayTrip.origin.show === true ? 'show' : ''">
                                                            <li
                                                                @click="updateSearchResult(location, 'oneWayTrip', 'origin')"
                                                                v-for="location in dropdowns.oneWayTrip.origins"
                                                                class="dropdown-item">
                                                                <div class="danny--form-group-dropdown-item">
                                                                    <div>
                                                                        <div class="btn px-2">
                                                                            <b-icon icon="geo-alt"></b-icon>
                                                                        </div>
                                                                    </div>
                                                                    <div>{{ location.description }}</div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </b-input-group>
                                                </b-form-group>
                                            </div>

                                            <div class="col-12 col-lg-6">
                                                <b-form-group
                                                    class="danny--form-group"
                                                    label="Destination"
                                                    label-for="one-way-destination"
                                                    label-cols="12"
                                                    label-cols-sm="3"
                                                    content-cols="12"
                                                    content-cols-sm="9"
                                                    :invalid-feedback="errorMessages.required"
                                                    :state="validateInputField($v.form.bookingRequirements.reservation.oneWayTrip.destination)">
                                                    <b-input-group>
                                                        <b-input-group-prepend>
                                                            <div class="btn">
                                                                <b-icon icon="geo-alt"></b-icon>
                                                            </div>
                                                        </b-input-group-prepend>
                                                        <b-form-input
                                                            autocomplete="off"
                                                            id="one-way-destination"
                                                            placeholder="ZIP, City, Airport or Address"
                                                            type="text"
                                                            v-model="form.bookingRequirements.reservation.oneWayTrip.destinationSearch"
                                                            @input="fetchSearchResultFromGoogle($event, 'oneWayTrip', 'destination')">
                                                        </b-form-input>
                                                        <ul class="dropdown-menu" :class="dropdowns.oneWayTrip.destination.show === true ? 'show' : ''">
                                                            <li
                                                                @click="updateSearchResult(location, 'oneWayTrip', 'destination')"
                                                                v-for="location in dropdowns.oneWayTrip.destinations"
                                                                class="dropdown-item">
                                                                <div class="danny--form-group-dropdown-item">
                                                                    <div>
                                                                        <div class="btn px-2">
                                                                            <b-icon icon="geo-alt"></b-icon>
                                                                        </div>
                                                                    </div>
                                                                    <div>{{ location.description }}</div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </b-input-group>
                                                </b-form-group>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12 col-lg-6">
                                                <b-form-group
                                                    class="danny--form-group"
                                                    label="Pickup date"
                                                    label-for="one-way-pickup-date"
                                                    label-cols="12"
                                                    label-cols-sm="3"
                                                    content-cols="12"
                                                    content-cols-sm="9"
                                                    :invalid-feedback="errorMessages.required"
                                                    :state="validateInputField($v.form.bookingRequirements.reservation.oneWayTrip.pickup.date)">
                                                    <b-form-datepicker
                                                        id="one-way-pickup-date"
                                                        :min="new Date()"
                                                        v-model="$v.form.bookingRequirements.reservation.oneWayTrip.pickup.date.$model">
                                                    </b-form-datepicker>
                                                </b-form-group>
                                            </div>

                                            <div class="col-12 col-lg-6">
                                                <b-form-group
                                                    class="danny--form-group"
                                                    label="Pickup time"
                                                    label-for="one-way-pickup-time"
                                                    label-cols="12"
                                                    label-cols-sm="3"
                                                    content-cols="12"
                                                    content-cols-sm="9"
                                                    :invalid-feedback="errorMessages.required"
                                                    :state="validateInputField($v.form.bookingRequirements.reservation.oneWayTrip.pickup.time)">
                                                    <b-form-timepicker
                                                        hours12="false"
                                                        id="one-way-pickup-time"
                                                        v-model="$v.form.bookingRequirements.reservation.oneWayTrip.pickup.time.$model">
                                                    </b-form-timepicker>
                                                </b-form-group>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12 col-lg-6">
                                                <b-form-group
                                                    class="danny--form-group"
                                                    label="Passengers"
                                                    label-for="one-way-passengers"
                                                    label-cols="12"
                                                    label-cols-sm="3"
                                                    content-cols="12"
                                                    content-cols-sm="9"
                                                    :invalid-feedback="'Minimum passengers is 1'"
                                                    :state="validateInputField($v.form.bookingRequirements.reservation.oneWayTrip.passengers)">
                                                    <b-input-group>
                                                        <b-input-group-prepend>
                                                            <div class="btn">
                                                                <b-icon icon="people"></b-icon>
                                                            </div>
                                                        </b-input-group-prepend>
                                                        <b-form-input
                                                            no-wheel
                                                            id="one-way-passengers"
                                                            min="0"
                                                            type="number"
                                                            v-model="$v.form.bookingRequirements.reservation.oneWayTrip.passengers.$model">
                                                        </b-form-input>
                                                    </b-input-group>
                                                </b-form-group>
                                            </div>
                                        </div>
                                    </section>

                                    <template v-if="form.bookingRequirements.reservation.tripType === 'round-trip'">
                                        <!-- Second Origin -->
                                        <section class="mt-5">
                                            <div class="row">
                                                <div class="col-12">
                                                    <iframe
                                                        width="100%"
                                                        height="300"
                                                        frameborder="0"
                                                        style="border:0"
                                                        referrerpolicy="no-referrer-when-downgrade"
                                                        :src="returnMapPreview"
                                                        allowfullscreen>
                                                    </iframe>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <h5 class="danny--group-title">return</h5>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12 col-lg-6">
                                                    <b-form-group
                                                        class="danny--form-group"
                                                        label="Picking up"
                                                        label-for="round-trip-picking-up"
                                                        label-cols="12"
                                                        label-cols-sm="3"
                                                        content-cols="12"
                                                        content-cols-sm="9"
                                                        :invalid-feedback="errorMessages.required"
                                                        :state="validateInputField($v.form.bookingRequirements.reservation.roundTrip.origin)">
                                                        <b-input-group>
                                                            <b-input-group-prepend>
                                                                <div class="btn">
                                                                    <b-icon icon="geo-alt"></b-icon>
                                                                </div>
                                                            </b-input-group-prepend>
                                                            <b-form-input
                                                                autocomplete="off"
                                                                id="round-trip-picking-up"
                                                                placeholder="ZIP, City, Airport or Address"
                                                                type="text"
                                                                v-model="form.bookingRequirements.reservation.roundTrip.originSearch"
                                                                @input="fetchSearchResultFromGoogle($event, 'roundTrip', 'origin')">
                                                            </b-form-input>
                                                            <ul class="dropdown-menu" :class="dropdowns.roundTrip.origin.show === true ? 'show' : ''">
                                                                <li
                                                                    @click="updateSearchResult(location, 'roundTrip', 'origin')"
                                                                    v-for="location in dropdowns.roundTrip.origins"
                                                                    class="dropdown-item">
                                                                    <div class="danny--form-group-dropdown-item">
                                                                        <div>
                                                                            <div class="btn px-2">
                                                                                <b-icon icon="geo-alt"></b-icon>
                                                                            </div>
                                                                        </div>
                                                                        <div>{{ location.description }}</div>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </b-input-group>
                                                    </b-form-group>
                                                </div>

                                                <div class="col-12 col-lg-6">
                                                    <b-form-group
                                                        class="danny--form-group"
                                                        label="Destination"
                                                        label-for="round-trip-destination"
                                                        label-cols="12"
                                                        label-cols-sm="3"
                                                        content-cols="12"
                                                        content-cols-sm="9"
                                                        :invalid-feedback="errorMessages.required"
                                                        :state="validateInputField($v.form.bookingRequirements.reservation.roundTrip.destination)">
                                                        <b-input-group>
                                                            <b-input-group-prepend>
                                                                <div class="btn">
                                                                    <b-icon icon="geo-alt"></b-icon>
                                                                </div>
                                                            </b-input-group-prepend>
                                                            <b-form-input
                                                                autocomplete="off"
                                                                id="round-trip-destination"
                                                                placeholder="ZIP, City, Airport or Address"
                                                                type="text"
                                                                v-model="form.bookingRequirements.reservation.roundTrip.destinationSearch"
                                                                @input="fetchSearchResultFromGoogle($event, 'roundTrip', 'destination')">
                                                            </b-form-input>
                                                            <ul class="dropdown-menu" :class="dropdowns.roundTrip.destination.show === true ? 'show' : ''">
                                                                <li
                                                                    @click="updateSearchResult(location, 'roundTrip', 'destination')"
                                                                    v-for="location in dropdowns.roundTrip.destinations"
                                                                    class="dropdown-item">
                                                                    <div class="danny--form-group-dropdown-item">
                                                                        <div>
                                                                            <div class="btn px-2">
                                                                                <b-icon icon="geo-alt"></b-icon>
                                                                            </div>
                                                                        </div>
                                                                        <div>{{ location.description }}</div>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </b-input-group>
                                                    </b-form-group>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12 col-lg-6">
                                                    <b-form-group
                                                        class="danny--form-group"
                                                        label="Pickup date"
                                                        label-for="round-trip-pickup-date"
                                                        label-cols="12"
                                                        label-cols-sm="3"
                                                        content-cols="12"
                                                        content-cols-sm="9"
                                                        :invalid-feedback="errorMessages.required"
                                                        :state="validateInputField($v.form.bookingRequirements.reservation.roundTrip.pickup.date)">
                                                        <b-form-datepicker
                                                            id="round-trip-pickup-date"
                                                            :min="new Date()"
                                                            v-model="$v.form.bookingRequirements.reservation.roundTrip.pickup.date.$model">
                                                        </b-form-datepicker>
                                                    </b-form-group>
                                                </div>

                                                <div class="col-12 col-lg-6">
                                                    <b-form-group
                                                        class="danny--form-group"
                                                        label="Pickup time"
                                                        label-for="round-trip-pickup-time"
                                                        label-cols="12"
                                                        label-cols-sm="3"
                                                        content-cols="12"
                                                        content-cols-sm="9"
                                                        :invalid-feedback="errorMessages.required"
                                                        :state="validateInputField($v.form.bookingRequirements.reservation.roundTrip.pickup.time)">
                                                        <b-form-timepicker
                                                            hours12="false"
                                                            id="round-trip-pickup-time"
                                                            v-model="$v.form.bookingRequirements.reservation.roundTrip.pickup.time.$model">
                                                        </b-form-timepicker>
                                                    </b-form-group>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12 col-lg-6">
                                                    <b-form-group
                                                        class="danny--form-group"
                                                        label="Passengers"
                                                        label-for="round-trip-passengers"
                                                        label-cols="12"
                                                        label-cols-sm="3"
                                                        content-cols="12"
                                                        content-cols-sm="9"
                                                        :invalid-feedback="'Minimum passengers is 1'"
                                                        :state="validateInputField($v.form.bookingRequirements.reservation.roundTrip.passengers)">
                                                        <b-input-group>
                                                            <b-input-group-prepend>
                                                                <div class="btn">
                                                                    <b-icon icon="people"></b-icon>
                                                                </div>
                                                            </b-input-group-prepend>
                                                            <b-form-input
                                                                no-wheel
                                                                id="round-trip-passengers"
                                                                min="0"
                                                                type="number"
                                                                v-model="$v.form.bookingRequirements.reservation.roundTrip.passengers.$model">
                                                            </b-form-input>
                                                        </b-input-group>
                                                    </b-form-group>
                                                </div>
                                            </div>
                                        </section>
                                    </template>
                                </template>

                                <!-- Buttons -->
                                <section class="mt-4 pt-4 border-top border-secondary">
                                    <div class="row">
                                        <div class="col-12 text-right">
                                            <button class="danny--btn" @click.prevent="saveReservation">Save & Next</button>
                                        </div>
                                    </div>
                                </section>
                            </b-form>
                        </b-tab>

                        <!-- selectCar -->
                        <b-tab :disabled="completedTabs.selectCar === false">
                            <template #title>
                                <span>2.</span> <span class="tab-heading">Select your car</span>
                            </template>

                            <section v-if="vehicles.oneWayTrip.length > 0">
                                <h5 class="danny--group-title">Picking-up</h5>
                                <div
                                    class="row align-items-center p-4 mb-3"
                                    :class="vehicle.availableCars === '0' ? 'bg-white' : 'bg-white'"
                                    v-for="vehicle in vehicles.oneWayTrip">
                                    <div class="col-12 col-md-6 col-lg-3">
                                        <img :src="'<?= base_url('static/images/vehicles/') ?>/' + vehicle.carImage" class="img-fluid" />
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-3 col-lg-3">
                                        <p class="danny--car-name">
                                            {{ vehicle.carName }}
                                        </p>
                                        <p :class="{ 'danny--car-availability': true, 'text-danger': vehicle.availableCars === '0' }">
                                            {{ vehicle.availableCars === '0' ? 'Out of service' : 'Available' }}
                                        </p>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-3 col-lg-3">
                                        <p class="danny--car-price">&dollar;{{ vehicle.carStartPrice }}</p>
                                    </div>
                                    <div class="col-12 col-lg-3 text-right">
                                        <b-form-radio
                                            :disabled="vehicle.availableCars === '0'"
                                            v-model="$v.form.bookingRequirements.selectCar.oneWayTrip.vehicle.$model"
                                            name="one-way-vehicle"
                                            :value="vehicle"
                                            button
                                            button-variant="outline-primary">
                                            Select
                                        </b-form-radio>
                                    </div>
                                </div>
                            </section>

                            <section v-if="vehicles.roundTrip.length > 0">
                                <h5 class="danny--group-title">Return</h5>
                                <div
                                    class="row align-items-center p-4 mb-3"
                                    :class="vehicle.availableCars === '0' ? 'bg-white' : 'bg-white'"
                                    v-for="vehicle in vehicles.roundTrip">
                                    <div class="col-12 col-md-6 col-lg-3">
                                        <img :src="'<?= base_url('static/images/vehicles/') ?>/' + vehicle.carImage" class="img-fluid" />
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-3 col-lg-3">
                                        <p class="danny--car-name">
                                            {{ vehicle.carName }}
                                        </p>
                                        <p :class="{ 'danny--car-availability': true, 'text-danger': vehicle.availableCars === '0' }">
                                            {{ vehicle.availableCars === '0' ? 'Out of service' : 'Available' }}
                                        </p>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-3 col-lg-3">
                                        <p class="danny--car-price">&dollar;{{ vehicle.carStartPrice }}</p>
                                    </div>
                                    <div class="col-12 col-lg-3 text-right">
                                        <b-form-radio
                                            :disabled="vehicle.availableCars === '0'"
                                            v-model="$v.form.bookingRequirements.selectCar.roundTrip.vehicle.$model"
                                            name="round-trip-vehicle"
                                            :value="vehicle"
                                            button
                                            button-variant="outline-primary">
                                            Select
                                        </b-form-radio>
                                    </div>
                                </div>
                            </section>

                            <!-- Buttons -->
                            <section class="mt-4 pt-4 border-top border-secondary">
                                <div class="row">
                                    <div class="col-12 text-right">
                                        <button class="danny--btn" @click.prevent="saveSelectCar">Save & Next</button>
                                    </div>
                                </div>
                            </section>
                        </b-tab>

                        <!-- chooseOptions -->
                        <b-tab :disabled="completedTabs.chooseOptions === false">
                            <template #title>
                                <span>3.</span> <span class="tab-heading">Choose your options</span>
                            </template>

                            <section>
                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="danny--group-title">picking-up</h5>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="bg-white p-3 h-100">
                                            <h5 class="danny--group-title">Extras</h5>
                                            <b-form-group
                                                :state="validateInputField($v.form.bookingRequirements.chooseOptions.oneWayTrip.extras)"
                                                :invalid-feedback="errorMessages.required">
                                                <b-checkbox-group
                                                    stacked
                                                    v-model="$v.form.bookingRequirements.chooseOptions.oneWayTrip.extras.$model"
                                                    name="otpions-extras">
                                                    <div class="row" v-for="option in options.extras">
                                                        <div class="col-8">
                                                            <b-form-checkbox
                                                                :value="option">
                                                                {{ option.configName }}
                                                            </b-form-checkbox>
                                                        </div>
                                                        <div class="col-4">
                                                            <span class="danny--car-option-price">
                                                                &dollar;{{ option.configValue }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </b-checkbox-group>
                                            </b-form-group>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="bg-white p-3 h-100">
                                            <h5 class="danny--group-title">Protection</h5>
                                            <b-form-group
                                                :state="validateInputField($v.form.bookingRequirements.chooseOptions.oneWayTrip.protection)"
                                                :invalid-feedback="errorMessages.required">
                                                <b-checkbox-group
                                                    stacked
                                                    v-model="$v.form.bookingRequirements.chooseOptions.oneWayTrip.protection.$model"
                                                    name="otpions-protection">
                                                    <div class="row" v-for="option in options.protection">
                                                        <div class="col-8">
                                                            <b-form-checkbox
                                                                :value="option">
                                                                {{ option.configName }}
                                                            </b-form-checkbox>
                                                        </div>
                                                        <div class="col-4">
                                                            <span class="danny--car-option-price">
                                                                &dollar;{{ option.configValue }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </b-checkbox-group>
                                            </b-form-group>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section
                                class="mt-4"
                                v-if="form.bookingRequirements.reservation.tripType === 'round-trip'">
                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="danny--group-title">return</h5>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="bg-white p-3 h-100">
                                            <h5 class="danny--group-title">Extras</h5>
                                            <b-form-group
                                                :state="validateInputField($v.form.bookingRequirements.chooseOptions.roundTrip.extras)"
                                                :invalid-feedback="errorMessages.required">
                                                <b-checkbox-group
                                                    stacked
                                                    v-model="$v.form.bookingRequirements.chooseOptions.roundTrip.extras.$model"
                                                    name="round-trip-otpions-extras">
                                                    <div class="row" v-for="option in options.extras">
                                                        <div class="col-8">
                                                            <b-form-checkbox
                                                                :value="option">
                                                                {{ option.configName }}
                                                            </b-form-checkbox>
                                                        </div>
                                                        <div class="col-4">
                                                            <span class="danny--car-option-price">
                                                                &dollar;{{ option.configValue }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </b-checkbox-group>
                                            </b-form-group>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="bg-white p-3 h-100">
                                            <h5 class="danny--group-title">Protection</h5>
                                            <b-form-group
                                                :state="validateInputField($v.form.bookingRequirements.chooseOptions.roundTrip.protection)"
                                                :invalid-feedback="errorMessages.required">
                                                <b-checkbox-group
                                                    stacked
                                                    v-model="$v.form.bookingRequirements.chooseOptions.roundTrip.protection.$model"
                                                    name="round-trip-otpions-protection">
                                                    <div class="row" v-for="option in options.protection">
                                                        <div class="col-8">
                                                            <b-form-checkbox
                                                                :value="option">
                                                                {{ option.configName }}
                                                            </b-form-checkbox>
                                                        </div>
                                                        <div class="col-4">
                                                            <span class="danny--car-option-price">
                                                                &dollar;{{ option.configValue }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </b-checkbox-group>
                                            </b-form-group>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <!-- Buttons -->
                            <section class="mt-4 pt-4 border-top border-secondary">
                                <div class="row">
                                    <div class="col-12 text-right">
                                        <button class="danny--btn" @click.prevent="saveChooseOptions">Save & Next</button>
                                    </div>
                                </div>
                            </section>
                        </b-tab>

                        <!-- review -->
                        <b-tab :disabled="completedTabs.review === false">
                            <template #title>
                                <span>4.</span> <span class="tab-heading">Information & Review</span>
                            </template>

                            <b-form @submit.prevent="submitBooking">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <!-- Contact information -->
                                        <section class="mb-5">
                                            <h5 class="danny--group-title">Personal info</h5>
                                            <div class="row">
                                                <div class="col-12 col-lg-6">
                                                    <b-form-group
                                                        :invalid-feedback="errorMessages.required"
                                                        :state="validateInputField($v.form.bookingRequirements.review.customer.firstName)">
                                                        <b-form-input
                                                            placeholder="First name"
                                                            type="text"
                                                            v-model="$v.form.bookingRequirements.review.customer.firstName.$model">
                                                        </b-form-input>
                                                    </b-form-group>
                                                </div>

                                                <div class="col-12 col-lg-6">
                                                    <b-form-group
                                                        :invalid-feedback="errorMessages.required"
                                                        :state="validateInputField($v.form.bookingRequirements.review.customer.lastName)">
                                                        <b-form-input
                                                            placeholder="Last name"
                                                            type="text"
                                                            v-model="$v.form.bookingRequirements.review.customer.lastName.$model">
                                                        </b-form-input>
                                                    </b-form-group>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12 col-lg-6">
                                                    <b-form-group
                                                        :invalid-feedback="errorMessages.required"
                                                        :state="validateInputField($v.form.bookingRequirements.review.customer.contact.mobileNumber)">
                                                        <b-form-input
                                                            placeholder="Mobile number"
                                                            type="text"
                                                            v-model="$v.form.bookingRequirements.review.customer.contact.mobileNumber.$model">
                                                        </b-form-input>
                                                    </b-form-group>
                                                </div>

                                                <div class="col-12 col-lg-6">
                                                    <b-form-group
                                                        :invalid-feedback="errorMessageEmail"
                                                        :state="validateInputField($v.form.bookingRequirements.review.customer.contact.email)">
                                                        <b-form-input
                                                            placeholder="Email address"
                                                            type="text"
                                                            v-model="$v.form.bookingRequirements.review.customer.contact.email.$model">
                                                        </b-form-input>
                                                    </b-form-group>
                                                </div>
                                            </div>
                                        </section>

                                        <!-- Airline information -->
                                        <section>
                                            <h5 class="danny--group-title">Airline info</h5>
                                            <div class="row">
                                                <div class="col-12 col-lg-6">
                                                    <b-form-group
                                                        :invalid-feedback="errorMessages.required"
                                                        :state="validateInputField($v.form.bookingRequirements.review.airline.brand)">
                                                        <b-form-select
                                                            id="airline-brand"
                                                            v-model="$v.form.bookingRequirements.review.airline.brand.$model">
                                                            <b-form-select-option v-for="brand in airlineBrands" :value="brand">{{ brand.text }}</b-form-select-option>
                                                        </b-form-select>
                                                    </b-form-group>
                                                </div>

                                                <div class="col-12 col-lg-6">
                                                    <b-form-group
                                                        :invalid-feedback="errorMessages.required"
                                                        :state="validateInputField($v.form.bookingRequirements.review.airline.flightNumber)">
                                                        <b-form-input
                                                            placeholder="Flight number"
                                                            type="text"
                                                            id="airline-flight-number"
                                                            v-model="$v.form.bookingRequirements.review.airline.flightNumber.$model">
                                                        </b-form-input>
                                                    </b-form-group>
                                                </div>
                                            </div>
                                        </section>

                                        <!-- Additional information -->
                                        <section>
                                            <h5 class="danny--group-title">Additional info</h5>
                                            <div class="row">
                                                <div class="col-12">
                                                    <b-form-group
                                                        :invalid-feedback="errorMessages.required"
                                                        :state="validateInputField($v.form.bookingRequirements.review.additionalNotes)">
                                                        <b-form-textarea
                                                            rows="4"
                                                            max-rows="5"
                                                            id="customer-additional-notes"
                                                            v-model="$v.form.bookingRequirements.review.additionalNotes.$model">
                                                        </b-form-textarea>
                                                    </b-form-group>
                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <!-- One-way trip -->
                                        <div class="bg-white p-4 mt-3">
                                            <section>
                                                <div class="row">
                                                    <div class="col-10">
                                                        <h5 class="danny--group-title">Vehicle</h5>
                                                    </div>
                                                    <div class="col-2">
                                                        <button class="btn" title="Edit pick-up" @click="() => { formActiveTab = 1 }">
                                                            <b-icon icon="pencil-square"></b-icon>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 text-center my-3">
                                                        <img :src="oneWayTripVehicle" class="img-fluid" />
                                                    </div>
                                                </div>
                                            </section>

                                            <!-- Booking -->
                                            <section>
                                                <div class="row">
                                                    <div class="col-10">
                                                        <h5 class="danny--group-title">Pick-up</h5>
                                                    </div>
                                                    <div class="col-2">
                                                        <button class="btn" title="Edit pick-up" @click="() => { formActiveTab = 0 }">
                                                            <b-icon icon="pencil-square"></b-icon>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 col-md-3">
                                                        <span class="danny--font-weight-bold">From:</span>
                                                    </div>
                                                    <div class="col-12 col-md-9">
                                                        {{
                                                            oneWayTripOrigin
                                                        }}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 col-md-3">
                                                        <span class="danny--font-weight-bold">To:</span>
                                                    </div>
                                                    <div class="col-12 col-md-9">
                                                        {{
                                                            oneWayTripDestination
                                                        }}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 col-md-3">
                                                        <span class="danny--font-weight-bold">Miles:</span>
                                                    </div>
                                                    <div class="col-12 col-md-9">
                                                        {{
                                                            oneWayTripRouteMiles
                                                        }}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 col-md-3">
                                                        <span class="danny--font-weight-bold">Pickup time:</span>
                                                    </div>
                                                    <div class="col-12 col-md-9">
                                                        <span class="danny--review-pickup-time">{{ oneWayTripPickup }}</span>
                                                    </div>
                                                </div>

                                                <!-- Chosen options -->
                                                <section
                                                    class="mt-5"
                                                    v-if="form.bookingRequirements.chooseOptions.oneWayTrip.extras.length || form.bookingRequirements.chooseOptions.oneWayTrip.protection.length">
                                                    <section>
                                                        <div class="row">
                                                            <div class="col-10">
                                                                <h5 class="danny--group-title">Chosen options</h5>
                                                            </div>
                                                            <div class="col-2">
                                                                <button class="btn" title="Edit chosen options" @click="() => { formActiveTab = 2 }">
                                                                    <b-icon icon="pencil-square"></b-icon>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </section>

                                                    <section v-if="form.bookingRequirements.chooseOptions.oneWayTrip.extras.length > 0">
                                                        <div
                                                            class="row"
                                                            v-for="option in form.bookingRequirements.chooseOptions.oneWayTrip.extras">
                                                            <div class="col-8">
                                                                {{ option.configName }}
                                                            </div>
                                                            <div class="col-4">
                                                                <span class="danny--car-option-price">&dollar;{{ option.configValue }}</span>
                                                            </div>
                                                        </div>
                                                    </section>

                                                    <section v-if="form.bookingRequirements.chooseOptions.oneWayTrip.protection.length > 0">
                                                        <div
                                                            class="row"
                                                            v-for="option in form.bookingRequirements.chooseOptions.oneWayTrip.protection">
                                                            <div class="col-8">
                                                                {{ option.configName }}
                                                            </div>
                                                            <div class="col-4">
                                                                <span class="danny--car-option-price">&dollar;{{ option.configValue }}</span>
                                                            </div>
                                                        </div>
                                                    </section>
                                                </section>
                                            </section>
                                        </div>

                                        <!-- Round trip -->
                                        <template v-if="form.bookingRequirements.reservation.tripType === 'round-trip'">
                                            <div class="bg-white p-4 mt-3">
                                                <section>
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <h5 class="danny--group-title">Vehicle</h5>
                                                        </div>
                                                        <div class="col-2">
                                                            <button class="btn" title="Edit pick-up" @click="() => { formActiveTab = 1 }">
                                                                <b-icon icon="pencil-square"></b-icon>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12 text-center my-3">
                                                            <img :src="roundTripVehicle" class="img-fluid" />
                                                        </div>
                                                    </div>
                                                </section>

                                                <!-- Booking -->
                                                <section>
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <h5 class="danny--group-title">Return</h5>
                                                        </div>
                                                        <div class="col-2">
                                                            <button class="btn" title="Edit pick-up" @click="() => { formActiveTab = 0 }">
                                                                <b-icon icon="pencil-square"></b-icon>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12 col-md-3">
                                                            <span class="danny--font-weight-bold">From:</span>
                                                        </div>
                                                        <div class="col-12 col-md-9">
                                                            {{
                                                                roundTripOrigin
                                                            }}
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12 col-md-3">
                                                            <span class="danny--font-weight-bold">To:</span>
                                                        </div>
                                                        <div class="col-12 col-md-9">
                                                            {{
                                                                roundTripDestination
                                                            }}
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12 col-md-3">
                                                            <span class="danny--font-weight-bold">Miles:</span>
                                                        </div>
                                                        <div class="col-12 col-md-9">
                                                            {{
                                                                roundTripRouteMiles
                                                            }}
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12 col-md-3">
                                                            <span class="danny--font-weight-bold">Pickup time:</span>
                                                        </div>
                                                        <div class="col-12 col-md-9">
                                                            <span class="danny--review-pickup-time">{{ roundTripPickup }}</span>
                                                        </div>
                                                    </div>

                                                    <!-- Chosen options -->
                                                    <section
                                                        class="mt-5"
                                                        v-if="form.bookingRequirements.chooseOptions.roundTrip.extras.length || form.bookingRequirements.chooseOptions.roundTrip.protection.length">
                                                        <section>
                                                            <div class="row">
                                                                <div class="col-10">
                                                                    <h5 class="danny--group-title">Chosen options</h5>
                                                                </div>
                                                                <div class="col-2">
                                                                    <button class="btn" title="Edit chosen options" @click="() => { formActiveTab = 2 }">
                                                                        <b-icon icon="pencil-square"></b-icon>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </section>

                                                        <section v-if="form.bookingRequirements.chooseOptions.roundTrip.extras.length > 0">
                                                            <div
                                                                class="row"
                                                                v-for="option in form.bookingRequirements.chooseOptions.roundTrip.extras">
                                                                <div class="col-8">
                                                                    {{ option.configName }}
                                                                </div>
                                                                <div class="col-4">
                                                                    <span class="danny--car-option-price">&dollar;{{ option.configValue }}</span>
                                                                </div>
                                                            </div>
                                                        </section>

                                                        <section v-if="form.bookingRequirements.chooseOptions.roundTrip.protection.length > 0">
                                                            <div
                                                                class="row"
                                                                v-for="option in form.bookingRequirements.chooseOptions.roundTrip.protection">
                                                                <div class="col-8">
                                                                    {{ option.configName }}
                                                                </div>
                                                                <div class="col-4">
                                                                    <span class="danny--car-option-price">&dollar;{{ option.configValue }}</span>
                                                                </div>
                                                            </div>
                                                        </section>
                                                    </section>
                                                </section>
                                            </div>
                                        </template>

                                        <!-- Apply coupon -->
                                        <div class="bg-white p-4 mt-3">
                                            <section>
                                                <div class="row">
                                                    <div class="col-10">
                                                        <h5 class="danny--group-title">Coupon</h5>
                                                    </div>
                                                    
                                                    <div class="col-12">
                                                        <b-form-group>
                                                            <b-input-group>
                                                                <b-form-input
                                                                    autocomplete="off"
                                                                    type="text"
                                                                    v-model="coupon">
                                                                </b-form-input>
                                                                <b-input-group-append>
                                                                    <b-button @click="applyCoupon">Apply</b-button>
                                                                </b-input-group-append>
                                                            </b-input-group>
                                                        </b-form-group>
                                                    </div>

                                                    <div class="col-12" v-if="form.bookingRequirements.review.appliedCoupons.length > 0">
                                                        <b-form-group label="Applied coupons">
                                                            <b-form-tags
                                                                v-model="form.bookingRequirements.review.appliedCoupons"
                                                                no-outer-focus>
                                                                <template v-slot="{ tags, inputAttrs, inputHandlers, tagVariant, addTag, removeTag }">
                                                                    <div class="d-inline-block" style="font-size: 1.5rem;">
                                                                        <b-form-tag
                                                                            v-for="tag in tags"
                                                                            @remove="removeTag(tag)"
                                                                            :key="JSON.parse(tag).couponId"
                                                                            :title="'Remove' + JSON.parse(tag).couponCode"
                                                                            variant="primary"
                                                                            class="mr-1">
                                                                            {{ JSON.parse(tag).couponCode }}
                                                                        </b-form-tag>
                                                                    </div>
                                                                </template>
                                                            </b-form-tags>
                                                        </b-form-group>
                                                    </div>
                                                </div>
                                            </section>
                                        </div>

                                        <!-- Tips driver -->
                                        <div class="bg-white p-4 mt-3">
                                            <section>
                                                <div class="row">
                                                    <div class="col-10">
                                                        <h5 class="danny--group-title">Tip driver</h5>
                                                    </div>

                                                    <div class="col-12">
                                                        <b-form-group>
                                                            <b-form-radio-group
                                                                name="tip-driver"
                                                                v-model="$v.form.bookingRequirements.review.prices.tipDriverAmount.$model"
                                                                :options="tipDriverOptions"
                                                                buttons
                                                                button-variant="outline-primary">
                                                            </b-form-radio-group>
                                                        </b-form-group>

                                                        <b-form-group
                                                            v-if="form.bookingRequirements.review.prices.tipDriverAmount === 'other'"
                                                            label="Tip amount"
                                                            :invalid-feedback="errorMessages.required"
                                                            :state="validateInputField($v.form.bookingRequirements.review.prices.tipDriverAmountOther)">
                                                            <b-input-group>
                                                                <b-form-input
                                                                    no-wheel
                                                                    type="number"
                                                                    min="0"
                                                                    max="100"
                                                                    v-model="$v.form.bookingRequirements.review.prices.tipDriverAmountOther.$model">
                                                                </b-form-input>
                                                                <b-input-group-append>
                                                                    <b-button>
                                                                        <b-icon icon="currency-dollar"></b-icon>
                                                                    </b-button>
                                                                </b-input-group-append>
                                                            </b-input-group>
                                                        </b-form-group>
                                                    </div>
                                                </div>
                                            </section>
                                        </div>

                                        <!-- Payment -->
                                        <div class="bg-white p-4 mt-3">
                                            <section>
                                                <section>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <h5 class="danny--group-title">Payment method</h5>
                                                        </div>
                                                    </div>
                                                </section>
                                                
                                                <section class="mb-4">
                                                    <div class="row">
                                                        <div class="col-12 col-lg-8">
                                                            <span class="danny--review-payment-total-text">
                                                                Estimated total
                                                            </span>
                                                        </div>
                                                        <div class="col-12 col-lg-4">
                                                            <p class="danny--review-payment-total-price m-0">
                                                                &dollar;{{ form.bookingRequirements.review.prices.totalNotDiscount }}
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12 col-lg-8">
                                                            <span class="danny--review-payment-total-text">
                                                                Discount
                                                            </span>
                                                        </div>
                                                        <div class="col-12 col-lg-4">
                                                            <p class="danny--review-payment-total-price m-0">
                                                                &dollar;{{ form.bookingRequirements.review.prices.discountAmount }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12 col-lg-8">
                                                            <span class="danny--review-payment-total-text">
                                                                Subtotal
                                                            </span>
                                                        </div>
                                                        <div class="col-12 col-lg-4">
                                                            <p class="danny--review-payment-total-price m-0">
                                                                &dollar;{{ totalRoutesPrice }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </section>

                                                <b-form-group
                                                    :invalid-feedback="errorMessages.required"
                                                    :state="validateInputField($v.form.bookingRequirements.review.agreeTermsConditions)">
                                                    <b-form-checkbox
                                                        id="agree-terms-conditions"
                                                        v-model="$v.form.bookingRequirements.review.agreeTermsConditions.$model">
                                                        I agree with the 
                                                        <a
                                                            class="danny--review-payment-agree"
                                                            href="javascript:void(0)"
                                                            target="_blank">
                                                            Term and Conditions
                                                        </a>
                                                    </b-form-checkbox>
                                                </b-form-group>
                                            </section>
                                        </div>
                                    </div>
                                </div>

                                <!-- Buttons -->
                                <section class="mt-4 pt-4 border-top border-secondary">
                                    <div class="row">
                                        <div class="col-12 text-right">
                                            <button
                                                class="danny--btn"
                                                type="submit">
                                                Book it now
                                            </button>
                                        </div>
                                    </div>
                                </section>
                            </b-form>
                        </b-tab>
                    </b-tabs>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>

<?= $this->section("page-scripts") ?>
    <script type="text/javascript">
        const baseURL = "<?= base_url('/') ?>";
        const bookingId = "<?= $bookingId ?>";
        const env = "<?= $enviroment ?>";
    </script>

    <script src="<?= base_url('static/js/vendors/jquery.min.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('static/js/vendors/popper.min.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('static/js/vendors/moment.min.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('static/js/vendors/axios.min.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('static/js/vendors/bootstrap.min.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('static/js/vendors/lodash.min.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('static/js/vendors/vue.min.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('static/js/vendors/portal-vue.umd.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('static/js/vendors/bootstrap-vue.min.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('static/js/vendors/bootstrap-vue-icons.min.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('static/js/vendors/validators.min.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('static/js/vendors/vuelidate.min.js') ?>" type="text/javascript"></script>

    <script
        defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBEGGWz3KOsiPnxuygccrvKGBJEJgxih3s&libraries=places&callback=initMap">
    </script>

    <script>

        let autocompleteService;

        function initMap() {
            autocompleteService = new google.maps.places.AutocompleteService();
        }

        Vue.use(window.vuelidate.default);
    </script>

    <?php if ($enviroment === 'production'): ?>
        <script src="<?= base_url('static/js/main-app.min.js?v=' . now()) ?>"></script>
    <?php else: ?>
        <script src="<?= base_url('static/mixins/formData.js') ?>" type="text/javascript"></script>
        <script src="<?= base_url('static/js/main-app.js') ?>"></script>
    <?php endif ?>
<?= $this->endSection() ?>
