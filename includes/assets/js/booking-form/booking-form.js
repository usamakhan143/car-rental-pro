$('form[name="booking-form-style1"]').submit(function (event) {
  event.preventDefault();

  const startDate = $("#startDateInput").val();
  const endDate = $("#endDateInput").val();
  const startTime = $(".start-time-crp").val();
  const endTime = $(".end-time-crp").val();

  // Total price
  const getTotalChargesWithCurrency = $("#totalPrice").text();
  const totalCharges = parseFloat(getTotalChargesWithCurrency.replace("$", ""));

  // Taxes and Fees
  const getTaxFees = $("#totalTaxFees").text();
  const taxFees = parseFloat(getTaxFees.replace("$", ""));

  // Discounts
  const getDiscount = $("#discountDisplay").text();
  const discount = parseFloat(getDiscount.replace("-$", ""));
  const discountType = $("#discount-type").text();

  // Calculate Number of days
  const startDateJs = new Date(startDate);
  const endDateJs = new Date(endDate);
  // Calculate the difference in time (milliseconds)
  let timeDifference = endDateJs - startDateJs;

  // Convert time difference from milliseconds to days (1 day = 24 * 60 * 60 * 1000 ms)
  let daysDifference = timeDifference / (1000 * 3600 * 24) + 1;

  // Display Text for perday price
  const pricePerDayText = $("#pricePerDayDisplay").text();

  console.log(startDate + ": " + startTime);
  console.log(endDate + ": " + endTime);
  console.log("No. of days: " + daysDifference);
  console.log("Total Charges: " + totalCharges);
  console.log("Tax and Fees: " + taxFees);
  console.log("Discount type: " + discountType);
  console.log("Discount: " + discount);
  console.log("Price per day text: " + pricePerDayText);
});
