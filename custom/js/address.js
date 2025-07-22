// *************************** [Address Detail ] *************************************************************************
$(document).ready(function () {
  var mode, add_id, res_DATA;

  const hash = window.location.hash;
  if (hash) {
    // Activate the tab based on hash
    $('a[href="' + hash + '"]').tab("show");
  }

  getAddressDetails();

  $("#add-address").click(function () {
    mode = "new";
    $("#addAddressModal").modal("show");
    $("#state_id").val("");
    $("#dist_id").val("");
    $(".address-title").html("Add Address");
  });

  $("#state_id").change(function () {
    let state_id = $(this).val();
    let token = localStorage.getItem("token");

    if (mode == "new") {
      $.ajax({
        type: "POST",
        url: base_Url + "getdist-data",
        data: { state_id: state_id },
        headers: { Authorization: "Bearer " + token },
        dataType: "json",
        success: function (res) {
          let distDta = "";
          distDta = "<option value=''>Select District</option>";
          for (let i = 0; i < res["response"].length; i++) {
            distDta += `<option value="${res["response"][i]["dist_id"]}">${res["response"][i]["dist_name"]}</option>`;
          }
          $("#dist_id").html(distDta);
        },
      });
    } else if (mode == "edit") {
      $.ajax({
        type: "POST",
        url: base_Url + "getdist-data",
        data: { state_id: state_id },
        headers: { Authorization: "Bearer " + token },
        dataType: "json",
        success: function (res) {
          let distDta = "";
          distDta = `<option value='${distID}'>${distName}</option>`;
          for (let i = 0; i < res["response"].length; i++) {
            distDta += `<option value="${res["response"][i]["dist_id"]}">${res["response"][i]["dist_name"]}</option>`;
          }
          $("#dist_id").html(distDta);
        },
      });
    }
  });

  // *************************** [Save Address ] *************************************************************************

  $("#btn_save").click(function () {
    let pincode = $("#pincode").val().trim().replace(/\s/g, "");

    if ($("#address").val() === "" && mode == "new") {
      showToast("Please fill address!", "info");
    } else if ($("#state_id").val() === "" && mode == "new") {
      showToast("Please Select State!", "info");
    } else if ($("#dist_id").val() === "") {
      showToast("Please Select District!", "info");
    } else if ($("#landmark").val() === "" && mode == "new") {
      showToast("Please Enter Landmark", "info");
    } else if ($("#city").val() === "" && mode == "new") {
      showToast("Please Enter City", "info");
    } else if (pincode === "" && mode == "new") {
      showToast("Please Enter Pincode", "info");
    } else {
      insertData();
    }
  });

  // *************************** [Insert Funtion ] ********************************************************************

  function insertData() {
    var form = $("#addAddressForm")[0];
    var data = new FormData(form);
    let token = localStorage.getItem("token");
    mode == "new";
    var url;
    if (mode == "new") {
      url = base_Url + "insert-address";
      var isChecked = $("#default_addr").prop("checked");
      data.append("default_addr", isChecked);
    } else if (mode == "edit") {
      url = base_Url + "update-address";
      var isChecked = $("#default_addr").prop("checked");
      data.append("default_addr", isChecked);
      data.append("add_id", add_id);
    }

    $.ajax({
      type: "POST",
      url: url,
      data: data,
      processData: false,
      contentType: false,
      cache: false,
      dataType: "JSON",
      headers: { Authorization: "Bearer " + token },
      success: function (resultData) {
        if (resultData.code == 200) {
          showToast(resultData.message, "success");
          $("#addAddressModal").modal("hide");
          setTimeout(function () {
            window.location.href = window.location.pathname + "#liton_tab_1_4";
            location.reload();
          }, 1000);
        } else {
          showToast(resultData.message, "error");
          $("#addAddressModal").modal("hide");
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
  }

  // *************************** [get Data] *************************************************************************
  function getAddressDetails() {
    let token = localStorage.getItem("token");
    $.ajax({
      type: "GET",
      url: base_Url + "get-address",
      dataType: "json",
      success: function (data) {
        res_DATA = data;
        editFunction(res_DATA);
      },
      error: function (error) {
        let status = error.status;
        showToast(error, "error");
      },
    });
  }
  // *************************** [Edit Data] *************************************************************************

  var stateID;
  var distID;
  var distName;
  function editFunction(res_DATA) {
    $(".edit-address").click(function () {
      mode = "edit";
      $(".address-title").html("Edit Address");
      var index = $(this).attr("index");

      $("#addAddressModal").modal("show");

      stateID = res_DATA[index]["state_id"];
      distID = res_DATA[index]["dist_id"];
      distName = res_DATA[index]["dist_name"];
      $("#state_id").val(stateID).trigger("change");

      // Fill other fields
      $("#landmark").val(res_DATA[index]["landmark"]);
      $("#city").val(res_DATA[index]["city"]);
      $("#address").val(res_DATA[index]["address"]);
      $("#pincode").val(res_DATA[index]["pincode"]);
      $("#default_addr").prop("checked", res_DATA[index]["default_addr"] == 1);
      add_id = res_DATA[index]["add_id"];
    });
  }

  // *************************** [Delete Data] *************************************************************************
  $(".address-delete").click(function () {
    mode = "delete";
    let token = localStorage.getItem("token");
    $("#deleteConfirmModal").modal("show");

    var index = $(this).attr("index");
    add_id = res_DATA[index]["add_id"];
    $(".btndelete").click(function () {
      $.ajax({
        type: "POST",
        url: base_Url + "delete-address",
        data: { add_id: add_id },
        headers: { Authorization: "Bearer " + token },
        dataType: "JSON",
        success: function (resultData) {
          if (resultData.code == 200) {
            showToast(resultData.message, "success");
            $("#deleteConfirmModal").modal("hide");
            setTimeout(function () {
              window.location.href =
                window.location.pathname + "#liton_tab_1_4";
              location.reload();
            }, 1000);
          } else {
            showToast(resultData.message, "error");
            $("#deleteConfirmModal").modal("hide");
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
    });
  });

  // *************************** [5.Default Address Change] *************************************************************************

  $(".default_address").click(function () {
    let addressID = $(this).data("addid");

    const currentChecked = $("input.checkout-add:checked");
    let newdefaultCheck = false;
    let addresshtml = "";

    token = localStorage.getItem("token");
    $.ajax({
      type: "POST",
      url: base_Url + "update-defaultaddress",
      data: { add_id: addressID },
      dataType: "JSON",
      headers: { Authorization: "Bearer " + token },
      success: function (JSONdata) {
        if (JSONdata.code == 400) {
          showToast(JSONdata.message, "error");
        } else if (JSONdata.code == 200) {
          showToast(JSONdata.message, "success");
          localStorage.setItem("goToSection", "deliverySection");
          setTimeout(function () {
            window.location.href = window.location.pathname + "#liton_tab_1_4";
            location.reload();
          }, 1000);
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
  });

  // *************************** [View Order] *************************************************************************
  $(".view-order").click(function () {
    let orderID = $(this).attr("data-orderid");
    let token = localStorage.getItem("token");
    var detailHtml = "";
    let returnedItemsHTML = "";

    $.ajax({
      type: "POST",
      url: "view-orderdetail",
      data: { orderid: orderID },
      dataType: "JSON",
      headers: { Authorization: "Bearer " + token },
      success: function (resultData) {
        let orderItemsHTML = "";
        let returnItemsHTML = "";

        let ShippingCharge = 100.0;

        let orderSummary = resultData.summary["order_status"];

        let returnedProdDisplay =
          resultData.summary["is_returned"] == 1 ? "" : "d-none";
        let CommonClass = "";
        let CommonBgClass = "";
        let TrackOrderDisp = "",
          dispClass = "";

        if (orderSummary == "New") {
          CommonClass = "text-primary";
          CommonBgClass = "alert-primary";
          TrackOrderDisp = "";
          dispClass = "col-md-9";
        } else if (orderSummary == "Pending") {
          CommonClass = "text-warning";
          CommonBgClass = "alert-warning";
          TrackOrderDisp = "d-none";
          dispClass = "col-md-12";
        } else if (orderSummary == "Shipped") {
          CommonClass = "text-info";
          CommonBgClass = "alert-info";
          TrackOrderDisp = "";
          dispClass = "col-md-9";
        } else if (orderSummary == "Delivered") {
          CommonClass = "text-success";
          CommonBgClass = "alert-success";
          TrackOrderDisp = "";
          dispClass = "col-md-9";
        } else if (orderSummary == "Failed") {
          CommonClass = "text-dark";
          CommonBgClass = "alert-dark";
          TrackOrderDisp = "d-none";
          dispClass = "col-md-12";
        } else if (orderSummary == "Cancelled") {
          CommonClass = "text-danger";
          CommonBgClass = "alert-danger";
          TrackOrderDisp = "d-none";
          dispClass = "col-md-12";
        } else {
          CommonBgClass = "alert-warning";
          CommonClass = "text-warning";
          TrackOrderDisp = "d-none";
          dispClass = "col-md-12";
        }

        resultData.summary.items.forEach((item) => {
          orderItemsHTML += `
                <div class="row align-items-center mb-3">
                    <div class="col-3 col-md-4">
                        <img class="img-fluid" src="${
                          base_Url + item.main_image
                        }" alt="${item.prod_name}" width="90">
                    </div>
                    <div class="col-9 col-md-8">
                        <h6 class="text-charcoal mb-1">
                            <a href="" class="text-charcoal">${
                              item.quantity
                            } x ${item.prod_name}</a>
                        </h6>
                        <div class="order-details-div">
                            <ul class="list-unstyled text-pebble small mb-0">
                                <li class="mt-0"><b>Packs:</b> ${
                                  item.pack_qty
                                }</li>
                                <li class="mt-0"><b>Price:</b> ${
                                  item.prod_price
                                }</li>
                            </ul>
                            <h5 class="text-charcoal mb-0"><b>₹${
                              item.sub_total
                            }</b></h5>
                        </div>
                    </div>
                </div>
            `;
        });

        resultData.summary.returned_items.forEach((item) => {
          returnItemsHTML += `
                <div class="row align-items-center mb-3">
                    <div class="col-3 col-md-4">
                        <img class="img-fluid" src="${
                          base_Url + item.main_image
                        }" alt="${item.prod_name}" width="90">
                    </div>
                    <div class="col-9 col-md-8">
                        <h6 class="text-charcoal mb-1">
                            <a href="#" class="text-charcoal">${
                              item.quantity
                            } x ${item.prod_name}</a>
                        </h6>
                        <div class="order-details-div">
                            <ul class="list-unstyled text-pebble small mb-0">
                                <li class="mt-0"><b>Packs:</b> ${
                                  item.pack_qty
                                }</li>
                                <li class="mt-0"><b>Price:</b> ${
                                  item.prod_price
                                }</li>
                            </ul>
                            <h5 class="text-charcoal mb-0"><b>₹${
                              item.sub_total
                            }</b></h5>
                        </div>
                    </div>
                </div>
            `;
        });

        detailHtml += `<div class="container-fluid">
                                            <!-- Order Header -->
                                            <div class="row bg-snow p-3">
                                                <div class="col-6 col-md-4">
                                                    <h6 class="text-charcoal mb-0"><i class="fas fa-receipt text-muted"></i> Order Number</h6>
                                                    <span class="text-pebble" id="orderNumber">${
                                                      resultData.summary[
                                                        "order_no"
                                                      ]
                                                    }</span>
                                                </div>
                                                <div class="col-6 col-md-4">
                                                    <h6 class="text-charcoal mb-0"><i class="fas fa-calendar-alt text-muted fa-fw"></i>Order Date</h6>
                                                    <span class="text-pebble" id="orderDate">${
                                                      resultData.summary[
                                                        "order_date"
                                                      ]
                                                    }</span>
                                                </div>
                                                <div class="col-6 col-md-4">
                                                    <h6 class="text-charcoal mb-0"><i class="fas fa-money-bill-wave text-muted fa-fw me-1"></i>Order Total</h6>
                                                    <span class="text-pebble" id="orderTotal">₹${
                                                      resultData.summary[
                                                        "order_total_amt"
                                                      ]
                                                    }</span>
                                                </div>
                                              
                                            </div>

                                            <!-- Order Status -->
                                            <div class="row p-3 bg-white px-0">
                                                <div class="${dispClass}">
                                                    <div class="alert ${CommonBgClass} p-2 mb-0" id="statusAlert">
                                                        <h6 class="${CommonClass} mb-0"><b class="orderStatus">${
          resultData.summary["order_status"]
        }</b></h6>
                                                        <p class="${CommonClass} mb-0 d-none d-md-block" id="deliveryInfo">
                                                            ${
                                                              resultData
                                                                .summary[
                                                                "delivery_message"
                                                              ]
                                                            }
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 text-end mt-2 mt-md-0 ${TrackOrderDisp}">
                                                    <button class="btn btn-outline-primary trackButton" data-orderid=${
                                                      resultData.summary[
                                                        "order_id"
                                                      ]
                                                    }
                                                     id="trackButton"><i class="fas fa-truck-moving"></i> Track Shipping </button>       
                                                </div>
                                            </div>

                                            <!-- Order Items -->
                                            ${orderItemsHTML}
                                            <div class="shoping-cart-total mt-2<?= $shoppingTotalClass ?>">
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <td>Sub total</td>
                                                            <td class="order-subtotal amt">₹${
                                                              resultData
                                                                .summary[
                                                                "order_sub_total"
                                                              ]
                                                            }</td>
                                                        </tr>
                                                        <tr>
                                                            <td>CGST(Includes)</td>
                                                            <td class="gst-td amt">₹${
                                                              resultData
                                                                .summary[
                                                                "cgst"
                                                              ] ?? "-"
                                                            }</td>
                                                        </tr>
                                                        <tr>
                                                            <td>SGST(Includes)</td>
                                                            <td class="sgst-td amt">₹${
                                                              resultData
                                                                .summary[
                                                                "sgst"
                                                              ] ?? "-"
                                                            }</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Shipping Charge</td>
                                                            <td class="shipping-charge amt">₹${ShippingCharge}.00</td>
                                                        </tr>

                                                        <tr>
                                                            <td><strong>Order Total</strong></td>
                                                            <td><strong class="order_total_amt amt">₹${
                                                              resultData
                                                                .summary[
                                                                "order_total_amt"
                                                              ]
                                                            }</strong></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>`;

        returnedItemsHTML += `
              <div class="container-fluid mt-4 ${returnedProdDisplay}">
                <div class="row">
                  <div class="col-12">
                    <h4 class="returned_products mb-3">Returned Products</h4>
                  </div>
                </div>

                ${returnItemsHTML}
              </div>
            `;

        detailHtml += returnedItemsHTML;
        $("#dynamic-order").html(detailHtml);
        $(".orderModal").modal("show");
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
  });
  $(document).on("click", ".trackButton", function () {
    let orderID = $(this).data("orderid");

    let encodedOrderID = baseEncode(orderID);
    window.location.href =
      base_Url + "order-tracking/?order_id=" + encodedOrderID;
  });

  function baseEncode(input) {
    return btoa(input);
  }

  // *************************** [Cancel Order] *************************************************************************
  var canclOrderID = "",
    canclOrderStatus = "";
  $(".cancel-order").click(function () {
    canclOrderID = $(this).data("orderid");
    canclOrderStatus = $(this).data("status");

    $("#cancel-modal").modal("show");
  });

  $("#confirmCancelBtn").on("click", function () {
    $("#cancel-modal").modal("hide");
    setTimeout(function () {
      $("#reason-modal").modal("show");
    }, 200);
  });

  $("#submitCancelReason").on("click", function () {
    var reason = $("#cancelReason").val().trim();
    if (reason === "") {
      showToast("Please enter a cancellation reason.", "warning");
      return;
    } else {
      submitCancel(canclOrderID, canclOrderStatus, reason);
    }
  });

  token = localStorage.getItem("token");

  function submitCancel(orderID, orderStatus, reason) {
    $.ajax({
      type: "POST",
      url: base_Url + "update-cancel-reason",
      data: {
        order_id: orderID,
        order_status: orderStatus,
        cancel_reason: reason,
      },
      dataType: "JSON",
      headers: { Authorization: "Bearer " + token },
      success: function (JSONdata) {
        if (JSONdata.code == 400) {
          showToast(JSONdata.message, "error");
        } else if (JSONdata.code == 200) {
          showToast(JSONdata.message, "success");

          $("#reason-modal").modal("hide");
          setTimeout(() => {
            window.location.reload();
          }, 1000);
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
  }

  // *************************** [Return  Products] *************************************************************************
  $(".returnproduct").click(function () {
    let status = $(this).data("status");
    let returnOrderID = $(this).data("orderid");
    let token = localStorage.getItem("token");

    let deliveredTime = new Date($(this).data("deliverytime"));
    const now = new Date();
    const diffDays = (now - deliveredTime) / (1000 * 60 * 60 * 24);

    if (status === "Delivered" && diffDays <= 7) {
      getReturnProducts(returnOrderID, token);
    } else {
      alert("Return not allowed for this order.");
    }
  });

  function getReturnProducts(orderID, token) {
    $.ajax({
      type: "POST",
      url: base_Url + "get-return-products",
      data: {
        order_id: orderID,
      },
      dataType: "JSON",
      headers: { Authorization: "Bearer " + token },
      success: function (JSONdata) {
        console.log(JSONdata);
        $(".return_product_modal").modal("show");
        displayReturnDetails(JSONdata);
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
  }

  function displayReturnDetails(result) {
    let returnHtml = "";
    let itemRows = "";

    let itemList = result.items;

    itemList.forEach((item, index) => {
      itemRows += `
        <tr>
            <td>
                <input type="checkbox" class="return-check" data-index="${index}" name="return_items[${index}][selected]" value="1">
            </td>
            <td>
                <strong>${item.prod_name}</strong><br>
                Pack Qty: ${item.pack_qty} <br>
                Price : ₹ ${item.prod_price}
                <input type="hidden" name="return_items[${index}][prod_id]" value="${item.prod_id}">
                <input type="hidden" name="return_items[${index}][variant_id]" value="${item.variant_id}">
                <input type="hidden" name="return_items[${index}][quantity]" value="${item.quantity}">
                <input type="hidden" name="return_items[${index}][prod_price]" value="${item.prod_price}">
                <input type="hidden" name="return_items[${index}][sub_total]" value="${item.sub_total}">
                <input type="hidden" name="return_items[${index}][main_image]" value="${item.main_image}">
                <input type="hidden" name="return_items[${index}][prod_name]" value="${item.prod_name}">
                <input type="hidden" name="return_items[${index}][pack_qty]" value="${item.pack_qty}">
            </td>
            <td>
                <img width="100px" src="${base_Url}${item.main_image}" />
            </td>
            <td>
                <textarea name="return_items[${index}][reason]" class="form-control return-reason" data-index="${index}" placeholder="Mention reason..."></textarea>
                <div class="text-danger error-msg" id="error-${index}" style="display:none;">Please enter a reason.</div>
            </td>
        </tr>`;
    });

    $("#return-orderno").html(`Return Products from Order ${result.order_no}`);

    returnHtml += `
    <form id="return-form">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Select</th>
                    <th>Product</th>
                    <th>Product Image</th>
                    <th>Reason for Return</th>
                </tr>
            </thead>
            <tbody>
                 <input type="hidden" name="order_id" value="${result.order_id}">

                ${itemRows}
            </tbody>
        </table>
        
        <div class="text-end">
            <button type="submit" class="btn btn-warning return-submit">Submit Return Request</button>
        </div>
    </form>`;

    $("#return-products").html(returnHtml);
  }

  $(document).on("submit", "#return-form", function (e) {
    e.preventDefault();

    let valid = true;
    let atLeastOneSelected = false;

    $(".return-check").each(function () {
      let index = $(this).data("index");
      let isChecked = $(this).is(":checked");
      let reason = $(`textarea[data-index="${index}"]`).val().trim();

      $(`#error-${index}`).hide();

      if (isChecked) {
        atLeastOneSelected = true;

        if (reason === "") {
          valid = false;
          $(`#error-${index}`).show();
        }
      }
    });

    if (!atLeastOneSelected) {
      showToast("Please select at least one product to return.", "warning");

      return;
    }

    if (!valid) {
      showToast("Please fill in reason for all selected products.", "warning");
      return;
    }
    submitReturnData();
  });

  function submitReturnData() {
    let formElement = document.getElementById("return-form");
    let formData = new FormData(formElement);
    $("#loader-overlay").show();
    $.ajax({
      type: "POST",
      url: base_Url + "submit-return-products",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "JSON",
      headers: { Authorization: "Bearer " + token },
      success: function (JSONdata) {
        $("#loader-overlay").hide();
        if (JSONdata.code == 200) {
          $(".return_product_modal").modal("hide");
          $(".returnproduct").addClass("d-none");
          showToast(JSONdata.message, "success");
          $(".returnproduct").html("Return Requested");
          setTimeout(() => {
            window.location.reload();
          }, 1000);
        } else if (JSONdata.code == 400) {
          $(".return_product_modal").modal("hide");
          showToast(JSONdata.message, "error");
        }
      },
      error: function (error) {
        $("#loader-overlay").hide();
        let status = error.status;
        if (status === 401) {
          localStorage.removeItem("token");
          window.location.href = base_Url;
        } else {
          showToast("Something went wrong.", "error");
        }
      },
    });
  }
});
