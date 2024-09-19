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

// Variables to store the current date and selected range
let currentDate = new Date();
let startDate = null;
let endDate = null;