// Stepper Navigation
if (isVehicleDetailAvailable()) {
  document.getElementById("nextButton").addEventListener("click", function (e) {
    e.preventDefault(); // Prevent the form from submitting
    document.getElementById("step1Form").style.display = "none";
    document.getElementById("step2Form").style.display = "block";
    document.getElementById("step3Form").style.display = "none";

    // Change stepper active state
    document.getElementById("step1").classList.remove("active");
    document.getElementById("step2").classList.add("active");
  });

  document.getElementById("prevButton").addEventListener("click", function () {
    document.getElementById("step1Form").style.display = "block";
    document.getElementById("step2Form").style.display = "none";
    document.getElementById("step3Form").style.display = "none";
    // Change stepper active state
    document.getElementById("step2").classList.remove("active");
    document.getElementById("step1").classList.add("active");
  });

  // Payment form submission
  document.getElementById("step2Form").addEventListener("submit", function (e) {
    e.preventDefault(); // Prevent the form from submitting

    // Collect values from Step 1 form
    const startDate = document.getElementById("startDate").value;
    const endDate = document.getElementById("endDate").value;
    const pickup = document.getElementById("pickupRadio").value;
    const oneWay = document.getElementById("oneWay").value;
    const firstName = document.getElementById("firstName").value;
    const lastName = document.getElementById("lastName").value;
    const emailAddress = document.getElementById("emailAddress").value;
    const phoneNumber = document.getElementById("phoneNum").value;
    const selectAge = document.getElementById("selectAge").value;

    // Collect values from Step 2 (Payment) form
    // const cardName = document.getElementById("cardName").value;
    const cardNumber = document.getElementById("cardNumber").value;
    const expiry = document.getElementById("expiry").value;
    const cvv = document.getElementById("cvv").value;

    // Log all values to the console
    console.log("Start Date:", startDate);
    console.log("End Date:", endDate);
    console.log("Pickup/Delivery:", pickup);
    console.log("Customer Name:", firstName, lastName);
    console.log("Email:", emailAddress);
    console.log("Phone:", phoneNumber);

    // console.log("Name on Card:", cardName);
    console.log("Card Number:", cardNumber);
    console.log("Expiry Date:", expiry);
    console.log("CVV:", cvv);

    document.getElementById("step2Form").style.display = "none";
    document.getElementById("step2").classList.remove("active");
    document.getElementById("step3").classList.add("active");
    // Call this function when the payment is successful
    showSuccessStep();
    showFailedStep();
    // Here you can add your payment processing logic or Stripe integration
  });

  $(document).ready(function () {
    vehicleDetails = getDataFromLocalStorage("vehicleDetails");
    const currency = vehicleDetails.currency;
    console.log(vehicleDetails, "Jani");

    // Vehicle Name
    $(".vehicle-name").text(vehicleDetails.name);

    // Image
    $(".vehicle-image").attr("src", vehicleDetails.image);

    // Checkin - Checkout dates
    $(".checkin-checkout-dates").text(
      formatDate(vehicleDetails.startDate) +
        " - " +
        formatDate(vehicleDetails.endDate)
    );

    // Text: $200 x 10d: $2,000
    $(".per-day-price-with-num-of-days").text(
      vehicleDetails.pricePerDayText + ": "
    );
    let perDayPriceVal = $("<span class='float-right'></span>").text(
      currency + formatPrice(vehicleDetails.vehiclePrice)
    );
    $(".per-day-price-with-num-of-days").append(perDayPriceVal);
    // Taxes and Fees
    if (vehicleDetails.taxAndFees > 0) {
      $(".taxes-fees-included").text(
        currency + formatPrice(vehicleDetails.taxAndFees)
      );
    } else {
      $(".tax-container").text(" ");
    }

    // Discounts
    if (vehicleDetails.discount > 0) {
      $(".discount-type").text(
        vehicleDetails.discountType + ": -" + currency + vehicleDetails.discount
      );
    } else {
      $(".discount-type").text(" ");
    }
    // Total Charges
    $(".total-charges").text(
      currency + formatPrice(vehicleDetails.totalCharges)
    );
  });
} else {
  $(".car-rental-pro-checkout").hide();
}

// Show the third stepper with a smooth fade-in effect
function showSuccessStep() {
  const step3Form = document.getElementById("step3Form");
  step3Form.style.display = "block";
  step3Form.style.opacity = 0;
  let opacity = 0;
  const fadeIn = setInterval(function () {
    if (opacity >= 1) {
      clearInterval(fadeIn);
    }
    step3Form.style.opacity = opacity;
    opacity += 0.1;
  }, 50);
}

// Show the third stepper with a smooth fade-in effect
function showFailedStep() {
  document.getElementById("step3Form").style.display = "none";
  const step3Form = document.getElementById("step3FailedForm");
  step3Form.style.display = "block";
  step3Form.style.opacity = 0;
  let opacity = 0;
  const fadeIn = setInterval(function () {
    if (opacity >= 1) {
      clearInterval(fadeIn);
    }
    step3Form.style.opacity = opacity;
    opacity += 0.1;
  }, 50);
}
