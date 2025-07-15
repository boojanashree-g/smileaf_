$(document).ready(function () {
  var JSON, res_DATA;

  $.when(getOrderDetails()).done(function () {
    dispOrderDetails(JSON);
  });
  // *************************** [get Data] *************************************************************************
  function getOrderDetails() {
    let orderStatus = $("#order_status").val();
    $.ajax({
      type: "POST",
      data: { status: orderStatus },
      url: base_Url + "admin/order-details/get-data",
      dataType: "json",
      success: function (data) {
        res_DATA = data;
        dispOrderDetails(res_DATA);
      },
      error: function () {
        console.log("Error");
      },
    });
  }
  // *************************** [Display Data] *************************************************************************

  function dispOrderDetails(JSON) {
    var i = 1;

    $("#datatable").DataTable({
      destroy: true,
      aaSorting: [],
      aaData: JSON,
      aoColumns: [
        {
          mDataProp: null,
          render: function (data, type, row, meta) {
            return i++;
          },
        },
        {
          mDataProp: "order_no",
        },
        {
          mDataProp: "username",
        },
        {
          mDataProp: "orderdate",
        },
        {
          data: "order_id",
          render: function (data, type, full, meta) {
            return (
              '<a href="javascript:void(0);" order-id="' +
              data +
              '" id="' +
              meta.row +
              '" class="orderDetailsView d-flex align-items-center gap-1">' +
              '<i class="ti ti-eye text-primary"></i>' +
              "View Order" +
              "</a>"
            );
          },
        },
        {
          data: null,
          render: function (data, type, full, meta) {
            if (type !== "display") return data.order_status;

            var status = data.order_status || "Unknown";
            var orderId = data.order_id || 0;

            var backgroundclr = "";
            switch (status) {
              case "New":
                backgroundclr = "badge bg-label-info";
                break;
              case "Pending":
                backgroundclr = "badge bg-label-dark";
                break;
              case "Shipped":
                backgroundclr = "badge bg-label-primary";
                break;
              case "Delivered":
                backgroundclr = "badge bg-label-success";
                break;
              case "Cancelled":
              case "Failed":
                backgroundclr = "badge bg-label-danger";
                break;
              case "Refund":
                backgroundclr = "badge bg-label-secondary";
                break;
              default:
                backgroundclr = "badge bg-label-light";
            }

            var capitalizedStatus =
              status.charAt(0).toUpperCase() + status.slice(1).toLowerCase();
            return (
              '<span class="' +
              backgroundclr +
              '">' +
              capitalizedStatus +
              "</span>" +
              ' <a href="javascript:void(0);" class="editStatusIcon" order-id="' +
              orderId +
              '" orderStatus="' +
              status +
              '" title="Edit Status">' +
              '<span class="' +
              backgroundclr +
              ' ms-2 d-inline-flex align-items-center justify-content-center" style="width: 26px; height: 26px; border-radius: 4px;">' +
              '<i class="ti ti-edit text-fill fs-14"></i>' +
              "</span></a>"
            );
          },
        },

        {
          mDataProp: function (data, type, full, meta) {
            var status = data.payment_status;

            var backgroundclr = "";
            if (status === "PENDING") {
              backgroundclr = "bg-label-warning";
            } else if (status === "COMPLETED") {
              backgroundclr = "bg-label-success";
            } else if (status === "FAILED" || status === "CANCELLED") {
              backgroundclr = "bg-label-danger";
            } else if (status === "REFUNDED") {
              backgroundclr = "bg-label-info";
            }

            // Capitalize first letter and lowercase the rest
            var capitalizedStatus =
              status.charAt(0).toUpperCase() + status.slice(1).toLowerCase();

            return (
              '<a order-id="' +
              data.order_id +
              '" id="' +
              meta.row +
              '" class="paymentDetails">' +
              '<span class="badge ' +
              backgroundclr +
              '">' +
              capitalizedStatus +
              "</span> " +
              "</a>"
            );
          },
        },
        {
          mDataProp: function (data, type, full, meta) {
            var status = data.delivery_status;

            var backgroundclr = "";
            if (status == "Order Pending") {
              backgroundclr = "bg-label-info";
            } else if (status == "New") {
              backgroundclr = "bg-label-info";
            } else if (status == "Pending") {
              backgroundclr = "bg-label-dark";
            } else if (status == "Shipped") {
              backgroundclr = "bg-label-primary";
            } else if (status == "Delivered") {
              backgroundclr = "bg-label-success";
            } else if (status == "Refund Created") {
              backgroundclr = "bg-label-secondary";
            } else if (status == "Refund Processed") {
              backgroundclr = "bg-label-secondary";
            } else if (status == "Cancelled" || status == "Refund Failed") {
              backgroundclr = "bg-label-danger";
            }

            return (
              '<a order-id="' +
              data.order_id +
              '" id="' +
              meta.row +
              '" class="deliveryStatus">' +
              '<span class="badge ' +
              backgroundclr +
              '">' +
              status +
              "</span> " +
              "</a>"
            );
          },
        },

        {
          mDataProp: function (data, type, full, meta) {
            return (
              '<a order-id="' +
              data.order_id +
              '" id="' +
              meta.row +
              '" class="btn btnEdit  text-info fs-14 lh-1"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-edit"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg></a>' +
              '<a id="' +
              meta.row +
              '" class="btn BtnDelete text-danger fs-14 lh-1"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg></a>'
            );
          },
        },
      ],
    });
  }

  // *************************** [Order View Datas] *************************************************************************
  $(document).on("click", ".orderDetailsView", function () {
    let orderID = $(this).attr("order-id");

    $.ajax({
      type: "POST",
      url: base_Url + "admin/order-details/get-orderview",
      data: { order_id: orderID },
      dataType: "json",

      success: function (data) {
        if (data.code == 200) {
          displayorderView(data.summary);
        } else {
          Swal.fire({
            title: "Failure",
            text: data.msg,
            icon: "error",
          });
        }
      },

      error: function (xhr, status, error) {
        Swal.fire({
          title: "Request Failed",
          text: "Something went wrong. Please try again later.",
          icon: "error",
        });
        console.error("AJAX Error:", status, error);
      },
    });
  });

  // *************************** [Edit Order Status] *************************************************************************
  let orderStatusID;
  let updatedOrderStatus;

  $(document).on("click", ".editStatusIcon", function () {
    orderStatusID = $(this).attr("order-id");
    $("#order-status").modal("show");
  });

  $("#confirmCancelBtn").click(function () {
    $("#cancel-modal1").modal("hide");
    $("#reason-modal").modal("show");
  });

  $("#submitCancelReason").click(function () {
    let cancelReason = $("#cancelReason").val();

    if (cancelReason === "") {
      alert("Please Enter Cancel Reason");
      return;
    } else {
      updateOrderStatus(updatedOrderStatus, orderStatusID, cancelReason);
    }
  });

  $("#update-status").click(function () {
    $(".updated_order_status").empty();
    updatedOrderStatus = $("#updated_order_status").val();

    if (updatedOrderStatus === "") {
      alert("Please Select Order Status");
      return;
    } else if (updatedOrderStatus === "Cancelled") {
      $("#order-status").modal("hide");
      $("#cancel-modal1").modal("show");
      $("#reason-modal").modal("hide");
    } else {
      updateOrderStatus(updatedOrderStatus, orderStatusID);
    }
  });

  function updateOrderStatus(
    updatedOrderStatus,
    orderStatusID,
    cancelReason = ""
  ) {
    $.ajax({
      type: "POST",
      url: base_Url + "admin/order-details/update-orderstatus",
      data: {
        order_id: orderStatusID,
        status: updatedOrderStatus,
        reason: cancelReason,
      },
      dataType: "json",

      success: function (data) {
        if (data.code == 200) {
          Swal.fire({
            title: "Request Success",
            text: data.message,
            icon: "success",
          });

          $("#order-status").modal("hide");
          $("#reason-modal").modal("hide");
          setTimeout(() => {
            window.location.reload();
          }, 2000);
        } else if (data.code == 400) {
          Swal.fire({
            title: "Request Failed",
            text: data.message,
            icon: "error",
          });
          $("#order-status").modal("hide");
          $("#reason-modal").modal("hide");
        }
      },

      error: function (xhr, status, error) {
        Swal.fire({
          title: "Request Failed",
          text: "Something went wrong. Please try again later.",
          icon: "error",
        });
        $("#order-status").modal("hide");
        $("#reason-modal").modal("hide");
        console.error("AJAX Error:", status, error);
      },
    });
  }

  // *************************** [Display Order Details] *************************************************************************
  function displayorderView(orderDetails) {
    $("#vieworder-modal").modal("show");
    let viewOrders = "";

    let ReasonC =
      orderDetails.order_status.trim() === "Cancelled" ? "" : "d-none";
    let paymentMethod = orderDetails.payment_method;
    let capitalizedMethod =
      paymentMethod.charAt(0).toUpperCase() +
      paymentMethod.slice(1).toLowerCase();

    let paymentStatus = orderDetails.payment_status;
    let capitalizedStatus =
      paymentStatus.charAt(0).toUpperCase() +
      paymentStatus.slice(1).toLowerCase();

    let orderItemsData = orderDetails.items;
    let orderItemHtml = "";
    orderItemsData.forEach(function (items, i) {
      let offerType = items.offer_type;

      let displayOfferType =
        offerType == 0
          ? "None"
          : offerType == 1
          ? "Flat Discount"
          : "Percentage";

      let offerDetails = items.offer_details == 0 ? "-" : items.offer_details;

      orderItemHtml += `
     <tr>
        <td>${i + 1} .</td>
        <td class="sorting_1">
            <div
                class="d-flex align-items-center">
                <div
                    class="avatar-wrapper me-3 rounded-2 bg-label-secondary">
                    <div class="avatar"><img
                            src="${base_Url + items.main_image}"
                            alt="Product-8"
                            class="rounded">
                    </div>
                </div>

            </div>
        </td>

        <td>
            <div
                class="d-flex flex-column justify-content-center">
                <span
                    class="text-heading text-wrap fw-medium">${
                      items.prod_name
                    }</span>
                <span
                    class="text-truncate mb-0 d-none d-sm-block"><small>Pack Quantity :${
                      items.pack_qty
                    } </small></span>
            </div>
        </td>
        <td>₹${items.prod_price} 
        </td>
        <td><span
                class="badge bg-label-primary me-1">${displayOfferType}
                </span>
        </td>
        <td>${offerDetails}
        </td>
        <td>₹${items.offer_price} 
        </td>
          <td>${items.quantity} 
        </td>
        <td>₹${items.sub_total}</td>

    </tr>`;
    });

    viewOrders += `
      <div class="col-xl-12 mb-6 mb-xl-0">

      <div class="row mb-6 g-6">
          <div class="col-md">

              <div
                  class="form-check custom-option custom-option-basic checked">

                  <label class="form-check-label custom-option-content"
                      for="customRadioAddress1">
                      <input name="customRadioTemp" class="form-check-input"
                          type="radio" value="" id="customRadioAddress1"
                          checked="">
                      <span class="custom-option-header mb-2">
                          <span class="fw-medium text-heading mb-0">${orderDetails.user_details.username}  (${orderDetails.user_details.email})</span>
                      </span>
                      <span class="custom-option-body">
                          <small>${orderDetails.user_details.address},<br>
                          ${orderDetails.user_details.city}, <br>
                          ${orderDetails.user_details.landmark}, <br>
                          ${orderDetails.user_details.dist_name} , ${orderDetails.user_details.state_title}  <br>
                          ${orderDetails.user_details.pincode} <br>
                          <b>Mobile Number :</b> ${orderDetails.user_details.number} <br>

                          </small>
                      </span>
                  </label>
              </div>
          </div>
      </div>
      <!-- Select address -->
      <div class="row mb-6">
          <div class="col-12">
              <ul class="list-group list-group-horizontal-md">
                  <li class="list-group-item flex-fill p-6 text-body">
                      <h6
                          class="d-flex align-items-center gap-2 order-header">
                          <i class="ti ti-package"></i>Order Details
                      </h6>
                      <address class="mb-0">
                          <div class="d-flex mb-1">
                              <b class="me-2" style="min-width: 160px;">Order
                                  Status</b>: <span
                                  class="ms-2"><span class="badge bg-label-primary">${orderDetails.order_status}</span>
                          </div>
                           <div class="d-flex mb-1 ${ReasonC}"> 
                              <b class="me-2 "
                                  style="min-width: 160px;">Cancel Reason</b> :<span
                                  class="ms-2">${orderDetails.delivery_message}</span>
                          </div>
                          
                          <div class="d-flex mb-1"> 
                              <b class="me-2"
                                  style="min-width: 160px;">Razorpay
                                  OrderID</b>: <span
                                  class="ms-2">${orderDetails.razerpay_order_id}</span>
                          </div>
                          <div class="d-flex mb-1">
                              <b class="me-2" style="min-width: 160px;">Order
                                  ID</b>: <span class="ms-2">${orderDetails.order_no}</span>
                          </div>
                          <div class="d-flex mb-1">
                              <b class="me-2" style="min-width: 160px;">Order
                                  Date</b>: <span
                                  class="ms-2">${orderDetails.order_date}</span>
                          </div>
                      </address>
                  </li>


                  <li class="list-group-item flex-fill p-5 text-body">
                      <h6
                          class="d-flex align-items-center gap-2 order-header">
                          <i class="ti ti-credit-card"></i> Payment Details
                      </h6>
                      <address class="mb-0">
                          <div class="d-flex mb-1">
                              <b class="me-2"
                                  style="min-width: 160px;">Payment
                                  Status</b>: <span
                                  class="ms-2"><span class="badge bg-label-primary">${capitalizedStatus}</span>
                          </div>
                          <div class="d-flex mb-1">
                              <b class="me-2"
                                  style="min-width: 160px;">Razorpay
                                  PaymentID</b>: <span
                                  class="ms-2">${orderDetails.razerpay_payment_id}</span>
                          </div>
                          <div class="d-flex mb-1">
                              <b class="me-2"
                                  style="min-width: 160px;">Payment
                                  Method</b>: <span
                                  class="ms-2">${capitalizedMethod}</span>
                          </div>

                      </address>
                  </li>

              </ul>


              <div class="col-xl-12 mb-6 mb-xl-0 mt-2">
                  <div class="card">
                   <div class="d-flex flex-column">
                      <div class="row">
                        <div class="col-lg-8">
                          <h5 class="card-header order-header">
                            <i class="ti ti-shopping-cart"></i> Order Items
                          </h5>
                        </div>

                        <div class="col-lg-4 mt-4 p-5 d-flex  justify-content-end align-items-start">
                          <button type="button" class="btn btn-label-success waves-effect print-invoice"  data-orderid= ${orderDetails.order_id}>Generate Invoice &nbsp;<i class="ti ti-printer"></i>
                          </button>
                        </div>
                      </div>
                    </div>

                      
                      <div class="table-responsive text-nowrap">
                          <table class="table">
                              <thead class="table-light">
                                  <tr>
                                      <th>S.No</th>
                                      <th>Items</th>
                                      <th>Product name</th>
                                      <th>MRP</th>
                                      <th>Offer Type</th>
                                      <th>Offer Details</th>
                                      <th>Offer Price</th>
                                      <th>Quantity</th>
                                      <th>Total Price</th>
                                  </tr>
                              </thead>
                              <tbody class="table-border-bottom-0">
                                  

                                  ${orderItemHtml}
                                  <tr>
                                      <td colspan="4"></td>
                                      <td colspan="4">
                                          <div class="fw-semibold"
                                              style="text-align: right;">
                                              Sub Total
                                              :</div>
                                      </td>
                                      <td colspan="5">
                                          <span class="fs-16 fw-semibold">
                                              ₹${orderDetails.order_sub_total}</span>
                                      </td>
                                  </tr>

                                  <tr>
                                      <td colspan="4"></td>
                                      <td colspan="4">
                                          <div class="fw-semibold"
                                              style="text-align: right;">
                                              CGST(Includes)
                                              :</div>
                                      </td>
                                      <td colspan="5">
                                          <span class="fs-16 fw-semibold">
                                              ₹${orderDetails.cgst}</span>
                                      </td>
                                  </tr>

                                  <tr>
                                      <td colspan="4"></td>
                                      <td colspan="4">
                                          <div class="fw-semibold"
                                              style="text-align: right;">
                                              SGST(Includes)
                                              :</div>
                                      </td>
                                      <td colspan="5">
                                          <span class="fs-16 fw-semibold">
                                              ₹${orderDetails.sgst}</span>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td colspan="4"></td>
                                      <td colspan="4">
                                          <div class="fw-semibold"
                                              style="text-align: right;">
                                              Shipping
                                              :</div>
                                      </td>
                                      <td colspan="5">
                                          <span class="fs-16 fw-semibold">
                                              ₹${orderDetails.courier_charge}</span>
                                      </td>
                                  </tr>

                                  <tr>
                                      <td colspan="4"></td>
                                      <td colspan="4">
                                          <div class="fw-semibold"
                                              style="text-align: right;">Total
                                              Price :</div>
                                      </td>
                                      <td colspan="5">
                                          <span class="fs-16 fw-semibold">
                                               ₹${orderDetails.order_total_amt}</span>
                                      </td>
                                  </tr>

                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>
          </div>
      </div>

  </div>`;

    $("#orderDetails").html(viewOrders);
  }

  // *************************** [Update Tracking Details] *************************************************************************
  var trackingOrderID = "";
  $(document).on("click", ".btnEdit", function () {
    trackingOrderID = $(this).attr("order-id");
    $("#tracking-modal").modal("show");

    $.ajax({
      type: "POST",
      url: base_Url + "admin/order-details/get-trackingdetails",
      data: { order_id: trackingOrderID },
      dataType: "json",

      success: function (data) {
        $("#courier_partner").val(data.courier_partner);
        $("#tracking_link").val(data.tracking_link);
        $("#tracking_id").val(data.tracking_id);
        $("#bill_no").val(data.bill_no);
        $("#bill_date").val(data.bill_date);
        $("#delivery_date").val(data.delivery_date);
      },

      error: function (xhr, status, error) {
        Swal.fire({
          title: "Request Failed",
          text: "Something went wrong. Please try again later.",
          icon: "error",
        });
        console.error("AJAX Error:", status, error);
      },
    });
  });

  $("#update-tracking").click(function () {
    var form = $("#tracking_details_form")[0];
    var formData = new FormData(form);
    formData.append("orderID", trackingOrderID);

    updateTrackingDetails(formData);
  });

  function updateTrackingDetails(formData) {
    $.ajax({
      type: "POST",
      url: base_Url + "admin/order-details/update-trackingdetails",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",

      success: function (data) {
        if (data.code == 200) {
          Swal.fire({
            title: "Congratulations!",
            text: data.message,
            icon: "success",
          });

          $("#tracking-modal").modal("hide");
        } else {
          Swal.fire({
            title: "Failure",
            text: data.message,
            icon: "error",
          });
          $("#tracking-modal").modal("hide");
        }
      },

      error: function (xhr, status, error) {
        Swal.fire({
          title: "Request Failed",
          text: "Something went wrong. Please try again later.",
          icon: "error",
        });
        console.error("AJAX Error:", status, error);
      },
    });
  }

  // *************************** [Delete Data] *************************************************************************
  $(document).on("click", ".BtnDelete", function () {
    var index = $(this).attr("id");
    order_id = res_DATA[index].order_id;
    Swal.fire({
      title: "Are you sure?",
      text: "You want to delete it?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "POST",
          url: base_Url + "admin/order-details/delete-data",
          data: { order_id: order_id },

          success: function (data) {
            var resData = $.parseJSON(data);

            if (resData.code == 200) {
              Swal.fire({
                title: "Congratulations!",
                text: resData["message"],
                icon: "success",
              });

              $("#model-data").modal("hide");
              getOrderDetails();
            } else {
              Swal.fire({
                title: "Failure",
                text: resData["message"],
                icon: "error",
              });

              $("#model-data").modal("hide");
              getOrderDetails();
            }
          },
          error: function (xhr, status, error) {
            Swal.fire({
              title: "Error!",
              text: "Something went wrong. Please try again later.",
              icon: "error",
            });

            console.error("AJAX Error:", status, error);
            $("#model-data").modal("hide");
          },
        });
      }
    });
  });

  // *************************** [Invoice Genertation] *************************************************************************

  $(document).on("click", ".print-invoice", function () {
    let inv_orderID = $(this).data("orderid");

    var encodedOrderID = btoa(inv_orderID);
    var pdfURL = base_Url + "admin/order-details/pdf-viewpage?orderID=" + encodedOrderID;

    var printWindow = window.open(pdfURL, "_blank");

    // if (printWindow) {
    //   printWindow.print();
    //   printWindow.onafterprint = function () {
    //     printWindow.close();
    //   };
    // } else {
    //   alert("Popup blocked! Please allow popups for this site.");
    // }
  });
});
