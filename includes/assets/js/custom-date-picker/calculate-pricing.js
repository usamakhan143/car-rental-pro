function createAddons() {
  const $addonsContainer = $("#addonsContainer");

  // Generate checkboxes for each addon
  addons.forEach((addon) => {
    // If price is 0, omit it from the label
    const priceText =
      addon.price > 0
        ? ` ($${addon.price}${addon.per === "day" ? " per day" : ""})`
        : "";

    const addonHtml = `
    <div class="form-check">
        <input type="checkbox" class="addon-checkbox form-check-input" id="${
          addon.id
        }" data-price="${addon.price}" ${
      addon.per ? `data-per="${addon.per}"` : ""
    }>
      <label class="form-check-label" for="${addon.id}">
        ${addon.name} ${priceText}
      </label><br>
    </div>`;
    $addonsContainer.append(addonHtml);
  });

  // Attach event listener for checkbox changes
  $(".addon-checkbox").change(calculateAndDisplayPrice);
}

function calculateAddonsTotal() {
  let totalAddonsCost = 0;
  const timeDiff = Math.abs(endDate - startDate);
  const numOfDays = Math.ceil(timeDiff / (1000 * 60 * 60 * 24)) + 1; // Number of days

  // Loop through each checked addon
  $(".addon-checkbox:checked").each(function () {
    let addonPrice = parseFloat($(this).data("price"));
    if ($(this).data("per") === "day") {
      addonPrice *= numOfDays;
    }
    totalAddonsCost += addonPrice;
  });
  return totalAddonsCost;
}

// Function to calculate and display the price with discounts
function calculateAndDisplayPrice() {
  if (startDate && endDate) {
    const timeDiff = Math.abs(endDate - startDate);
    const numOfDays = Math.ceil(timeDiff / (1000 * 60 * 60 * 24)) + 1; // Number of days

    // Calculate base price without discount
    let totalPriceWithoutDiscount = priceTobeCalculated * numOfDays;
    let discountValue = 0;
    if (numOfDays >= 30 && monthlyDiscount > 0) {
      discountSec.style.display = "block";
      discountValue = Math.round(totalPriceWithoutDiscount * monthlyDiscount); // Monthly discount
      discountType.innerHTML = "Monthly Discount";
    } else if (numOfDays >= 7 && weeklyDiscount > 0) {
      discountSec.style.display = "block";
      discountValue = Math.round(totalPriceWithoutDiscount * weeklyDiscount); // Weekly discount
      discountType.innerHTML = "Weekly Discount";
    } else {
      discountSec.style.display = "none";
    }

    // Addons Price Calculation Start
    let totalAddonsCost = 0;
    let checkedAddons = []; // Array to store selected addons

    // Loop through each checked addon
    $(".addon-checkbox:checked").each(function () {
      let addonPrice = parseFloat($(this).data("price"));
      if ($(this).data("per") === "day") {
        addonPrice *= numOfDays;
      }
      totalAddonsCost += addonPrice;

      // Push the selected addon details into checkedAddons array
      checkedAddons.push({
        id: $(this).attr("id"),
        name: $(this).parent().text().trim(),
        price: parseFloat($(this).data("price")),
        totalPrice: addonPrice,
      });
    });
    // Addons Price Calculation End

    // Calculate final price after applying discount
    const totalPrice = totalPriceWithoutDiscount - discountValue;

    // Calculate taxes
    let taxes = 0;
    if (taxRate > 0) {
      taxes = Math.round((totalPrice * taxRate) / 100);
    } else {
      taxes = 0;
      taxSec.style.display = "none";
    }
    const totalCharges = Math.round(totalPrice + taxes + totalAddonsCost);

    document.querySelector(".display-pricing").style.display = "block";

    // Display pricing breakdown
    pricePerDayDisplay.innerHTML = `$${priceTobeCalculated} x ${numOfDays}d`;
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
createAddons();
