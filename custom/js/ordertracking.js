$(document).ready(function () {
  let token = localStorage.getItem("token");
  let mainID = $("#order_id").val();

  $.ajax({
    type: "POST",
    url: base_Url + "getorder-status",
    data: { main_orderid: mainID },
    dataType: "JSON",
    headers: { Authorization: "Bearer " + token },
    success: function (resultData) {
      if (resultData.code === 200) {
        let details = resultData.orderdetails;
        let orderStatus = details.order_status;
        console.log(orderStatus);

        const statusMap = {
          New: "Order Placed",
          Readytoship: "Readytoship",
          Shipped: "Shipped",
          Delivered: "Delivered",
        };

        const currentStatus = statusMap[orderStatus] || "Order Placed";

        const statusFlow = [
          "Order Placed",
          "Readytoship",
          "Shipped",
          "Delivered",
        ];

        const timestamps = {
          "Order Placed": details.order_date,
          Readytoship: details.ready_to_ship_date,
          Shipped: details.shipped_date,
          Delivered: details.delivery_date,
        };

        $(".order-tracking-status .step").each(function () {
          const stepText = $(this).find(".text").text().trim();

          // Check if this step should be active
          if (
            statusFlow.indexOf(stepText) <= statusFlow.indexOf(currentStatus)
          ) {
            console.log("yesss");
            $(this).addClass("active");
            $(this)
              .find(".datetime")
              .text(timestamps[stepText] || "--");
          } else {
            $(this).removeClass("active");
            $(this).find(".datetime").text("--");
          }
        });

        $(".order-tracking-status").removeClass("d-none");
      } else {
        showToast(resultData.message, "error");
      }
    },
    error: function (error) {
      let status = error.status;
      if (status === 401) {
        localStorage.removeItem("token");
        window.location.href = base_Url;
      } else {
        showToast(error, "error");
      }
    },
  });

  $(".order-tracking-status").removeClass("d-none");
});
