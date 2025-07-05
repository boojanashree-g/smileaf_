$(document).ready(function () {
  $(document).on("click", "#showProgressBtn", function (e) {
    e.preventDefault();
    let token = localStorage.getItem("token");
    let OrderID = $("#order_id").val();
    let mainID = $("#main-id").val();
    alert(mainID);
    if (OrderID == "") {
      showToast("Please Enter orderId !!", "error");
    } else {
      $.ajax({
        type: "POST",
        url: base_Url + "getorder-status",
        data: {},
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
              window.location.href =
                window.location.pathname + "#liton_tab_1_4";
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
    $(".order-tracking-status").removeClass("d-none");
  });
});
