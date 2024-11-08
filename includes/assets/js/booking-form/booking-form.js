$('form[name="booking-form-style1"]').submit(function (event) {
  event.preventDefault();

  const getVehicleId = $("#vehicleNumber").val();
  const startDate = $("#startDateInput").val();
  const endDate = $("#endDateInput").val();
  const startTime = $(".start-time-crp").val();
  const endTime = $(".end-time-crp").val();
  const selectedAddonsData = JSON.parse($("#selectedAddons").val());

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

  // Display Text for per day price
  const pricePerDayText = $("#pricePerDayDisplay").text();

  // Display Vehicle Name
  const vehicleName = $(".product_title").first().text();

  // Display Vehicle image
  const vehicleImage = $(".wp-post-image").attr("src");

  const vehiclePriceText = $(".car-price").text();
  const vehiclePrice = parseFloat(vehiclePriceText.replace("$", ""));

  // Currency Symbol
  const currencySymbol = "$";

  // Additional Fees
  const getAdditionalFees = $("#totalAdditionalFees").text();
  const getAdditionalFeeVal = parseFloat(getAdditionalFees.replace("$", ""));

  // console.log(startDate + ": " + startTime);
  // console.log(endDate + ": " + endTime);
  // console.log("No. of days: " + daysDifference);
  // console.log("Total Charges: " + totalCharges);
  // console.log("Tax and Fees: " + taxFees);
  // console.log("Discount type: " + discountType);
  // console.log("Discount: " + discount);
  // console.log("Price per day text: " + pricePerDayText);
  // console.log("Addons", selectedAddonsData);

  const vehicleDetail = {
    image: vehicleImage,
    name: vehicleName,
    startDate: startDate,
    startTime: startTime,
    endDate: endDate,
    endTime: endTime,
    pricePerDayText: pricePerDayText,
    discountType: discountType,
    discount: discount,
    taxAndFees: taxFees,
    additionalFee: getAdditionalFeeVal,
    vehiclePrice: vehiclePrice,
    totalCharges: totalCharges,
    currency: currencySymbol,
    addons: selectedAddonsData,
    vehicleId: Number(getVehicleId),
  };

  storeDataInLocalStorage(vehicleDetail);

  if (location.host !== "localhost") {
    window.location.href = location.origin + "/" + "vehicle-booking";
  } else {
    window.location.href = location.origin + "/wpplugindev/vehicle-booking";
  }
});
