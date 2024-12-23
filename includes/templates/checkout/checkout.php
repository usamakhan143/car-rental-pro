   <!-- Progress Bar -->
   <div class="car-rental-pro-checkout">
       <div class="container">
           <div class="row justify-content-center">
               <div class="col-md-12">
                   <div class="progress-container">
                       <div class="row">
                           <div class="step col active" id="step1">
                               <i class="fas fa-check-circle"></i>
                               <p>Customer Info</p>
                           </div>
                           <div class="step col" id="step2">
                               <i class="fas fa-credit-card"></i>
                               <p>Pay</p>
                           </div>
                           <div class="step col" id="step3">
                               <i class="fas fa-check"></i>
                               <p>Done</p>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>

       <!-- Checkout Form -->
       <div class="container checkout-container">
           <div class="row">
               <div class="col-md-8">
                   <div class="checkout-card">
                       <!-- Loader HTML -->
                       <div id="loader">
                           <div class="spinner"></div>
                       </div>
                       <form id="step1Form" class="step-content">
                           <!-- <h5>When & Where</h5> -->
                           <!-- <div class="row">
                           <div class="form-group col-md-6">
                               <label>Start date</label>
                               <input
                                   type="text"
                                   class="form-control"
                                   value="2024-10-22"
                                   id="startDate"
                                   readonly />
                           </div>
                           <div class="form-group col-md-6">
                               <label>Time</label>
                               <input
                                   type="text"
                                   class="form-control"
                                   value="10:00"
                                   id="startTime"
                                   readonly />
                           </div>
                       </div>
                       <div class="row">
                           <div class="form-group col-md-6">
                               <label>End date</label>
                               <input
                                   type="text"
                                   class="form-control"
                                   value="2024-10-26"
                                   id="endDate"
                                   readonly />
                           </div>
                           <div class="form-group col-md-6">
                               <label>Time</label>
                               <input
                                   type="text"
                                   readonly
                                   class="form-control"
                                   value="10:00"
                                   id="endTime" />
                           </div>
                       </div> -->
                           <div class="row">
                               <div class="form-group col-md-12">
                                   <div class="row">
                                       <div class="col-md-6">
                                           <div class="btn-group" role="group" id="radioGroup">
                                               <input
                                                   type="radio"
                                                   class="btn-check"
                                                   name="btnradio"
                                                   id="pickupRadio"
                                                   autocomplete="off"
                                                   value="Pickup"
                                                   checked />
                                               <label class="btn btn-outline-primary" for="pickupRadio">Pickup</label>

                                               <input
                                                   type="radio"
                                                   class="btn-check"
                                                   name="btnradio"
                                                   id="deliveryRadio"
                                                   value="Delivery"
                                                   autocomplete="off" />
                                               <label
                                                   class="btn btn-outline-primary"
                                                   for="deliveryRadio">Delivery</label>
                                           </div>

                                       </div>

                                       <div class="col-md-6">
                                           <div class="form-check">
                                               <input
                                                   class="form-check-input"
                                                   type="checkbox"
                                                   id="oneWay" />
                                               <label class="form-check-label" for="oneWay">
                                                   One-way
                                               </label>
                                           </div>
                                       </div>


                                       <div class="form-group col-md-12" style="display: none;"
                                           id="delivery-address-container">
                                           <label>Delivery Address</label>
                                           <input
                                               type="text"
                                               class="form-control"
                                               id="delivery-address"
                                               placeholder="Delivery & return address" />
                                       </div>


                                       <div class="form-group col-md-12" id="return-address-container" style="display: none;">
                                           <label>Return Address</label>
                                           <input
                                               type="text"
                                               class="form-control"
                                               id="return-address"
                                               placeholder="Return Address" />
                                       </div>
                                   </div>
                               </div>
                           </div>

                           <h5>Customer Info</h5>
                           <div class="row">
                               <div class="form-group col-md-6">
                                   <label>First name</label>
                                   <input
                                       type="text"
                                       class="form-control"
                                       id="firstName"
                                       required
                                       placeholder="First name" />
                               </div>
                               <div class="form-group col-md-6">
                                   <label>Last name</label>
                                   <input
                                       type="text"
                                       class="form-control"
                                       id="lastName"
                                       placeholder="Last name" />
                               </div>
                           </div>
                           <div class="row">
                               <div class="form-group col-md-12">
                                   <label>Email address</label>
                                   <input
                                       type="email"
                                       class="form-control"
                                       placeholder="Email"
                                       required
                                       id="emailAddress" />
                               </div>
                           </div>
                           <div class="row">
                               <div class="form-group col-md-6">
                                   <label>Phone number</label>
                                   <input
                                       type="text"
                                       class="form-control"
                                       placeholder="Phone number"
                                       required
                                       id="phoneNum" />
                               </div>
                               <div class="form-group col-md-6">
                                   <label>Select age</label>
                                   <select class="form-control" id="selectAge">
                                       <option value="">Select age</option>
                                       <option value="18-25">18-25</option>
                                       <option value="26-35">26-35</option>
                                       <option value="36-50">36-50</option>
                                   </select>
                               </div>
                           </div>
                           <div class="d-grid gap-2">
                               <button id="nextButton" class="btn btn-primary btn-block">
                                   Next
                               </button>
                           </div>
                       </form>
                       <!-- Step 2: Payment Form -->
                       <form id="step2Form" class="step-content" style="display: none">
                           <div class="form-check form-switch">
                               <input class="form-check-input" type="checkbox" id="gatewayToggle">
                               <label class="form-check-label" for="gatewayToggle">Pay cash on arrival</label>
                           </div>
                           <div id="paywithcard">
                               <h5>Payment Details</h5>
                               <!-- <div class="form-group">
                <label for="cardName">Name on Card</label>
                <input
                  type="text"
                  id="cardName"
                  class="form-control"
                  placeholder="Name on Card"
                />
              </div> -->
                               <div class="form-group">
                                   <label for="cardNumber">Card Number</label>
                                   <input
                                       type="text"
                                       id="cardNumber"
                                       class="form-control"
                                       placeholder="Card Number"
                                       required />
                               </div>
                               <div class="form-group">
                                   <label for="expiry">Expiry Date</label>
                                   <input
                                       type="text"
                                       id="expiry"
                                       class="form-control"
                                       placeholder="MM/YY"
                                       required />
                               </div>
                               <div class="form-group">
                                   <label for="cvv">CVV</label>
                                   <input
                                       type="text"
                                       id="cvv"
                                       class="form-control"
                                       placeholder="CVV"
                                       required />
                               </div>
                           </div>
                           <?php if (get_plugin_options_crp('is_termspolicy_active')) { ?>
                               <div class="col-md-6">
                                   <div class="form-check acceptance-container">
                                       <input
                                           class="form-check-input"
                                           type="checkbox"
                                           id="agreeAcceptance" required />
                                       <label class="form-check-label" for="agreeAcceptance">
                                           I agree with the <a href="<?php echo get_plugin_options_crp('terms_policy'); ?>" class="acceptance-agreement"><?php echo get_plugin_options_crp('acceptance_text_selector'); ?></a>
                                       </label>
                                   </div>
                               </div>
                           <?php } ?>
                           <button type="button" class="btn btn-primary prev-btn" id="prevButton">
                               Back
                           </button>
                           <button type="submit" class="btn btn-success pay-now-btn">Proceed With Booking</button>
                       </form>

                       <div class="container mt-5" id="step3Form" style="display: none">
                           <div class="row justify-content-center">
                               <div class="col-md-8 text-center">
                                   <!-- Success Icon -->
                                   <div class="success-icon mb-4">
                                       <i
                                           class="fa fa-check-circle"
                                           aria-hidden="true"
                                           style="font-size: 5rem; color: #28a745"></i>
                                   </div>

                                   <!-- Success Message -->
                                   <h2 class="text-success">Booking Successful!</h2>
                                   <p class="lead mt-3">
                                       Thank you for your booking!
                                   </p>
                                   <p>
                                       The booking was received and a team member will reach out to you within 24hrs to confirm the details of your rental. You will not be charged until the rental is confirmed.
                                   </p>

                                   <!-- Return to Home Button -->
                                   <div class="mt-4">
                                       <a href="#" class="btn btn-success btn-lg go-back">
                                           <i class="fa fa-home mr-2"></i> Return to Home
                                       </a>
                                   </div>
                               </div>
                           </div>
                       </div>

                       <div
                           class="container mt-5"
                           id="step3FailedForm"
                           style="display: none">
                           <div class="row justify-content-center">
                               <div class="col-md-8 text-center">
                                   <!-- Error Icon -->
                                   <div class="error-icon mb-4">
                                       <i
                                           class="fa fa-times-circle"
                                           aria-hidden="true"
                                           style="font-size: 5rem; color: #dc3545"></i>
                                   </div>

                                   <!-- Payment Failed Message -->
                                   <h2 class="text-danger">Booking Failed</h2>
                                   <p class="lead mt-3">
                                       Unfortunately, your booking could not be processed.
                                   </p>
                                   <p>Please try again.</p>

                                   <!-- Retry Payment Button -->
                                   <div class="mt-4">
                                       <button id="retryButton" class="btn btn-danger btn-lg">
                                           <i class="fa fa-redo mr-2"></i> Retry
                                       </button>
                                   </div>

                                   <!-- Return to Home Button -->
                                   <div class="mt-3">
                                       <a href="#" class="btn btn-secondary btn-lg go-back">
                                           <i class="fa fa-home mr-2"></i> Return to Home
                                       </a>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>

               <!-- Car Details -->
               <div class="col-md-4">
                   <div class="checkout-card summary-details">
                       <h5 class="vehicle-name">Corvette C8 Convertible 2023</h5>
                       <img
                           src="https://placehold.co/600x400"
                           alt="Car image"
                           class="vehicle-image" />
                       <p>
                           <i class="fas fa-calendar-alt"></i> <span class="checkin-checkout-dates">Oct 22, 2024 - Oct 26, 2024</span>
                       </p>
                       <div id="extras">
                       </div>
                       <p class="per-day-price-with-num-of-days">$450 x 4d: <span class="float-right">$1,800</span></p>
                       <p class="discount-type">Weekly Discount: <span class="float-right discount-value">-$1,800</span></p>
                       <p class="tax-container">Taxes & Fees: <span class="float-right taxes-fees-included">$162</span></p>
                       <p class="additional-container">Additional Fees: <span class="float-right additional-fees-included">$162</span></p>
                       <p class="total-price">
                           Total Charges: <span class="float-right total-charges">$1,962</span>
                       </p>
                   </div>
               </div>
           </div>
       </div>
   </div>
   <!-- Footer -->
   <!-- <div class="footer">
       <p>2024 © Github @usamakhan143</p>
       <div class="stripe-badge">
           <img src="https://via.placeholder.com/100x50" alt="Powered by Stripe" />
       </div>
   </div> -->