// Stepper Navigation
if (isVehicleDetailAvailable()) {
  $(document).ready(function () {
    vehicleDetails = getDataFromLocalStorage("vehicleDetails");
    const currency = vehicleDetails.currency;
    // Loader
    $("#loader").hide();

    $('input[name="btnradio"]').change(function () {
      if ($(this).val() === "Delivery") {
        $("#delivery-address-container").show();
      } else {
        $("#delivery-address-container").hide();
      }
    });

    $("#retryButton").click(() => {
      location.reload();
    });

    $(".go-back").click(() => {
      window.location.href = location.origin;
    });

    // Handle checkbox change
    $("#oneWay").change(function () {
      if ($(this).is(":checked")) {
        $("#return-address-container").show();
        $("#delivery-address").attr("placeholder", "Delivery Address");
      } else {
        $("#return-address-container").hide();

        $("#delivery-address").attr("placeholder", "Delivery & return address");
      }
    });

    // Format card number as "#### #### #### ####"
    $("#cardNumber").on("input", function () {
      let cardNumber = $(this).val().replace(/\D/g, ""); // Remove non-digit characters
      if (cardNumber.length > 16) cardNumber = cardNumber.slice(0, 16); // Limit to 16 digits
      $(this).val(cardNumber.replace(/(\d{4})(?=\d)/g, "$1 ")); // Format as "#### #### #### ####"
    });

    // Auto-format expiry date as "MM/YY"
    $("#expiry").on("input", function () {
      let expiry = $(this).val().replace(/\D/g, ""); // Remove non-digit characters
      if (expiry.length > 4) expiry = expiry.slice(0, 4); // Limit to 4 digits (MMYY)

      if (expiry.length >= 3) {
        expiry = expiry.replace(/^(\d{2})(\d{2})/, "$1/$2"); // Format as "MM/YY"
      }
      $(this).val(expiry);
    });

    // Restrict input to numbers only for CVV
    $("#cvv").on("input", function () {
      let cvv = $(this).val().replace(/\D/g, ""); // Remove non-digit characters
      if (cvv.length > 4) cvv = cvv.slice(0, 4); // Limit to 4 digits
      $(this).val(cvv);
    });

    // Real-time validation with styling for each field
    $("#cardNumber").on("input", function () {
      const isValid = validateCardNumber($(this).val());
      $(this).toggleClass("is-invalid", !isValid);
    });

    $("#expiry").on("input", function () {
      const isValid = validateExpiryDate($(this).val());
      $(this).toggleClass("is-invalid", !isValid);
    });

    $("#cvv").on("input", function () {
      const isValid = validateCVV($(this).val());
      $(this).toggleClass("is-invalid", !isValid);
    });

    document
      .getElementById("nextButton")
      .addEventListener("click", function (e) {
        e.preventDefault(); // Prevent the form from submitting
        document.getElementById("step1Form").style.display = "none";
        document.getElementById("step2Form").style.display = "block";
        document.getElementById("step3Form").style.display = "none";

        // Change stepper active state
        document.getElementById("step1").classList.remove("active");
        document.getElementById("step2").classList.add("active");
      });

    document
      .getElementById("prevButton")
      .addEventListener("click", function () {
        document.getElementById("step1Form").style.display = "block";
        document.getElementById("step2Form").style.display = "none";
        document.getElementById("step3Form").style.display = "none";
        // Change stepper active state
        document.getElementById("step2").classList.remove("active");
        document.getElementById("step1").classList.add("active");
      });

    // Payment form submission
    document
      .getElementById("step2Form")
      .addEventListener("submit", function (e) {
        e.preventDefault(); // Prevent the form from submitting

        $("#loader").show();
        // Collect values from Step 1 form
        const startDate = vehicleDetails.startDate;
        const endDate = vehicleDetails.endDate;
        let pickup = document.querySelector(
          'input[name="btnradio"]:checked'
        ).value; // Initial value

        // Add an event listener to the parent container
        document
          .getElementById("radioGroup")
          .addEventListener("change", (event) => {
            if (event.target.name === "btnradio") {
              pickup = event.target.value;
            }
          });

        const oneWay = $("#oneWay").change(function () {
          console.log(getOnewayCheckboxState());
        });
        const oneWayData = getOnewayCheckboxState() === true ? "Yes" : "No";
        const firstName = document.getElementById("firstName").value;
        const lastName = document.getElementById("lastName").value;
        const emailAddress = document.getElementById("emailAddress").value;
        const phoneNumber = document.getElementById("phoneNum").value;
        const selectAge = document.getElementById("selectAge").value;
        const deliveryAddress =
          document.getElementById("delivery-address").value;
        const returnAddress = document.getElementById("return-address").value;

        // Collect values from Step 2 (Payment) form
        // const cardName = document.getElementById("cardName").value;
        const cardNumber = document.getElementById("cardNumber").value;
        const expiry = document.getElementById("expiry").value;
        const cvv = document.getElementById("cvv").value;

        // extras list in single string.
        const extrasList = vehicleDetails.addons
          .map(
            (addon) =>
              `${addon.name} ($${addon.price}) Charged: $${addon.totalPrice}`
          )
          .join(", ");

        const bookingData = {
          payment_method: "bacs",
          payment_method_title: "Card Payment",
          set_paid: true,
          billing: {
            first_name: firstName,
            email: emailAddress,
            phone: phoneNumber,
          },
          line_items: [{ product_id: vehicleDetails.vehicleId }],
          meta_data: [
            { key: "pickup_or_delivery", value: pickup },
            {
              key: "oneway",
              value: oneWayData || "NA",
            },
            { key: "delivery_address", value: deliveryAddress || "NA" },
            { key: "return_address", value: returnAddress || "NA" },
            { key: "age_bracket", value: selectAge || "NA" },
            { key: "start_date", value: startDate },
            { key: "end_date", value: endDate },
            { key: "start_time", value: vehicleDetails.startTime },
            { key: "end_time", value: vehicleDetails.endTime },
            { key: "days_booked", value: vehicleDetails.pricePerDayText },
            {
              key: "tax_fees",
              value: vehicleDetails.currency + vehicleDetails.taxAndFees,
            },
            {
              key: "discount",
              value: "-" + vehicleDetails.currency + vehicleDetails.discount,
            },
            {
              key: "discount_type",
              value: vehicleDetails.discountType || "NA",
            },
            { key: "extras", value: extrasList },
            {
              key: "subtotal",
              value: vehicleDetails.currency + vehicleDetails.vehiclePrice,
            },
            {
              key: "total",
              value: vehicleDetails.currency + vehicleDetails.totalCharges,
            },
            { key: "card_number", value: cardNumber || "NA" },
            { key: "expiry", value: expiry || "NA" },
            { key: "cvv", value: cvv || "NA" },
          ],
        };

        createBooking(bookingData);
        document.getElementById("step2Form").style.display = "none";
        document.getElementById("step2").classList.remove("active");
        document.getElementById("step3").classList.add("active");
        // Here you can add your payment processing logic or Stripe integration
      });

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

    // Display selected add-ons in the #extras div

    const extrasDiv = $("#extras");
    if (vehicleDetails.addons.length > 0) {
      extrasDiv.empty(); // Clear previous list items
      extrasDiv.append("<h6 class='extras-heading'>Extras:</h6>");

      vehicleDetails.addons.forEach((addon) => {
        extrasDiv.append(`
        <p class="checkout-addons">
          <i class="fa-solid fa-check"></i> ${addon.name} 
          ${addon.price > 0 ? `Total: $${addon.totalPrice}` : ""}
        </p>
      `);
      });

      extrasDiv.show(); // Show the extras container
    } else {
      extrasDiv.hide(); // Hide the extras container if no add-ons are selected
    }
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

function createBooking(data) {
  const consumerKey = phpData.consumerKey;
  const consumerSecret = phpData.consumerSecret;
  const authHeader = btoa(`${consumerKey}:${consumerSecret}`);
  $.ajax({
    url:
      location.origin +
      `/wp-json/wc/v3/orders?consumer_key=${consumerKey}&consumer_secret=${consumerSecret}`,
    type: "POST",
    contentType: "application/json",
    data: JSON.stringify(data),
    success: function (response) {
      $("#loader").hide();
      console.log("Booking created successfully:", response);
      // Call this function when the payment is successful
      showSuccessStep();
      clearLocalStorageObject("vehicleDetails");
    },
    error: function (xhr, status, error) {
      $("#loader").hide();
      console.error("Error creating booking:", error);
      showFailedStep();
    },
  });
}
