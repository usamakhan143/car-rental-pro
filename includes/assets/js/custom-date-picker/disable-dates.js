// Function to fetch orders and disable dates for a specific product
function fetchAndDisableDatesForProduct(productId) {
  $.ajax({
    url: `${location.origin}/wp-json/wc/v3/orders?consumer_key=${wooconsumerKey}&consumer_secret=${wooconsumerSecret}`,
    method: "GET",
    success: function (orders) {
      // Today's date for filtering
      const today = new Date();
      today.setHours(0, 0, 0, 0);

      // Array to store all disabled dates
      let allDisabledDates = [];

      // Process each order
      $.each(orders, function (index, order) {
        // Check if the order contains the specific product in line_items
        const hasProduct = order.line_items.some(
          (item) => item.product_id === productId
        );

        if (hasProduct) {
          // Extract start_date and end_date from meta_data
          const startDateMeta = order.meta_data.find(
            (meta) => meta.key === "start_date"
          );
          const endDateMeta = order.meta_data.find(
            (meta) => meta.key === "end_date"
          );

          if (startDateMeta && endDateMeta) {
            const startDate = new Date(startDateMeta.value);
            const endDate = new Date(endDateMeta.value);

            // Generate dates between startDate and endDate
            let currentDate = new Date(startDate);
            while (currentDate <= endDate) {
              // Only add dates after today
              if (currentDate >= today) {
                allDisabledDates.push(new Date(currentDate));
              }
              // Move to the next day
              currentDate.setDate(currentDate.getDate() + 1);
            }
          }
        }
        console.log(allDisabledDates, "dates");
      });

      // Pass the dates to disableSpecificDates function
      disableSpecificDates(allDisabledDates);
    },
    error: function (error) {
      console.error("Error fetching orders:", error);
    },
  });
}
