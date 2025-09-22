$(document).ready(function () {
  $(".free-courier").addClass("d-none");
  //Cart quantity

  var inputField, currentQty, sellingPrice;

  // totalAmount();
  initialCartTotal();
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
    $(".free-courier").addClass("d-none");

    $.ajax({
      type: "POST",
      url: base_Url + "update-cart",
      data: {
        quantity: qty,
        cart_id: cartID,
      },
      dataType: "json",
      success: function (data) {
        if (data.code == 200) {
          let displayPrice = `.total_${cartID}`;
          $(displayPrice).text("₹" + data.sub_total);

          $(".order_total_amt").text(
            "₹" +
              Number(data.final_total).toLocaleString("en-IN", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
              })
          );

          $(".order-subtotal").text(
            "₹" +
              Number(data.sub_total_without_gst).toLocaleString("en-IN", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
              })
          );

          // GST Split
          if (parseFloat(data.gst) > 0) {
            $("td.gst-td").text(
              "₹" +
                Number(data.cgst).toLocaleString("en-IN", {
                  minimumFractionDigits: 2,
                  maximumFractionDigits: 2,
                })
            );
            $("td.sgst-td").text(
              "₹" +
                Number(data.sgst).toLocaleString("en-IN", {
                  minimumFractionDigits: 2,
                  maximumFractionDigits: 2,
                })
            );
          } else {
            $("td.gst-td").text("-");
            $("td.sgst-td").text("-");
          }

          // Free shipping message
          if (data.free_shipping_msg) {
            $(".free-courier").removeClass("d-none");
            $(".courier-alert-msg").html(data.free_shipping_msg);
          }
        } else {
          console.log("Error: " + data.status);
        }
      },
      error: function () {
        console.log("Server error");
      },
    });
  }

  function initialCartTotal() {
    $.ajax({
      type: "GET",
      url: base_Url + "get-inital-cart",
      dataType: "json",
      success: function (data) {
        if (data.code == 200) {
          $(".order_total_amt").text(
            "₹" +
              Number(data.final_total).toLocaleString("en-IN", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
              })
          );

          $(".order-subtotal").text(
            "₹" +
              Number(data.sub_total_without_gst).toLocaleString("en-IN", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
              })
          );

          // GST Split
          if (parseFloat(data.gst) > 0) {
            $("td.gst-td").text(
              "₹" +
                Number(data.cgst).toLocaleString("en-IN", {
                  minimumFractionDigits: 2,
                  maximumFractionDigits: 2,
                })
            );
            $("td.sgst-td").text(
              "₹" +
                Number(data.sgst).toLocaleString("en-IN", {
                  minimumFractionDigits: 2,
                  maximumFractionDigits: 2,
                })
            );
          } else {
            $("td.gst-td").text("-");
            $("td.sgst-td").text("-");
          }

          // Free shipping message
          if (data.free_shipping_msg) {
            $(".free-courier").removeClass("d-none");
            $(".courier-alert-msg").html(data.free_shipping_msg);
          }
        } else {
          console.log("Error: " + data.status);
        }
      },
      error: function () {
        console.log("Server error");
      },
    });
  }

  // Frontend calculation
  // function totalAmount() {
  //   let totalAmt = 0;
  //   let totalGstValue = 0;
  //   let subTotal = 0;
  //   let finalTotal = 0;

  //   $(".cart-product-subtotal").each(function () {
  //     let price = $(this).text().replace(",", "").replace("₹", "").trim();
  //     let amount = parseFloat(price);

  //     // Get GST percent from data attribute
  //     let gstPercent = parseFloat($(this).data("gst")) || 0;

  //     let gstValue = 0;
  //     if (gstPercent > 0 && !isNaN(amount)) {
  //       gstValue = (amount * gstPercent) / (100 + gstPercent);
  //       let paise = parseFloat((gstValue % 1).toFixed(2)) * 100;
  //       gstValue = paise < 50 ? Math.floor(gstValue) : Math.ceil(gstValue);
  //     }

  //     if (!isNaN(amount)) totalAmt += amount;
  //     if (!isNaN(gstValue)) totalGstValue += gstValue;
  //   });

  //   totalAmt = parseFloat(totalAmt.toFixed(2));
  //   totalGstValue = parseFloat(totalGstValue.toFixed(2));
  //   subTotal = (totalAmt - totalGstValue).toFixed(2);
  //   finalTotal = totalAmt + 100;

  //   // Display total
  //   $(".order_total_amt").text(
  //     "₹" +
  //       Number(finalTotal).toLocaleString("en-IN", {
  //         minimumFractionDigits: 2,
  //         maximumFractionDigits: 2,
  //       })
  //   );
  //   $(".order-subtotal").text(
  //     "₹" +
  //       Number(subTotal).toLocaleString("en-IN", {
  //         minimumFractionDigits: 2,
  //         maximumFractionDigits: 2,
  //       })
  //   );

  //   let courierFreeAmt = $("#courier_offer").val();
  //   let courierOfferLimit = $("#courier_offer_limit").val();

  //   let finalSubTotal = Number(totalAmt);
  //   let remainingAmt;

  //   if (finalSubTotal > courierOfferLimit && finalSubTotal <= courierFreeAmt) {
  //     remainingAmt = courierFreeAmt - finalSubTotal;
  //     $(".free-courier").removeClass("d-none");
  //     $(".courier-alert-msg").html(
  //       `🛒 You're just ₹${remainingAmt} away from <strong>Free Shipping</strong>! Add more to your cart now!!`
  //     );
  //   }

  //   // Split GST
  //   if (totalGstValue > 0) {
  //     let halfGst = parseFloat((totalGstValue / 2).toFixed(2));

  //     $("td.gst-td").text(
  //       "₹" +
  //         Number(halfGst).toLocaleString("en-IN", {
  //           minimumFractionDigits: 2,
  //           maximumFractionDigits: 2,
  //         })
  //     );
  //     $("td.sgst-td").text(
  //       "₹" +
  //         Number(halfGst).toLocaleString("en-IN", {
  //           minimumFractionDigits: 2,
  //           maximumFractionDigits: 2,
  //         })
  //     );
  //   } else {
  //     $("td.gst-td").text("-");
  //     $("td.sgst-td").text("-");
  //   }
  // }

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

  $(".proceed_checkout").click(function () {
    let sourceType = "cart";
    $.ajax({
      type: "POST",
      url: base_Url + "check-product-status",
      data: { source: sourceType },
      dataType: "json",

      success: function (resData) {
        if (resData.code == 400) {
          let itemDisp = resData.outofStockCount > 1 ? "items" : "item";
          showToast(
            `${resData.outofStockCount} ${itemDisp} in your cart are out of stock.Please remove it from your cart to proceed.`,
            "error"
          );
        } else if (resData.code == 200) {
          window.location.href = base_Url + "checkout?type=" + sourceType;
        }
      },
      error: function (err) {
        console.log(err);
      },
    });
  });
});
