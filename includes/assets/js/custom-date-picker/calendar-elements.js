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
const salePrice = CarRentalProData.pricePerDay;
const taxRate = CarRentalProData.taxRate;
const weeklyDiscount = CarRentalProData.weeklyDiscount;
const monthlyDiscount = CarRentalProData.monthlyDiscount;
const pricePerDay = CarRentalProData.salePrice;
const wooCurrency = CarRentalProData.currency;
const wooCurrencySymbol = CarRentalProData.currencySymbol;

// Example: Update the HTML with the pricePerDay and salePrice
document.querySelector(".price-per-day").textContent =
  wooCurrencySymbol + pricePerDay;
document.querySelector(".actual-price").textContent = salePrice
  ? wooCurrencySymbol + salePrice
  : wooCurrencySymbol + pricePerDay;
