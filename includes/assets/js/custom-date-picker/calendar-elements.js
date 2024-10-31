// Get elements
const calendarPopup = document.getElementById("calendarPopup");
const closePopupBtn = document.getElementById("closePopupBtn");
const calendarDiv = document.getElementById("calendar");
const monthYearLabel = document.getElementById("monthYear");
const prevMonthBtn = document.getElementById("prevMonthBtn");
const nextMonthBtn = document.getElementById("nextMonthBtn");
const startDateInput = document.getElementById("startDateInput");
const endDateInput = document.getElementById("endDateInput");
const pricePerDayDisplay = document.getElementById("pricePerDayDisplay");
const totalPriceDisplay = document.getElementById("totalPricePerDayDisplay");
const taxAndFees = document.getElementById("totalTaxFees");
const totalPriceShow = document.getElementById("totalPrice");
const discountSec = document.querySelector(".discount-pricing-section");
const discountType = document.getElementById("discount-type");
const discountDisplay = document.getElementById("discountDisplay"); // New element to display discount
const taxSec = document.querySelector(".taxes-pricing-section");

// Variables to store the current date and selected range
let currentDate = new Date();
let startDate = null;
let endDate = null;

// Use the data as needed in your booking form logic
const regularPrice = CarRentalProData.regularPrice;
const taxRate = CarRentalProData.taxRate;
const weeklyDiscount = CarRentalProData.weeklyDiscount;
const monthlyDiscount = CarRentalProData.monthlyDiscount;
const salePrice = CarRentalProData.salePrice;
const wooCurrency = CarRentalProData.currency;
const wooCurrencySymbol = CarRentalProData.currencySymbol;
const vehicleId = CarRentalProData.vehcileId;
// Product ID
$("#vehicleNumber").val(vehicleId);
let priceTobeCalculated;
// Example: Update the HTML with the pricePerDay and salePrice
if (salePrice !== "") {
  priceTobeCalculated = salePrice;

  document.querySelector(".price-per-day").textContent =
    wooCurrencySymbol + salePrice;
  document.querySelector(".actual-price").textContent = regularPrice + " /day";
} else {
  priceTobeCalculated = regularPrice;

  document.querySelector(".price-per-day").textContent =
    wooCurrencySymbol + regularPrice + "/day";
  document.querySelector(".actual-price").textContent = "";
}
clearLocalStorageObject("vehicleDetails");
