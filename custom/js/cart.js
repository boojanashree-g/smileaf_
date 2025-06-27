$(document).ready(function () {
  //Cart quantity

  var inputField, currentQty, sellingPrice;

  totalAmount();
  $(".btn-increment").click(function () {
    var cartID = $(this).data("cartid");
    var finalstock = $(this).data("finalstock");

    inputField = this.parentNode.querySelector("input[name='qtybutton']");
    currentQty = parseInt($(inputField).val());
    sellingPrice = $(inputField).data("originalprice");

    if (currentQty < finalstock) {
      var newQty = currentQty + 1;
      $(inputField).val(newQty);
      subTotal(newQty, cartID, sellingPrice);
    }
  });

  $(".btn-decrement").click(function () {
    var cartID = $(this).data("cartid");
    var minQty = 1;

    inputField = this.parentNode.querySelector("input[name='qtybutton']");
    currentQty = parseInt($(inputField).val());
    sellingPrice = $(inputField).data("originalprice");

    if (currentQty > minQty) {
      var newQty = currentQty - 1;
      $(inputField).val(newQty);
      subTotal(newQty, cartID, sellingPrice);
    }
  });

  function subTotal(qty, cartID, sellingPrice) {
    let prodPrice = sellingPrice;

    let p1 = prodPrice.replace(",", "");
    let price = parseFloat(p1);

    let displayPrice = `.total_${cartID}`;

    let subtotalAmt = qty * price;

    let formattedPrice = subtotalAmt.toLocaleString("en-IN", {
      minimumFractionDigits: 2,
      maximumFractionDigits: 2,
    });

    $(displayPrice).text("₹" + formattedPrice);

    // update the quantity and subtotal into cart tbl
    $.ajax({
      type: "POST",
      url: base_Url + "update-cart",
      data: {
        quantity: qty,
        total_price: subtotalAmt,
        cart_id: cartID,
      },

      dataType: "json",
      success: function (data) {
        if (data.code == 200) {
          totalAmount();
        }
      },
      error: function () {
        console.log("Error");
      },
    });
  }

  function totalAmount() {
    var totalAmt = 0;
    var totalGst = 0;
    let totalGstValue = 0;
    $(".cart-product-subtotal").each(function () {
      let price = $(this).text().replace(",", "").replace("₹", "").trim();

      let amount = parseFloat(price);

      // Get GST value from data attribute
      let gstPercent = parseFloat($(this).data("gst")) || 0;

      console.log(gstPercent);

      let gstValue = 0;
      if (gstPercent > 0 && !isNaN(amount)) {
        gstValue = (amount * gstPercent) / (100 + gstPercent);
      }
      totalGstValue += gstValue;

      if (!isNaN(amount)) totalAmt += amount;
      if (!isNaN(gstValue)) totalGstValue += gstValue;
    });

    $(".order_total_amt").text("₹" + totalAmt.toLocaleString());
    if (totalGst > 0) {
      let halfGst = (totalGst / 2).toFixed(2);
      $("td.gst-td").text("₹" + parseFloat(halfGst).toLocaleString());
      $("td.sgst-td").text("₹" + parseFloat(halfGst).toLocaleString());
    } else {
      $("td.gst-td").text("-");
      $("td.sgst-td").text("-");
    }
  }
});
