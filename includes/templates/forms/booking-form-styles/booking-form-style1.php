<div class="row align-items-start">
    <div class="col">
        <div class="shadow p-3 mb-5 bg-white rounded">
            <h3>
                <span class="price-per-day">NaN</span> <small><span class="actual-price">$NaN</span></small>
            </h3>
            <form name="booking-form-style1">
                <div class="row gx-0">
                    <div class="col">
                        <input
                            type="text"
                            readonly
                            class="form-control start-date-crp date-fields"
                            placeholder="Start Date*"
                            id="startDateInput" />
                    </div>
                    <div class="col">
                        <select class="form-control start-time-crp time-fields">
                            <option value="8:00 AM">8:00 AM</option>
                            <option value="9:00 AM">9:00 AM</option>
                            <option value="10:00 AM">10:00 AM</option>
                            <option value="11:00 AM">11:00 AM</option>
                            <option value="12:00 PM">12:00 PM</option>
                            <option value="1:00 PM">1:00 PM</option>
                            <option value="2:00 PM">2:00 PM</option>
                            <option value="3:00 PM">3:00 PM</option>
                            <option value="4:00 PM">4:00 PM</option>
                            <option value="5:00 PM">5:00 PM</option>
                            <option value="6:00 PM">6:00 PM</option>
                            <option value="7:00 PM">7:00 PM</option>
                            <option value="8:00 PM">8:00 PM</option>
                        </select>
                    </div>
                </div>
                <br />
                <div class="row gx-0">
                    <div class="col">
                        <input
                            type="text"
                            readonly
                            class="form-control end-date-crp date-fields"
                            placeholder="End Date*"
                            id="endDateInput" />
                    </div>
                    <div class="col">
                        <select class="form-control end-time-crp time-fields">
                            <option value="8:00 AM">8:00 AM</option>
                            <option value="9:00 AM">9:00 AM</option>
                            <option value="10:00 AM">10:00 AM</option>
                            <option value="11:00 AM">11:00 AM</option>
                            <option value="12:00 PM">12:00 PM</option>
                            <option value="1:00 PM">1:00 PM</option>
                            <option value="2:00 PM">2:00 PM</option>
                            <option value="3:00 PM">3:00 PM</option>
                            <option value="4:00 PM">4:00 PM</option>
                            <option value="5:00 PM">5:00 PM</option>
                            <option value="6:00 PM">6:00 PM</option>
                            <option value="7:00 PM">7:00 PM</option>
                            <option value="8:00 PM">8:00 PM</option>
                        </select>
                    </div>
                </div>
                <br />
                <div class="d-grid gap-2">
                    <input
                        type="submit"
                        value="Next"
                        class="btn btn-primary next-btn" />
                </div>
                <br />
                <div class="display-pricing">
                    <div class="row gx-0">
                        <div class="col days-price" id="pricePerDayDisplay"></div>
                        <div class="col car-price" id="totalPricePerDayDisplay"></div>
                    </div>
                    <div class="discount-pricing-section">
                        <div class="row gx-0">
                            <div class="col days-price" id="discount-type"></div>
                            <div class="col car-price" id="discountDisplay"></div>
                        </div>
                    </div>
                    <div class="taxes-pricing-section">
                        <div class="row gx-0">
                            <div class="col days-price">Taxes & Fees</div>
                            <div class="col car-price" id="totalTaxFees"></div>
                        </div>
                    </div>
                    <hr />
                    <div class="row gx-0">
                        <div class="col total-crp Total-charges-crp">Total Charges</div>
                        <div class="col total-crp total-price-crp" id="totalPrice"></div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include CARRENTAL_PLUGIN_PATH . 'includes/templates/custom-date-picker/date-picker-style1.php';
