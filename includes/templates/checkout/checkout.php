   <!-- Progress Bar -->
   <div class="container">
       <div class="row justify-content-center">
           <div class="col-md-12">
               <div class="progress-container">
                   <div class="row">
                       <div class="step col active" id="step1">
                           <i class="fas fa-check-circle"></i>
                           <p>Select</p>
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
                   <form id="step1Form" class="step-content">
                       <!-- <h5>When & Where</h5> -->
                       <div class="row">
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
                       </div>
                       <div class="row">
                           <div class="form-group col-md-12">
                               <div class="row">
                                   <div class="col-md-6">
                                       <div class="btn-group" role="group">
                                           <input
                                               type="radio"
                                               class="btn-check"
                                               name="btnradio"
                                               id="pickupRadio"
                                               autocomplete="off"
                                               checked />
                                           <label class="btn btn-outline-primary" for="pickupRadio">Pickup</label>

                                           <input
                                               type="radio"
                                               class="btn-check"
                                               name="btnradio"
                                               id="deliveryRadio"
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
                                               value=""
                                               id="oneWay" />
                                           <label class="form-check-label" for="oneWay">
                                               One-way
                                           </label>
                                       </div>
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
                                   id="phoneNum" />
                           </div>
                           <div class="form-group col-md-6">
                               <label>Select age</label>
                               <select class="form-control" id="selectAge">
                                   <option>Select age</option>
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
                               placeholder="Card Number" />
                       </div>
                       <div class="form-group">
                           <label for="expiry">Expiry Date</label>
                           <input
                               type="text"
                               id="expiry"
                               class="form-control"
                               placeholder="MM/YY" />
                       </div>
                       <div class="form-group">
                           <label for="cvv">CVV</label>
                           <input
                               type="text"
                               id="cvv"
                               class="form-control"
                               placeholder="CVV" />
                       </div>

                       <button type="button" class="btn btn-primary" id="prevButton">
                           Back
                       </button>
                       <button type="submit" class="btn btn-success">Pay Now</button>
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
                               <h2 class="text-success">Payment Successful!</h2>
                               <p class="lead mt-3">
                                   Thank you for your purchase! Your payment has been processed
                                   successfully.
                               </p>
                               <p>
                                   We hope you enjoy your booking and have a wonderful
                                   experience!
                               </p>

                               <!-- Return to Home Button -->
                               <div class="mt-4">
                                   <a href="#" class="btn btn-success btn-lg">
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
                               <h2 class="text-danger">Payment Failed</h2>
                               <p class="lead mt-3">
                                   Unfortunately, your payment could not be processed.
                               </p>
                               <p>Please check your payment details and try again.</p>

                               <!-- Retry Payment Button -->
                               <div class="mt-4">
                                   <button id="retryButton" class="btn btn-danger btn-lg">
                                       <i class="fa fa-redo mr-2"></i> Retry Payment
                                   </button>
                               </div>

                               <!-- Return to Home Button -->
                               <div class="mt-3">
                                   <a href="/" class="btn btn-secondary btn-lg">
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
                   <h5>Corvette C8 Convertible 2023</h5>
                   <img
                       src="https://d2j40m88aovabi.cloudfront.net/storage/app/public/high_resolution_image/d7b68310d7680c7a3797c7a9c3664c12.jpeg"
                       alt="Car image"
                       class="vehicle-image" />
                   <p>
                       <i class="fas fa-calendar-alt"></i> Oct 22, 2024 - Oct 26, 2024
                   </p>
                   <p>
                       <i class="fas fa-map-marker-alt"></i> 499 N Canon Dr, Beverly
                       Hills, CA 90210
                   </p>
                   <p>$450 x 4d: <span class="float-right">$1,800</span></p>
                   <p>Taxes & Fees: <span class="float-right">$162</span></p>
                   <p class="total-price">
                       Total Charges: <span class="float-right">$1,962</span>
                   </p>
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