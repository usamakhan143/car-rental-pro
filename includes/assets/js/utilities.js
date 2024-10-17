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
    console.log(`Item with key '${key}' has been removed from localStorage.`);
  } else {
    console.log(`No item found in localStorage with the key '${key}'.`);
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
