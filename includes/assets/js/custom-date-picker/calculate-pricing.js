// Function to calculate and display the price with discounts
function calculateAndDisplayPrice() {
  if (startDate && endDate) {
    const timeDiff = Math.abs(endDate - startDate);
    const numOfDays = Math.ceil(timeDiff / (1000 * 60 * 60 * 24)) + 1; // Number of days

    // Calculate base price without discount
    let totalPriceWithoutDiscount = pricePerDay * numOfDays;
    let discountValue = 0;
    if (numOfDays >= 30) {
      discountValue = Math.round(totalPriceWithoutDiscount * monthlyDiscount); // Monthly discount
      discountType.innerHTML = "Monthly Discount";
    } else if (numOfDays >= 7) {
      discountValue = Math.round(totalPriceWithoutDiscount * weeklyDiscount); // Weekly discount
      discountType.innerHTML = "Weekly Discount";
    } else {
      discountSec.style.display = "none";
    }

    // Calculate final price after applying discount
    const totalPrice = totalPriceWithoutDiscount - discountValue;

    // Calculate taxes
    const taxes = Math.round((totalPrice * taxRate) / 100);
    const totalCharges = Math.round(totalPrice + taxes);

    document.querySelector(".display-pricing").style.display = "block";

    // Display pricing breakdown
    pricePerDayDisplay.innerHTML = `$${pricePerDay} x ${numOfDays}d`;
    discountDisplay.innerHTML = `-$${discountValue}`;
    totalPriceDisplay.innerHTML = `$${totalPriceWithoutDiscount}`;
    taxAndFees.innerHTML = `$${taxes}`;
    totalPriceShow.innerHTML = `$${totalCharges}`;
  }
}

// Reset price display when dates are changed
function resetPriceDisplay() {
  pricePerDayDisplay.innerHTML = "";
  totalPriceDisplay.innerHTML = "";
  discountDisplay.innerHTML = ""; // Reset discount display
  taxAndFees.innerHTML = "";
  totalPriceShow.innerHTML = "";
}

// Initial calendar render
renderCalendar(currentDate);