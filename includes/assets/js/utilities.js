// Function to store data in localStorage
function storeDataInLocalStorage(dataObject) {
  // Convert the data object to a string using JSON.stringify
  localStorage.setItem("vehicleDetails", JSON.stringify(dataObject));
  console.log("Data has been stored in localStorage");
}

// Function to retrieve data from localStorage
function getDataFromLocalStorage(object) {
  // Retrieve the data and convert it back to an object using JSON.parse
  var storedData = localStorage.getItem(object);
  if (storedData) {
    var dataObject = JSON.parse(storedData);
    return dataObject;
  } else {
    console.log("No data found in localStorage");
    return null;
  }
}

function formatPrice(price) {
  // Ensure the price is a number and has two decimal places
  var formattedPrice = parseFloat(price).toFixed(0);

  // Add commas as thousand separators
  formattedPrice = formattedPrice.replace(/\B(?=(\d{3})+(?!\d))/g, ",");

  // Return the price with the currency symbol
  return formattedPrice;
}

function clearLocalStorageObject(key) {
  // Check if the key exists in localStorage
  if (localStorage.getItem(key)) {
    localStorage.removeItem(key); // Remove the specific item
    console.log(`Item with key '${key}' has been removed.`);
  } else {
    console.log(`No item found in storage.`);
  }
}

function formatDate(dateStr) {
  // Convert the date string to a Date object
  var dateObj = new Date(dateStr);

  // Options for formatting the date
  var options = { year: "numeric", month: "short", day: "numeric" };

  // Format the date using toLocaleDateString
  var formattedDate = dateObj.toLocaleDateString("en-US", options);

  // Display the formatted date
  return formattedDate;
}

function isVehicleDetailAvailable() {
  // Check if 'formData' exists in localStorage
  if (localStorage.getItem("vehicleDetails")) {
    return true;
  } else {
    return false;
  }
}

// Oneway Checkbox
function getOnewayCheckboxState() {
  return $("#oneWay").is(":checked"); // Returns true if checked, false if unchecked
}

// Validate card number (Visa, MasterCard, American Express, etc.)
function validateCardNumber(cardNumber) {
  // Regular expression for validating common card types
  const regex =
    /^(?:4[0-9]{12}(?:[0-9]{3})?|5[1-5][0-9]{14}|3[47][0-9]{13}|6(?:011|5[0-9]{2})[0-9]{12})$/;
  return regex.test(cardNumber.replace(/\s+/g, "")); // Remove spaces for validation
}

// Validate expiry date (MM/YY)
function validateExpiryDate(expiry) {
  const regex = /^(0[1-9]|1[0-2])\/([0-9]{2})$/;
  if (!regex.test(expiry)) return false;

  const today = new Date();
  const [month, year] = expiry.split("/").map((num) => parseInt(num, 10));
  const fullYear = 2000 + year;

  return (
    fullYear > today.getFullYear() ||
    (fullYear === today.getFullYear() && month >= today.getMonth() + 1)
  );
}

// Validate CVV (3 or 4 digits)
function validateCVV(cvv) {
  const regex = /^[0-9]{3,4}$/;
  return regex.test(cvv);
}
