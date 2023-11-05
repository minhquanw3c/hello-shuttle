<?= $this->extend("templates/base_layout") ?>

<?= $this->section("page-custom-style") ?>
    <link rel="stylesheet" href="<?= base_url('static/css/vendors/vue-multiselect.min.css') ?>">
<?= $this->endSection() ?>

<?= $this->section("main-content") ?>
    <!-- SLIDER AREA START (slider-4) -->
    <div class="ltn__slider-area ltn__slider-4 ">
        <div class="ltn__slide-one-active----- slick-slide-arrow-1----- slick-slide-dots-1----- arrow-white----- ltn__slide-animation-active">
            <!-- ltn__slide-item -->
            <div class="ltn__slide-item ltn__slide-item-2 ltn__slide-item-4 text-color-white bg-image" data-bg="<?= base_url('static/images/backgrounds/bg-003.jpg') ?>">
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
                    <b-tabs class="danny--form-step" nav-class="mb-4 danny--nav-tabs" v-model="formActiveTabIndex" id="form-steps">
                        <!-- reservation -->
                        <b-tab>
                            <template #title>
                                <span>1.</span> <span class="tab-heading">Make a reservation</span>
                            </template>

                            <b-form @submit.prevent="saveReservation" novalidate>
                                <section>
                                    <div class="row">
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
                                        </div>
                                    </div>
                                </section>

                                <template v-if="form.bookingRequirements.reservation.tripType">
                                    <!-- First Origin -->
                                    <section>
                                        <div class="row">
                                            <div class="col-12">
                                                <h5 class="danny--group-title">picking-up</h5>
                                            </div>
                                        </div>

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
                                                    <b-input-group class="flex-nowrap">
                                                        <b-input-group-prepend>
                                                            <div class="btn">
                                                                <b-icon icon="geo-alt"></b-icon>
                                                            </div>
                                                        </b-input-group-prepend>
                                                        <multiselect
                                                            select-label=""
                                                            selected-label=""
                                                            deselect-label=""
                                                            v-model="form.bookingRequirements.reservation.oneWayTrip.origin"
                                                            track-by="place_id"
                                                            label="description"
                                                            :options="dropdowns.oneWayTrip.origins"
                                                            @search-change="fetchSearchResultFromGoogle($event, 'oneWayTrip', 'origin')"
                                                            >
                                                        </multiselect>
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
                                                    <b-input-group class="flex-nowrap">
                                                        <b-input-group-prepend>
                                                            <div class="btn">
                                                                <b-icon icon="geo-alt"></b-icon>
                                                            </div>
                                                        </b-input-group-prepend>
                                                        <multiselect
                                                            select-label=""
                                                            selected-label=""
                                                            deselect-label=""
                                                            v-model="form.bookingRequirements.reservation.oneWayTrip.destination"
                                                            track-by="place_id"
                                                            label="description"
                                                            :options="dropdowns.oneWayTrip.destinations"
                                                            @search-change="fetchSearchResultFromGoogle($event, 'oneWayTrip', 'destination')"
                                                            >
                                                        </multiselect>
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
                                                            class="readonly"
                                                            readonly
                                                            no-wheel
                                                            id="one-way-passengers"
                                                            min="1"
                                                            type="number"
                                                            v-model="$v.form.bookingRequirements.reservation.oneWayTrip.passengers.$model">
                                                        </b-form-input>
                                                        <b-input-group-append>
                                                            <b-button-group size="sm">
                                                                <b-button
                                                                    @click="increasePassengers('oneWayTrip')"
                                                                    variant="outline-dark">
                                                                    <b-icon icon="plus-circle"></b-icon>
                                                                </b-button>
                                                                <b-button
                                                                    @click="decreasePassengers('oneWayTrip')"
                                                                    variant="outline-dark">
                                                                    <b-icon icon="dash-circle"></b-icon>
                                                                </b-button>
                                                            </b-button-group>
                                                        </b-input-group-append>
                                                    </b-input-group>
                                                </b-form-group>
                                            </div>

                                            <div class="col-12 col-lg-6">
                                                <b-form-group
                                                    class="danny--form-group"
                                                    label="Luggages"
                                                    label-for="one-way-luggages"
                                                    label-cols="12"
                                                    label-cols-sm="3"
                                                    content-cols="12"
                                                    content-cols-sm="9"
                                                    :invalid-feedback="'Minimum luggages is 1'"
                                                    :state="validateInputField($v.form.bookingRequirements.reservation.oneWayTrip.luggages)">
                                                    <b-input-group>
                                                        <b-input-group-prepend>
                                                            <div class="btn">
                                                                <b-icon icon="briefcase"></b-icon>
                                                            </div>
                                                        </b-input-group-prepend>
                                                        <b-form-input
                                                            class="readonly"
                                                            readonly
                                                            no-wheel
                                                            id="one-way-luggages"
                                                            min="0"
                                                            type="number"
                                                            v-model="$v.form.bookingRequirements.reservation.oneWayTrip.luggages.$model">
                                                        </b-form-input>
                                                        <b-input-group-append>
                                                            <div
                                                                class="btn"
                                                                v-b-tooltip.hover
                                                                title="Each person has 1 free luggage and 1 free small bag. Extra luggage or bag will be charged $10 each."
                                                                >
                                                                <b-icon icon="question-circle"></b-icon>
                                                            </div>
                                                            <b-button-group size="sm">
                                                                <b-button
                                                                    @click="increaseLuggages('oneWayTrip')"
                                                                    variant="outline-dark">
                                                                    <b-icon icon="plus-circle"></b-icon>
                                                                </b-button>
                                                                <b-button
                                                                    @click="decreaseLuggages('oneWayTrip')"
                                                                    variant="outline-dark">
                                                                    <b-icon icon="dash-circle"></b-icon>
                                                                </b-button>
                                                            </b-button-group>
                                                        </b-input-group-append>
                                                    </b-input-group>
                                                </b-form-group>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12 col-lg-6">
                                                <b-form-group
                                                    class="danny--form-group"
                                                    label="Has rest stop?"
                                                    label-for="one-way-rest-stop-flag"
                                                    label-cols="12"
                                                    label-cols-sm="3"
                                                    content-cols="12"
                                                    content-cols-sm="9"
                                                    :invalid-feedback="errorMessages.required"
                                                    :state="validateInputField($v.form.bookingRequirements.reservation.oneWayTrip.hasRestStop)">
                                                    <b-form-checkbox
                                                        name="one-way-rest-stop-flag"
                                                        size="lg"
                                                        value="1"
                                                        unchecked-value="0"
                                                        id="one-way-rest-stop-flag"
                                                        v-model="$v.form.bookingRequirements.reservation.oneWayTrip.hasRestStop.$model">
                                                    </b-form-checkbox>
                                                </b-form-group>
                                            </div>

                                            <template v-if="$v.form.bookingRequirements.reservation.oneWayTrip.hasRestStop.$model === '1'">
                                                <div class="col-12 col-lg-6">
                                                    <b-form-group
                                                        class="danny--form-group"
                                                        label="Rest stop"
                                                        label-for="one-way-rest-stop"
                                                        label-cols="12"
                                                        label-cols-sm="3"
                                                        content-cols="12"
                                                        content-cols-sm="9"
                                                        :invalid-feedback="errorMessages.required"
                                                        :state="validateInputField($v.form.bookingRequirements.reservation.oneWayTrip.restStop)">
                                                        <b-input-group class="flex-nowrap">
                                                            <b-input-group-prepend>
                                                                <div class="btn">
                                                                    <b-icon icon="geo-alt"></b-icon>
                                                                </div>
                                                            </b-input-group-prepend>
                                                            <multiselect
                                                                select-label=""
                                                                selected-label=""
                                                                deselect-label=""
                                                                id="one-way-rest-stop"
                                                                v-model="$v.form.bookingRequirements.reservation.oneWayTrip.restStop.$model"
                                                                track-by="place_id"
                                                                label="description"
                                                                :options="dropdowns.oneWayTrip.restStops"
                                                                @search-change="fetchSearchResultFromGoogle($event, 'oneWayTrip', 'restStop')"
                                                                >
                                                            </multiselect>
                                                        </b-input-group>
                                                    </b-form-group>
                                                </div>
                                            </template>
                                        </div>
                                    </section>

                                    <template v-if="isRoundTrip">
                                        <!-- Second Origin -->
                                        <section class="mt-5">
                                            <div class="row">
                                                <div class="col-12">
                                                    <h5 class="danny--group-title">return</h5>
                                                </div>
                                            </div>

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
                                                        <b-input-group class="flex-nowrap">
                                                            <b-input-group-prepend>
                                                                <div class="btn">
                                                                    <b-icon icon="geo-alt"></b-icon>
                                                                </div>
                                                            </b-input-group-prepend>
                                                            <multiselect
                                                                select-label=""
                                                                selected-label=""
                                                                deselect-label=""
                                                                v-model="form.bookingRequirements.reservation.roundTrip.origin"
                                                                track-by="place_id"
                                                                label="description"
                                                                :options="dropdowns.roundTrip.origins"
                                                                @search-change="fetchSearchResultFromGoogle($event, 'roundTrip', 'origin')"
                                                            >
                                                            </multiselect>
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
                                                        <b-input-group class="flex-nowrap">
                                                            <b-input-group-prepend>
                                                                <div class="btn">
                                                                    <b-icon icon="geo-alt"></b-icon>
                                                                </div>
                                                            </b-input-group-prepend>
                                                            <multiselect
                                                                select-label=""
                                                                selected-label=""
                                                                deselect-label=""
                                                                v-model="form.bookingRequirements.reservation.roundTrip.destination"
                                                                track-by="place_id"
                                                                label="description"
                                                                :options="dropdowns.roundTrip.destinations"
                                                                @search-change="fetchSearchResultFromGoogle($event, 'roundTrip', 'destination')"
                                                            >
                                                            </multiselect>
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
                                                                min="1"
                                                                type="number"
                                                                v-model="$v.form.bookingRequirements.reservation.roundTrip.passengers.$model">
                                                            </b-form-input>
                                                            <b-input-group-append>
                                                                <b-button-group size="sm">
                                                                    <b-button
                                                                        @click="increasePassengers('roundTrip')"
                                                                        variant="outline-dark">
                                                                        <b-icon icon="plus-circle"></b-icon>
                                                                    </b-button>
                                                                    <b-button
                                                                        @click="decreasePassengers('roundTrip')"
                                                                        variant="outline-dark">
                                                                        <b-icon icon="dash-circle"></b-icon>
                                                                    </b-button>
                                                                </b-button-group>
                                                            </b-input-group-append>
                                                        </b-input-group>
                                                    </b-form-group>
                                                </div>

                                                <div class="col-12 col-lg-6">
                                                    <b-form-group
                                                        class="danny--form-group"
                                                        label="Luggages"
                                                        label-for="round-trip-luggages"
                                                        label-cols="12"
                                                        label-cols-sm="3"
                                                        content-cols="12"
                                                        content-cols-sm="9"
                                                        :invalid-feedback="'Minimum luggages is 1'"
                                                        :state="validateInputField($v.form.bookingRequirements.reservation.roundTrip.luggages)">
                                                        <b-input-group>
                                                            <b-input-group-prepend>
                                                                <div class="btn">
                                                                    <b-icon icon="briefcase"></b-icon>
                                                                </div>
                                                            </b-input-group-prepend>
                                                            <b-form-input
                                                                no-wheel
                                                                id="round-trip-luggages"
                                                                min="0"
                                                                type="number"
                                                                v-model="$v.form.bookingRequirements.reservation.roundTrip.luggages.$model">
                                                            </b-form-input>
                                                            <b-input-group-append>
                                                                <div
                                                                    class="btn"
                                                                    v-b-tooltip.hover
                                                                    title="Each person has 1 free luggage and 1 free small bag. Extra luggage or bag will be charged $10 each."
                                                                    >
                                                                    <b-icon icon="question-circle"></b-icon>
                                                                </div>
                                                                <b-button-group size="sm">
                                                                    <b-button
                                                                        @click="increaseLuggages('roundTrip')"
                                                                        variant="outline-dark">
                                                                        <b-icon icon="plus-circle"></b-icon>
                                                                    </b-button>
                                                                    <b-button
                                                                        @click="decreaseLuggages('roundTrip')"
                                                                        variant="outline-dark">
                                                                        <b-icon icon="dash-circle"></b-icon>
                                                                    </b-button>
                                                                </b-button-group>
                                                            </b-input-group-append>
                                                        </b-input-group>
                                                    </b-form-group>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12 col-lg-6">
                                                    <b-form-group
                                                        class="danny--form-group"
                                                        label="Has rest stop?"
                                                        label-for="round-trip-rest-stop-flag"
                                                        label-cols="12"
                                                        label-cols-sm="3"
                                                        content-cols="12"
                                                        content-cols-sm="9"
                                                        :invalid-feedback="errorMessages.required"
                                                        :state="validateInputField($v.form.bookingRequirements.reservation.roundTrip.hasRestStop)">
                                                        <b-form-checkbox
                                                            name="round-trip-rest-stop-flag"
                                                            size="lg"
                                                            value="1"
                                                            unchecked-value="0"
                                                            id="round-trip-rest-stop-flag"
                                                            v-model="$v.form.bookingRequirements.reservation.roundTrip.hasRestStop.$model">
                                                        </b-form-checkbox>
                                                    </b-form-group>
                                                </div>

                                                <template v-if="$v.form.bookingRequirements.reservation.roundTrip.hasRestStop.$model === '1'">
                                                    <div class="col-12 col-lg-6">
                                                        <b-form-group
                                                            class="danny--form-group"
                                                            label="Rest stop"
                                                            label-for="round-trip-rest-stop"
                                                            label-cols="12"
                                                            label-cols-sm="3"
                                                            content-cols="12"
                                                            content-cols-sm="9"
                                                            :invalid-feedback="errorMessages.required"
                                                            :state="validateInputField($v.form.bookingRequirements.reservation.roundTrip.restStop)">
                                                            <b-input-group class="flex-nowrap">
                                                                <b-input-group-prepend>
                                                                    <div class="btn">
                                                                        <b-icon icon="geo-alt"></b-icon>
                                                                    </div>
                                                                </b-input-group-prepend>
                                                                <multiselect
                                                                    select-label=""
                                                                    selected-label=""
                                                                    deselect-label=""
                                                                    id="one-way-rest-stop"
                                                                    v-model="$v.form.bookingRequirements.reservation.roundTrip.restStop.$model"
                                                                    track-by="place_id"
                                                                    label="description"
                                                                    :options="dropdowns.roundTrip.restStops"
                                                                    @search-change="fetchSearchResultFromGoogle($event, 'roundTrip', 'restStop')"
                                                                    >
                                                                </multiselect>
                                                            </b-input-group>
                                                        </b-form-group>
                                                    </div>
                                                </template>
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

                            <section>
                                <h5 class="danny--group-title">Picking-up</h5>
                                <template v-if="vehicles.oneWayTrip.length > 0">
                                    <div
                                        class="row align-items-center p-4 mb-3 bg-white"
                                        v-for="vehicle in vehicles.oneWayTrip">
                                        <div class="col-12 col-md-6 col-lg-3">
                                            <img :src="'<?= base_url('static/images/vehicles/') ?>/' + vehicle.carImage" class="img-fluid" />
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-3 col-lg-3">
                                            <p class="danny--car danny--car-name">
                                                {{ vehicle.carName }}
                                            </p>
                                            <p class="danny--car danny--car-capacity">
                                                <span class="d-block"><b-icon icon="people"></b-icon> {{ vehicle.maxPassengers }}</span>
                                                <span class="d-block"><b-icon icon="briefcase"></b-icon> {{ vehicle.maxLuggages }}</span>
                                            </p>
                                            <p :class="{ 'danny--car danny--car-availability': true, 'text-danger': !vehicle.available }">
                                                {{ !vehicle.available ? 'Out of service' : 'Available' }}
                                            </p>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-3 col-lg-3">
                                            <p class="danny--car danny--car-price">&dollar;{{ vehicle.openDoorPrice }}</p>
                                        </div>
                                        <div class="col-12 col-lg-3 text-right">
                                            <b-form-radio
                                                :disabled="!vehicle.available"
                                                v-model="$v.form.bookingRequirements.selectCar.oneWayTrip.vehicle.$model"
                                                name="one-way-vehicle"
                                                :value="vehicle"
                                                button
                                                button-variant="outline-primary">
                                                Select
                                            </b-form-radio>
                                        </div>
                                    </div>
                                </template>
                                <template v-if="vehicles.oneWayTrip.length === 0">
                                    Sorry! There are no available cars at the moment.
                                </template>
                            </section>

                            <section class="mt-4" v-if="isRoundTrip">
                                <h5 class="danny--group-title">Return</h5>
                                <template v-if="vehicles.roundTrip.length > 0">
                                    <div
                                        class="row align-items-center p-4 mb-3 bg-white"
                                        v-for="vehicle in vehicles.roundTrip">
                                        <div class="col-12 col-md-6 col-lg-3">
                                            <img :src="'<?= base_url('static/images/vehicles/') ?>/' + vehicle.carImage" class="img-fluid" />
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-3 col-lg-3">
                                            <p class="danny--car danny--car-name">
                                                {{ vehicle.carName }}
                                            </p>
                                            <p class="danny--car danny--car-capacity">
                                                <span class="d-block"><b-icon icon="people"></b-icon> {{ vehicle.maxPassengers }}</span>
                                                <span class="d-block"><b-icon icon="briefcase"></b-icon> {{ vehicle.maxLuggages }}</span>
                                            </p>
                                            <p :class="{ 'danny--car danny--car-availability': true, 'text-danger': !vehicle.available }">
                                                {{ !vehicle.available ? 'Out of service' : 'Available' }}
                                            </p>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-3 col-lg-3">
                                            <p class="danny--car danny--car-price">&dollar;{{ vehicle.openDoorPrice }}</p>
                                        </div>
                                        <div class="col-12 col-lg-3 text-right">
                                            <b-form-radio
                                                :disabled="!vehicle.available"
                                                v-model="$v.form.bookingRequirements.selectCar.roundTrip.vehicle.$model"
                                                name="round-trip-vehicle"
                                                :value="vehicle"
                                                button
                                                button-variant="outline-primary">
                                                Select
                                            </b-form-radio>
                                        </div>
                                    </div>
                                </template>
                                <template v-if="vehicles.roundTrip.length === 0">
                                    Sorry! There are no available cars at the moment.
                                </template>
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
                                            <b-form-group>
                                                <div
                                                    class="row align-items-center mb-2"
                                                    v-for="(extraOption, extraOptionIndex) in options.oneWayTrip.extras"
                                                    :key="`oneway-extras-${extraOptionIndex}`">
                                                    <div class="col-12 col-lg-6 d-flex align-items-center">
                                                        <b-form-checkbox
                                                            name="options-extras"
                                                            v-model="form.bookingRequirements.chooseOptions.oneWayTrip.extras"
                                                            :value="extraOption">
                                                            {{ extraOption.configName }}
                                                        </b-form-checkbox>
                                                        <div
                                                            v-if="extraOption.configHasTooltip === '1'"
                                                            class="btn btn-sm"
                                                            v-b-tooltip.hover
                                                            :title="extraOption.configTooltipContent"
                                                            >
                                                            <b-icon icon="question-circle"></b-icon>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-lg-6">
                                                        <div class="d-flex align-items-center">
                                                            <span class="danny--car-option-price col-4">
                                                                &dollar;{{ extraOption.configValue }}
                                                            </span>
                                                            <b-input-group v-if="extraOption.configCountable === '1'">
                                                                <b-form-input
                                                                    class="readonly"
                                                                    readonly
                                                                    no-wheel
                                                                    step="1"
                                                                    class="ml-2 max-width-100"
                                                                    :disabled="!_.some(form.bookingRequirements.chooseOptions.oneWayTrip.extras, extraOption)"
                                                                    type="number"
                                                                    min="1"
                                                                    :max="extraOption.configMaximumQuantity"
                                                                    v-model="extraOption.quantity"
                                                                    placeholder="Quantity">
                                                                </b-form-input>
                                                                <b-input-group-append>
                                                                    <b-button-group size="sm">
                                                                        <b-button
                                                                            :disabled="!_.some(form.bookingRequirements.chooseOptions.oneWayTrip.extras, extraOption)"
                                                                            @click="() => { if (extraOption.quantity >= 0 && extraOption.quantity < extraOption.configMaximumQuantity) { extraOption.quantity++ } }"
                                                                            variant="outline-dark">
                                                                            <b-icon icon="plus-circle"></b-icon>
                                                                        </b-button>
                                                                        <b-button
                                                                            :disabled="!_.some(form.bookingRequirements.chooseOptions.oneWayTrip.extras, extraOption)"
                                                                            @click="() => { if (extraOption.quantity > 1) { extraOption.quantity-- } }"
                                                                            variant="outline-dark">
                                                                            <b-icon icon="dash-circle"></b-icon>
                                                                        </b-button>
                                                                    </b-button-group>
                                                                </b-input-group-append>
                                                            </b-input-group>
                                                        </div>
                                                    </div>
                                                </div>
                                            </b-form-group>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="bg-white p-3 h-100">
                                            <h5 class="danny--group-title">Protection</h5>
                                            <b-form-group>
                                                <div
                                                    class="row align-items-center mb-2"
                                                    v-for="(protectionOption, protectionOptionIndex) in options.oneWayTrip.protection"
                                                    :key="`oneway-protection-${protectionOptionIndex}`">
                                                    <div class="col-12 col-lg-6">
                                                        <b-form-checkbox
                                                            name="options-protection"
                                                            v-model="form.bookingRequirements.chooseOptions.oneWayTrip.protection"
                                                            :value="protectionOption">
                                                            {{ protectionOption.configName }}
                                                        </b-form-checkbox>
                                                    </div>
                                                    <div class="col-12 col-lg-6">
                                                        <div class="d-flex align-items-center">
                                                            <span class="danny--car-option-price col-4">
                                                                &dollar;{{ protectionOption.configValue }}
                                                            </span>
                                                            <b-input-group v-if="protectionOption.configCountable === '1'">
                                                                <b-form-input
                                                                    class="readonly"
                                                                    readonly
                                                                    no-wheel
                                                                    step="1"
                                                                    class="ml-2 max-width-100"
                                                                    :disabled="!_.some(form.bookingRequirements.chooseOptions.oneWayTrip.protection, protectionOption)"
                                                                    type="number"
                                                                    min="1"
                                                                    :max="protectionOption.configMaximumQuantity"
                                                                    v-model="protectionOption.quantity"
                                                                    placeholder="Quantity">
                                                                </b-form-input>
                                                                <b-input-group-append>
                                                                    <b-button-group size="sm">
                                                                        <b-button
                                                                            disabled
                                                                            variant="outline-dark">
                                                                            <b-icon icon="plus-circle"></b-icon>
                                                                        </b-button>
                                                                        <b-button
                                                                            disabled
                                                                            variant="outline-dark">
                                                                            <b-icon icon="dash-circle"></b-icon>
                                                                        </b-button>
                                                                    </b-button-group>
                                                                </b-input-group-append>
                                                            </b-input-group>
                                                        </div>
                                                    </div>
                                                </div>
                                            </b-form-group>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section
                                class="mt-4"
                                v-if="isRoundTrip">
                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="danny--group-title">return</h5>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="bg-white p-3 h-100">
                                            <h5 class="danny--group-title">Extras</h5>
                                            <b-form-group>
                                                <div
                                                    class="row align-items-center mb-2"
                                                    v-for="(roundTripExtraOption, roundTripExtraOptionIndex) in options.roundTrip.extras"
                                                    :key="`roundtrip-extras-${roundTripExtraOptionIndex}`">
                                                    <div class="col-6 d-flex align-items-center">
                                                        <b-form-checkbox
                                                            name="round-trip-options-extras"
                                                            v-model="form.bookingRequirements.chooseOptions.roundTrip.extras"
                                                            :value="roundTripExtraOption">
                                                            {{ roundTripExtraOption.configName }}
                                                        </b-form-checkbox>
                                                        <div
                                                            v-if="roundTripExtraOption.configHasTooltip === '1'"
                                                            class="btn btn-sm"
                                                            v-b-tooltip.hover
                                                            :title="roundTripExtraOption.configTooltipContent"
                                                            >
                                                            <b-icon icon="question-circle"></b-icon>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="d-flex align-items-center">
                                                            <span class="danny--car-option-price col-4">
                                                                &dollar;{{ roundTripExtraOption.configValue }}
                                                            </span>
                                                            <b-input-group v-if="roundTripExtraOption.configCountable === '1'">
                                                                <b-form-input
                                                                    class="readonly"
                                                                    readonly
                                                                    no-wheel
                                                                    step="1"
                                                                    class="ml-2 max-width-100"
                                                                    :disabled="!_.some(form.bookingRequirements.chooseOptions.roundTrip.extras, roundTripExtraOption)"
                                                                    type="number"
                                                                    min="1"
                                                                    :max="roundTripExtraOption.configMaximumQuantity"
                                                                    v-model="roundTripExtraOption.quantity"
                                                                    placeholder="Quantity">
                                                                </b-form-input>
                                                                <b-input-group-append>
                                                                    <b-button-group size="sm">
                                                                        <b-button
                                                                            :disabled="!_.some(form.bookingRequirements.chooseOptions.roundTrip.extras, roundTripExtraOption)"
                                                                            @click="() => { if (roundTripExtraOption.quantity >= 0 && roundTripExtraOption.quantity < roundTripExtraOption.configMaximumQuantity) { roundTripExtraOption.quantity++ } }"
                                                                            variant="outline-dark">
                                                                            <b-icon icon="plus-circle"></b-icon>
                                                                        </b-button>
                                                                        <b-button
                                                                            :disabled="!_.some(form.bookingRequirements.chooseOptions.roundTrip.extras, roundTripExtraOption)"
                                                                            @click="() => { if (roundTripExtraOption.quantity > 1) { roundTripExtraOption.quantity-- } }"
                                                                            variant="outline-dark">
                                                                            <b-icon icon="dash-circle"></b-icon>
                                                                        </b-button>
                                                                    </b-button-group>
                                                                </b-input-group-append>
                                                            </b-input-group>
                                                        </div>
                                                    </div>
                                                </div>
                                            </b-form-group>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="bg-white p-3 h-100">
                                            <h5 class="danny--group-title">Protection</h5>
                                            <b-form-group>
                                                <div
                                                    class="row align-items-center mb-2"
                                                    v-for="(roundTripProtectionOption, roundTripProtectionOptionIndex) in options.roundTrip.protection"
                                                    :key="`roundtrip-protection-${roundTripProtectionOptionIndex}`">
                                                    <div class="col-6">
                                                        <b-form-checkbox
                                                            name="round-trip-options-protection"
                                                            v-model="form.bookingRequirements.chooseOptions.roundTrip.protection"
                                                            :value="roundTripProtectionOption">
                                                            {{ roundTripProtectionOption.configName }}
                                                        </b-form-checkbox>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="d-flex align-items-center">
                                                            <span class="danny--car-option-price col-4">
                                                                &dollar;{{ roundTripProtectionOption.configValue }}
                                                            </span>
                                                            <b-input-group v-if="roundTripProtectionOption.configCountable === '1'">
                                                                <b-form-input
                                                                    readonly
                                                                    class="readonly"
                                                                    no-wheel
                                                                    step="1"
                                                                    class="ml-2 max-width-100"
                                                                    :disabled="!_.some(form.bookingRequirements.chooseOptions.roundTrip.protection, roundTripProtectionOption)"
                                                                    type="number"
                                                                    min="1"
                                                                    :max="roundTripProtectionOption.configMaximumQuantity"
                                                                    v-model="roundTripProtectionOption.quantity"
                                                                    placeholder="Quantity">
                                                                </b-form-input>
                                                                <b-input-group-append>
                                                                    <b-button-group size="sm">
                                                                        <b-button
                                                                            disabled
                                                                            variant="outline-dark">
                                                                            <b-icon icon="plus-circle"></b-icon>
                                                                        </b-button>
                                                                        <b-button
                                                                            disabled
                                                                            variant="outline-dark">
                                                                            <b-icon icon="dash-circle"></b-icon>
                                                                        </b-button>
                                                                    </b-button-group>
                                                                </b-input-group-append>
                                                            </b-input-group>
                                                        </div>
                                                    </div>
                                                </div>
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
                                        <section class="mb-2">
                                            <h5 class="danny--group-title">Contact info</h5>
                                            <div class="row">
                                                <div class="col-12 col-lg-6">
                                                    <b-form-group
                                                        :invalid-feedback="errorMessages.required"
                                                        :state="validateInputField($v.form.bookingRequirements.review.customer.firstName)">
                                                        <b-form-input
                                                            :disabled="form.loginForm.hasRegistered"
                                                            autocomplete="given-name"
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
                                                            :disabled="form.loginForm.hasRegistered"
                                                            autocomplete="family-name"
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
                                                            :disabled="form.loginForm.hasRegistered"
                                                            autocomplete="tel"
                                                            placeholder="Mobile number"
                                                            type="tel"
                                                            v-model="$v.form.bookingRequirements.review.customer.contact.mobileNumber.$model">
                                                        </b-form-input>
                                                    </b-form-group>
                                                </div>

                                                <div class="col-12 col-lg-6">
                                                    <b-form-group
                                                        :invalid-feedback="errorMessageEmail"
                                                        :state="validateInputField($v.form.bookingRequirements.review.customer.contact.email)">
                                                        <b-form-input
                                                            :disabled="form.loginForm.hasRegistered"
                                                            autocomplete="email"
                                                            placeholder="Email address"
                                                            type="email"
                                                            v-model="$v.form.bookingRequirements.review.customer.contact.email.$model"
                                                            @input="populateRegisterAccountEmail">
                                                        </b-form-input>
                                                    </b-form-group>
                                                </div>
                                            </div>

                                            <div class="row" v-if="!(form.loginForm.hasRegistered)">
                                                <div class="col-12 mb-3 text-right">
                                                    <span class="d-inline-block mr-2">Already have an account?</span>
                                                    <b-button @click="toggleAccountLoginForm">Login</b-button>
                                                </div>

                                                <div class="col-12">
                                                    <b-alert
                                                        :show="true"
                                                        variant="info"
                                                        class="mb-1"
                                                    >
                                                        Registering account to have following benefits:
                                                        <ul class="m-0">
                                                            <li class="m-0">Better keep track of bookings history.</li>
                                                            <li class="m-0">Automatically fill out information on payment step.</li>
                                                            <li class="m-0">Receive discount coupons on special events.</li>
                                                        </ul>
                                                    </b-alert>
                                                </div>

                                                <div class="col-12">
                                                    <b-form-group>
                                                        <b-form-checkbox
                                                            name="review-create-account"
                                                            size="md"
                                                            id="review-create-account"
                                                            v-model="$v.form.bookingRequirements.review.customer.registerAccount.$model">
                                                            Register account?
                                                        </b-form-checkbox>
                                                    </b-form-group>
                                                </div>
                                            </div>

                                            <template v-if="!form.loginForm.hasRegistered && form.bookingRequirements.review.customer.registerAccount">
                                                <div class="row">
                                                    <div class="col-12 col-lg-6">
                                                        <b-form-group
                                                            :invalid-feedback="errorMessages.required"
                                                            :state="validateInputField($v.form.bookingRequirements.review.customer.account.email)"
                                                            >
                                                            <b-form-input
                                                                :disabled="form.bookingRequirements.review.customer.account.sameAsContactEmail"
                                                                type="email"
                                                                placeholder="Email"
                                                                name="review-create-account-email"
                                                                id="review-create-account-email"
                                                                v-model="$v.form.bookingRequirements.review.customer.account.email.$model">
                                                            </b-form-input>
                                                        </b-form-group>
                                                    </div>

                                                    <div class="col-12 col-lg-6">
                                                        <b-form-group>
                                                            <b-form-checkbox
                                                                @input="toggleRegisterAccountEmail"
                                                                name="review-create-account-same-as-contact"
                                                                size="md"
                                                                id="review-create-account-same-as-contact"
                                                                v-model="$v.form.bookingRequirements.review.customer.account.sameAsContactEmail.$model">
                                                                Same as contact email?
                                                            </b-form-checkbox>
                                                        </b-form-group>
                                                    </div>
                                                </div>

                                                <div
                                                    v-if="alerts.emailAlreadyExisted.show"
                                                    class="row"
                                                >
                                                    <div class="col-12">
                                                        <b-alert
                                                            variant="danger"
                                                            show="8"
                                                            @dismissed="() => alerts.emailAlreadyExisted.show = false"
                                                        >
                                                            Email is already in used. Please choose another one.
                                                        </b-alert>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-12 col-lg-6">
                                                        <b-form-group
                                                            :invalid-feedback="errorMessages.required"
                                                            :state="validateInputField($v.form.bookingRequirements.review.customer.account.password)"
                                                        >
                                                            <b-form-input
                                                                type="password"
                                                                placeholder="Password"
                                                                name="review-create-account-password"
                                                                id="review-create-account-password"
                                                                v-model="$v.form.bookingRequirements.review.customer.account.password.$model">
                                                            </b-form-input>
                                                        </b-form-group>
                                                    </div>

                                                    <div class="col-12 col-lg-6">
                                                        <b-form-group
                                                            :invalid-feedback="errorMessages.required"
                                                            :state="validateInputField($v.form.bookingRequirements.review.customer.account.confirmPassword)"
                                                        >
                                                            <b-form-input
                                                                type="password"
                                                                placeholder="Confirm password"
                                                                name="review-create-account-confirm-password"
                                                                id="review-create-account-confirm-password"
                                                                v-model="$v.form.bookingRequirements.review.customer.account.confirmPassword.$model">
                                                            </b-form-input>
                                                        </b-form-group>
                                                    </div>
                                                </div>
                                            </template>
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
                                                        <b-button class="btn" title="Edit vehicle" @click="() => { formActiveTabIndex = 1 }">
                                                            <b-icon icon="pencil-square"></b-icon>
                                                        </b-button>
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
                                                        <b-button class="btn" title="Edit pick-up" @click="() => { formActiveTabIndex = 0 }">
                                                            <b-icon icon="pencil-square"></b-icon>
                                                        </b-button>
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
                                                <div class="row" v-if="form.bookingRequirements.reservation.oneWayTrip.hasRestStop">
                                                    <div class="col-12 col-md-3">
                                                        <span class="danny--font-weight-bold">Intermediary:</span>
                                                    </div>
                                                    <div class="col-12 col-md-9">
                                                        {{
                                                            oneWayTripRestStop
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
                                                                <b-button class="btn" title="Edit chosen options" @click="() => { formActiveTabIndex = 2 }">
                                                                    <b-icon icon="pencil-square"></b-icon>
                                                                </b-button>
                                                            </div>
                                                        </div>
                                                    </section>

                                                    <section v-if="form.bookingRequirements.chooseOptions.oneWayTrip.extras.length > 0">
                                                        <div
                                                            class="row"
                                                            v-for="option in form.bookingRequirements.chooseOptions.oneWayTrip.extras">
                                                            <div class="col-8">
                                                                {{ option.configName }} (&times;{{ option.quantity }})
                                                            </div>
                                                            <div class="col-4">
                                                                <span class="danny--car-option-price">
                                                                    &dollar;{{ (parseFloat(option.configValue) * parseFloat(option.quantity)).toFixed(2) }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </section>

                                                    <section v-if="form.bookingRequirements.chooseOptions.oneWayTrip.protection.length > 0">
                                                        <div
                                                            class="row"
                                                            v-for="option in form.bookingRequirements.chooseOptions.oneWayTrip.protection">
                                                            <div class="col-8">
                                                                {{ option.configName }} (&times;{{ option.quantity }})
                                                            </div>
                                                            <div class="col-4">
                                                                <span class="danny--car-option-price">
                                                                    &dollar;{{ (parseFloat(option.configValue) * parseFloat(option.quantity)).toFixed(2) }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </section>
                                                </section>

                                                <!-- Extra luggages -->
                                                <section v-if="extraLuggages.oneWayTrip.extras > 0" class="mt-5">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <h5 class="danny--group-title">Luggages</h5>
                                                        </div>
                                                        <div class="col-2">
                                                            <b-button class="btn" title="Edit luggages" @click="() => { formActiveTabIndex = 0 }">
                                                                <b-icon icon="pencil-square"></b-icon>
                                                            </b-button>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-8">
                                                            Extra luggages (&times;{{ extraLuggages.oneWayTrip.extras }})
                                                        </div>
                                                        <div class="col-4">
                                                            <span class="danny--car-option-price">
                                                                &dollar;{{ extraLuggages.oneWayTrip.extrasPrice }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </section>

                                                <!-- Admin/Pickup fees -->
                                                <section class="mt-5">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <h5 class="danny--group-title">Fees</h5>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-8">
                                                            Admin fee
                                                        </div>
                                                        <div class="col-4">
                                                            <span class="danny--car-option-price">
                                                                &dollar;{{ form.bookingRequirements.review.prices.adminFee.oneWayTrip }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-8">
                                                            Pick-up fee
                                                        </div>
                                                        <div class="col-4">
                                                            <span class="danny--car-option-price">
                                                                &dollar;{{ form.bookingRequirements.review.prices.pickupFee.oneWayTrip }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </section>

                                                <!-- Total -->
                                                <section class="mt-5">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <h5 class="danny--group-title">Route price</h5>
                                                        </div>
                                                    </div>
                                                </section>
                                                
                                                <section>
                                                    <div class="row">
                                                        <div class="col-12 col-lg-8">
                                                            <span class="danny--review-payment-total-text">
                                                                Route total - {{ oneWayTripRouteMiles }}
                                                            </span>
                                                        </div>
                                                        <div class="col-12 col-lg-4">
                                                            <p class="danny--review-payment-total-price m-0">
                                                                &dollar;{{ form.bookingRequirements.review.prices.oneWayTrip }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </section>
                                            </section>
                                        </div>

                                        <!-- Round trip -->
                                        <template v-if="isRoundTrip">
                                            <div class="bg-white p-4 mt-3">
                                                <section>
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <h5 class="danny--group-title">Vehicle</h5>
                                                        </div>
                                                        <div class="col-2">
                                                            <b-button class="btn" title="Edit vehicle" @click="() => { formActiveTabIndex = 1 }">
                                                                <b-icon icon="pencil-square"></b-icon>
                                                            </b-button>
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
                                                            <b-button class="btn" title="Edit pick-up" @click="() => { formActiveTabIndex = 0 }">
                                                                <b-icon icon="pencil-square"></b-icon>
                                                            </b-button>
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
                                                    <div class="row" v-if="form.bookingRequirements.reservation.roundTrip.hasRestStop">
                                                        <div class="col-12 col-md-3">
                                                            <span class="danny--font-weight-bold">Intermediary:</span>
                                                        </div>
                                                        <div class="col-12 col-md-9">
                                                            {{
                                                                roundTripRestStop
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
                                                                    <b-button class="btn" title="Edit chosen options" @click="() => { formActiveTabIndex = 2 }">
                                                                        <b-icon icon="pencil-square"></b-icon>
                                                                    </b-button>
                                                                </div>
                                                            </div>
                                                        </section>

                                                        <section v-if="form.bookingRequirements.chooseOptions.roundTrip.extras.length > 0">
                                                            <div
                                                                class="row"
                                                                v-for="option in form.bookingRequirements.chooseOptions.roundTrip.extras">
                                                                <div class="col-8">
                                                                    {{ option.configName }} (&times;{{ option.quantity }})
                                                                </div>
                                                                <div class="col-4">
                                                                    <span class="danny--car-option-price">
                                                                        &dollar;{{ (parseFloat(option.configValue) * parseFloat(option.quantity)).toFixed(2) }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </section>

                                                        <section v-if="form.bookingRequirements.chooseOptions.roundTrip.protection.length > 0">
                                                            <div
                                                                class="row"
                                                                v-for="option in form.bookingRequirements.chooseOptions.roundTrip.protection">
                                                                <div class="col-8">
                                                                    {{ option.configName }} (&times;{{ option.quantity }})
                                                                </div>
                                                                <div class="col-4">
                                                                    <span class="danny--car-option-price">
                                                                        &dollar;{{ (parseFloat(option.configValue) * parseFloat(option.quantity)).toFixed(2) }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </section>
                                                    </section>

                                                    <!-- Extra luggages -->
                                                    <section v-if="extraLuggages.roundTrip.extras > 0" class="mt-5">
                                                        <div class="row">
                                                            <div class="col-10">
                                                                <h5 class="danny--group-title">Luggages</h5>
                                                            </div>
                                                            <div class="col-2">
                                                                <b-button class="btn" title="Edit luggages" @click="() => { formActiveTabIndex = 0 }">
                                                                    <b-icon icon="pencil-square"></b-icon>
                                                                </b-button>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-8">
                                                                Extra luggages (&times;{{ extraLuggages.roundTrip.extras }})
                                                            </div>
                                                            <div class="col-4">
                                                                <span class="danny--car-option-price">
                                                                    &dollar;{{ extraLuggages.roundTrip.extrasPrice }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </section>

                                                    <!-- Admin/Pickup fees -->
                                                    <section class="mt-5">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <h5 class="danny--group-title">Fees</h5>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-8">
                                                                Admin fee
                                                            </div>
                                                            <div class="col-4">
                                                                <span class="danny--car-option-price">
                                                                    &dollar;{{ form.bookingRequirements.review.prices.adminFee.roundTrip }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-8">
                                                                Pick-up fee
                                                            </div>
                                                            <div class="col-4">
                                                                <span class="danny--car-option-price">
                                                                    &dollar;{{ form.bookingRequirements.review.prices.pickupFee.roundTrip }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </section>

                                                    <!-- Total -->
                                                    <section class="mt-5">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <h5 class="danny--group-title">Route price</h5>
                                                            </div>
                                                        </div>
                                                    </section>
                                                    
                                                    <section>
                                                        <div class="row">
                                                            <div class="col-12 col-lg-8">
                                                                <span class="danny--review-payment-total-text">
                                                                    Route total - {{ roundTripRouteMiles }}
                                                                </span>
                                                            </div>
                                                            <div class="col-12 col-lg-4">
                                                                <p class="danny--review-payment-total-price m-0">
                                                                    &dollar;{{ form.bookingRequirements.review.prices.roundTrip }}
                                                                </p>
                                                            </div>
                                                        </div>
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

            <!-- Our competitve benefits -->
            <div class="row mt-5">
                <div class="col-12 text-center">
                    <h2 class="text-white">Our competitve benefits</h2>
                </div>
                <div class="col-12">
                    <table class="table table-bordered table-hover table-light table-striped mb-0">
                        <thead>
                            <tr>
                                <th>Hello Shuttle</th>
                                <th>Other booking providers</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    We pick you up right in front of your terminal
                                </td>
                                <td>
                                    You must take the airport bus to the transportation lot outside the airport to meet your driver
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="m-0">FREE child booster charges</p>
                                    <p class="m-0">Child car seat charge only &dollar;20/each</p>
                                </td>
                                <td>
                                    <p class="m-0">No free child booster</p>
                                    <p class="m-0">Car seat charge a lot more</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    If you reschedule your reservation within 2 hours prior to your pickup time.
                                    You will need to cancel with 50&percnt; refund and book a new one.
                                </td>
                                <td>
                                    No refund and has to book a new one.
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    If you cancel your reservation within 18-24 hours prior to your pickup time, there is
                                    50&percnt; refund to your card
                                </td>
                                <td>
                                    No refund
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Do not charge any tax on our fares
                                </td>
                                <td>
                                    Taxes added at the end of your booking
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Pet cleaning fee is 35&dollar; for total trip regardless of the
                                    numbers of pets
                                </td>
                                <td>
                                    Charges depend on the number of pets
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Frequently asked questions -->
            <div class="row mt-5">
                <div class="col-12 text-center">
                    <h2 class="text-white m-0">Frequently asked questions</h2>
                </div>
            </div>
            <?php if(count($policies) > 0): ?>
                <div class="row">
                    <?php if (count($policies) === 1): ?>
                        <div class="col-12">
                            <?= view('templates/snippets/FAQs', ['policies' => $policies, 'accordianName' => 'first-accordian']) ?>
                        </div>
                    <?php else: ?>
                        <?php
                            $midpoint = (int)(count($policies) / 2);
                            $first_half = array_slice($policies, 0, $midpoint);
                            $second_half = array_slice($policies, $midpoint);
                        ?>

                        <div class="col-12 col-lg-6">
                            <?= view('templates/snippets/FAQs', ['policies' => $first_half, 'accordianName' => 'first-accordian']) ?>
                        </div>
                        <div class="col-12 col-lg-6">
                            <?= view('templates/snippets/FAQs', ['policies' => $second_half, 'accordianName' => 'second-accordian']) ?>
                        </div>
                    <?php endif ?>
                </div>
            <?php endif ?>
        </div>

        <!-- Modals -->
        <b-modal
            :visible="modals.loginForm.show"
            title="Login"
            no-close-on-backdrop
            no-close-on-esc
            static
            @show="toggleAccountLoginForm(true)"
            @close="toggleAccountLoginForm(false)"
        >
            <b-alert
                variant="danger"
                show="5"
                v-if="form.loginForm.errorMessages.length > 0"
                @dismissed="() => form.loginForm.errorMessages = []"
            >
                {{ form.loginForm.errorMessages.join('\n') }}
            </b-alert>

            <b-form @submit="getRegisteredCustomerData" novalidate>
                <b-form-group
                    label="Email"
                    label-for="login-form-email"
                    :state="validateInputField($v.form.loginForm.registeredAccount.email)"
                    :invalid-feedback="errorMessages.required"
                >
                    <b-form-input
                        id="login-form-email"
                        v-model="$v.form.loginForm.registeredAccount.email.$model"
                        type="email"
                    >
                    </b-form-input>
                </b-form-group>

                <b-form-group
                    label="Password"
                    label-for="login-form-password"
                    :state="validateInputField($v.form.loginForm.registeredAccount.password)"
                    :invalid-feedback="errorMessages.required"
                >
                    <b-form-input
                        id="login-form-password"
                        v-model="$v.form.loginForm.registeredAccount.password.$model"
                        type="password"
                    >
                    </b-form-input>
                </b-form-group>
            </b-form>
            <template #modal-footer>
                <b-button
                    class="mx-3"
                    @click="getRegisteredCustomerData"
                >
                    Login
                </b-button>
            </template>
        </b-modal>
    </div>
<?= $this->endSection() ?>

<?= $this->section("page-scripts") ?>
    <script type="text/javascript">
        const baseURL = "<?= base_url('/') ?>";
        const bookingId = "<?= $bookingId ?>";
        const env = "<?= $enviroment ?>";
        const apiKey = "<?= $enviroment === 'production' ? 'AIzaSyBEGGWz3KOsiPnxuygccrvKGBJEJgxih3s' : 'AIzaSyB6QD0bdHEY5R9qoQ58VuFzdwm0YDLeSzA' ?>";
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
    <script src="<?= base_url('static/js/vendors/vue-multiselect.min.js') ?>" type="text/javascript"></script>

    <?php if ($enviroment === 'production'): ?>
        <script
            defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBEGGWz3KOsiPnxuygccrvKGBJEJgxih3s&libraries=places&callback=initMap">
        </script>
    <?php else: ?>
        <script
            defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB6QD0bdHEY5R9qoQ58VuFzdwm0YDLeSzA&libraries=places&callback=initMap">
        </script>
    <?php endif ?>

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
