$(document).ready(function () {
  totalAmount();

  function totalAmount() {
    let totalAmt = 0;
    let totalGstValue = 0;
    let subTotal = 0;
    let finalTotal = 0;
    let amount = 0;
    let priceCalculation;

    $(".checkout-product").each(function () {
      let price = $(this)
        .attr("data-price")
        ?.replace(",", "")
        .replace("₹", "")
        .trim();
      let productPrice = parseFloat(price);
      let cartID = $(this).attr("data-cartid");

      let cartqty = parseFloat($(this).attr("data-cartqty"));
      let mainqty = parseFloat($(this).attr("data-mainqty"));

      if (cartqty <= mainqty) {
        let priceCalculation = productPrice * cartqty;
        $(`.cart_total_${cartID}`).html(priceCalculation.toFixed(2));
        amount += priceCalculation;
      }

      // Get GST percent from data attribute
      let gstPercent = parseFloat($(this).attr("data-gst")) || 0;
      console.log(amount);
      //   console.log(gstPercent);

      let gstValue = 0;
      if (gstPercent > 0 && !isNaN(amount)) {
        gstValue = (amount * gstPercent) / (100 + gstPercent);
        gstValue = parseFloat(gstValue.toFixed(2));
      }

      if (!isNaN(amount)) totalAmt += amount;
      if (!isNaN(gstValue)) totalGstValue += gstValue;
    });

    totalAmt = parseInt(totalAmt.toFixed(2));
    totalGstValue = parseInt(totalGstValue.toFixed(2));
    subTotal = parseInt((totalAmt - totalGstValue).toFixed(2));
    finalTotal = totalAmt + 100;

    // Display total
    $(".order_total_amt").text(
      "₹" +
        finalTotal.toLocaleString("en-IN", {
          minimumFractionDigits: 2,
          maximumFractionDigits: 2,
        })
    );
    $(".order-subtotal").text(
      "₹" +
        subTotal.toLocaleString("en-IN", {
          minimumFractionDigits: 2,
          maximumFractionDigits: 2,
        })
    );

    // Split GST
    if (totalGstValue > 0) {
      let halfGst = parseFloat((totalGstValue / 2).toFixed(2));

      $(".gst-td").text(
        "₹" +
          halfGst.toLocaleString("en-IN", {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
          })
      );
      $(".sgst-td").text(
        "₹" +
          halfGst.toLocaleString("en-IN", {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
          })
      );
    } else {
      $(".gst-td").text("-");
      $(".sgst-td").text("-");
    }
  }

  // *************************** [Check Login ] *************************************************************************

  $("#continue-login").click(function () {
    

    const number = $("#number").val().trim(); // or use $.trim($("#number").val())

    if (number === "") {
      showToast("Please Enter Number", "error");
    } else if (!isPhoneNumber(number)) {
      showToast("Please enter valid mobile number.", "error");
    } else {
      // valid number
    }
  });

  function isPhoneNumber(phone_no) {
    var pattern = /^\d{10}$/;
    return pattern.test(phone_no);
  }
});
