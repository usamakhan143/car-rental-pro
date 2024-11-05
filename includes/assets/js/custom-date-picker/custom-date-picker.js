// Open the calendar popup when clicking on the input fields
startDateInput.addEventListener("click", function () {
  resetSelection();
  calendarPopup.style.display = "block";
  renderCalendar(currentDate);
});

endDateInput.addEventListener("click", function () {
  resetSelection();
  calendarPopup.style.display = "block";
  renderCalendar(currentDate);
});

// Reset date selection and price display
function resetSelection() {
  startDate = null;
  endDate = null;
  startDateInput.value = "";
  endDateInput.value = "";
  pricePerDayDisplay.innerHTML = "";
  taxAndFees.innerHTML = "";
  totalPriceDisplay.innerHTML = "";
  totalPriceShow.innerHTML = "";
}

// Close the popup
closePopupBtn.addEventListener("click", function () {
  calendarPopup.style.display = "none";
});

// Handle Previous and Next Month buttons
prevMonthBtn.addEventListener("click", function () {
  currentDate.setMonth(currentDate.getMonth() - 1);
  renderCalendar(currentDate);
});

nextMonthBtn.addEventListener("click", function () {
  currentDate.setMonth(currentDate.getMonth() + 1);
  renderCalendar(currentDate);
});

// Function to format date as YYYY-MM-DD
function formatDate(date) {
  return (
    date.getFullYear() +
    "-" +
    (date.getMonth() + 1).toString().padStart(2, "0") +
    "-" +
    date.getDate().toString().padStart(2, "0")
  );
}

// Array to hold specific disabled dates
let disabledDates = [];

// Function to disable specific dates
function disableSpecificDates(datesArray) {
  disabledDates = datesArray.map((date) => new Date(date).setHours(0, 0, 0, 0));
}

// Function to check if any dates between the start and end dates are disabled
function isRangeValid(startDate, endDate) {
  const start = new Date(startDate).getTime();
  const end = new Date(endDate).getTime();

  for (let i = start; i <= end; i += 86400000) {
    if (disabledDates.includes(i)) {
      return false;
    }
  }
  return true;
}

// Render the calendar with range selection and mouse effects
function renderCalendar(date) {
  const monthNames = [
    "January",
    "February",
    "March",
    "April",
    "May",
    "June",
    "July",
    "August",
    "September",
    "October",
    "November",
    "December",
  ];
  const daysOfWeek = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];

  const today = new Date();
  today.setHours(0, 0, 0, 0); // Normalize time

  calendarDiv.innerHTML = "";
  monthYearLabel.innerText = `${
    monthNames[date.getMonth()]
  } ${date.getFullYear()}`;

  daysOfWeek.forEach((day) => {
    const dayDiv = document.createElement("div");
    dayDiv.className = "day-of-week";
    dayDiv.innerText = day;
    calendarDiv.appendChild(dayDiv);
  });

  const firstDayOfMonth = new Date(date.getFullYear(), date.getMonth(), 1);
  const lastDayOfMonth = new Date(date.getFullYear(), date.getMonth() + 1, 0);

  // Add empty cells for days before the first day of the month
  for (let i = 0; i < firstDayOfMonth.getDay(); i++) {
    const emptyDiv = document.createElement("div");
    calendarDiv.appendChild(emptyDiv);
  }

  // Add days of the month
  for (let day = 1; day <= lastDayOfMonth.getDate(); day++) {
    const dayDiv = document.createElement("div");
    dayDiv.className = "day";
    dayDiv.innerText = day;

    const dateObj = new Date(date.getFullYear(), date.getMonth(), day);
    dateObj.setHours(0, 0, 0, 0);

    if (dateObj < today || disabledDates.includes(dateObj.getTime())) {
      dayDiv.classList.add("disabled");
      dayDiv.style.pointerEvents = "none";
      dayDiv.style.opacity = "0.5";
    }

    if (startDate && endDate && dateObj >= startDate && dateObj <= endDate) {
      dayDiv.classList.add("in-range");
    } else if (startDate && dateObj.getTime() === startDate.getTime()) {
      dayDiv.classList.add("start-date");
    } else if (endDate && dateObj.getTime() === endDate.getTime()) {
      dayDiv.classList.add("end-date");
    }

    if (dateObj >= today && !disabledDates.includes(dateObj.getTime())) {
      dayDiv.addEventListener("mouseover", function () {
        if (startDate && !endDate) {
          highlightRange(startDate, dateObj);
        }
      });

      dayDiv.addEventListener("click", function () {
        if (!startDate || (startDate && endDate)) {
          startDate = dateObj;
          endDate = null;
          startDateInput.value = formatDate(startDate);
          resetPriceDisplay();
        } else if (startDate && !endDate) {
          if (dateObj >= startDate && isRangeValid(startDate, dateObj)) {
            endDate = dateObj;
            endDateInput.value = formatDate(endDate);
            calculateAndDisplayPrice(); // Calculate price when both dates are selected
            calendarPopup.style.display = "none";
          } else {
            alert("End date cannot be selected due to disabled dates.");
          }
        }
        renderCalendar(currentDate);
      });
    }

    calendarDiv.appendChild(dayDiv);
  }
}

// Highlight date range while hovering
function highlightRange(start, hoverDate) {
  const allDays = document.querySelectorAll(".day");
  allDays.forEach((dayDiv) => {
    const day = parseInt(dayDiv.innerText);
    const dateObj = new Date(
      currentDate.getFullYear(),
      currentDate.getMonth(),
      day
    );
    dateObj.setHours(0, 0, 0, 0);

    if (dateObj >= start && dateObj <= hoverDate) {
      dayDiv.classList.add("hovered-in-range");
    } else {
      dayDiv.classList.remove("hovered-in-range");
    }
  });
}

const addons = [
  {
    id: "collisionWaiver",
    name: "Additional Collision Damage Waiver",
    price: 15,
    per: "day",
  },
  { id: "extraDriver", name: "Extra Driver", price: 10 },
  { id: "cheddiPickup", name: "Cheddi Jagan Airport Pickup", price: 60 },
  { id: "cheddiDropoff", name: "Cheddi Jagan Airport Drop Off", price: 60 },
  { id: "oglePickup", name: "Ogle Airport Pickup", price: 25 },
  { id: "ogleDropoff", name: "Ogle Airport Drop Off", price: 25 },
  { id: "officePickupDropoff", name: "Pickup/Drop off at Office", price: 0 },
];
