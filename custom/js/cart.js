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
    } else {
      showToast("Maximum Stock Reached", "info");
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
    let totalAmt = 0;
    let totalGstValue = 0;
    let subTotal = 0;
    let finalTotal = 0;

    $(".cart-product-subtotal").each(function () {
      let price = $(this).text().replace(",", "").replace("₹", "").trim();
      let amount = parseFloat(price);

      // Get GST percent from data attribute
      let gstPercent = parseFloat($(this).data("gst")) || 0;

      let gstValue = 0;
      if (gstPercent > 0 && !isNaN(amount)) {
        gstValue = (amount * gstPercent) / (100 + gstPercent);
        let paise = parseFloat((gstValue % 1).toFixed(2)) * 100;
        gstValue = paise < 50 ? Math.floor(gstValue) : Math.ceil(gstValue);
      }

      if (!isNaN(amount)) totalAmt += amount;
      if (!isNaN(gstValue)) totalGstValue += gstValue;
    });

    totalAmt = parseFloat(totalAmt.toFixed(2));
    totalGstValue = parseFloat(totalGstValue.toFixed(2));
    subTotal = (totalAmt - totalGstValue).toFixed(2);
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

      $("td.gst-td").text(
        "₹" +
          halfGst.toLocaleString("en-IN", {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
          })
      );
      $("td.sgst-td").text(
        "₹" +
          halfGst.toLocaleString("en-IN", {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
          })
      );
    } else {
      $("td.gst-td").text("-");
      $("td.sgst-td").text("-");
    }
  }

  // Delete Modal
  $(".cart-delete").click(function () {
    let cartID = $(this).data("cartid");

    $("#delete-modal").modal("show");
    $(".btn-delete").attr("data-cartid", cartID);
  });

  $(".delete-cancel").click(function () {
    $("#delete-modal").modal("hide");
  });

  $(".btn-delete").click(function () {
    let delCartID = $(this).attr("data-cartid");
    $.ajax({
      type: "POST",
      url: base_Url + "delete-cart",
      data: { cart_id: delCartID },
      dataType: "json",

      success: function (resData) {
        $("#delete-modal").modal("hide");
        console.log(resData);

        if (resData.code == 200) {
          showToast(resData.message, "success");
          setTimeout(() => {
            window.location.reload();
          }, 1000);
        } else {
          showToast(resData.message, "error");
        }
      },
      error: function (err) {
        console.log(err);
      },
    });
  });
});
