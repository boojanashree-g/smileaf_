$(document).ready(function () {
  var mode, JSON, res_DATA;

  $.when(getCustomerDetails()).done(function () {
    dispCustomerDetails(JSON);
  });

  // *************************** [Display Data] *************************************************************************

  function dispCustomerDetails(JSON) {
    var i = 1;
    console.log(JSON);
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
          mDataProp: "username",
        },
        {
          mDataProp: "number",
        },
        {
          mDataProp: "email",
        },
        {
          mDataProp: "is_verified",
          render: function (data, type, row, meta) {
            return data == 1
              ? '<span class="badge bg-success">Verified</span>'
              : '<span class="badge bg-secondary">Not Verified</span>';
          },
        },
        {
          mDataProp: function (data, type, full, meta) {
            return (
              '<a id="' +
              meta.row +
              '" class="btn btnEdit text-info fs-14 lh-1"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-edit"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg></a>' +
              '<a id="' +
              meta.row +
              '" class="btn BtnDelete text-danger fs-14 lh-1"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg></a>'
            );
          },
        },
      ],
    });
  }

  // *************************** [get Data] *************************************************************************
  function getCustomerDetails() {
    $.ajax({
      type: "POST",
      url: base_Url + "admin/customer-details/get-data",
      dataType: "json",
      success: function (data) {
        console.log(data);
        res_DATA = data.users;
        dispCustomerDetails(res_DATA);
      },
      error: function () {
        console.log("Error");
      },
    });
  }

  // *************************** [Add Customers] *************************************************************************

  $("#add-customer").click(function () {
    mode = "new";
    $("#customer-form")[0].reset();
    $("#customer-modal").val("");
    $("#customer-modal").modal("show");
    if (mode == "new") {
      $("#btn-submit").html("Submit");
      $(".customer-title").text("Add Customer Details");
    }
  });

  // *************************** [Validation] **************************************************************************

  $("#btn-submit").click(function () {
    $(".error").hide();
    if ($("#customer_name").val() === "" && mode == "new") {
      $(".customer_name").html("Please Enter Name*").show();
    } else if ($("#customer_mobile").val() === "" && mode == "new") {
      $(".customer_mobile").html("Please Enter Mobile Number*").show();
    } else if ($("#customer_email").val() === "" && mode == "new") {
      $(".customer_email").html("Please Enter Email*").show();
    } else {
      insertData();
    }
  });

  //*************************** [Insert] **************************************************************************
  function insertData() {
    const form = $("#customer-form")[0];
    const data = new FormData(form);

    let url;
    if (mode === "new") {
      url = base_Url + "admin/customer-details/insert-data";
    } else if (mode === "edit") {
      url = base_Url + "admin/customer-details/update-data";
      data.append("user_id", user_id);
    }

    $.ajax({
      type: "POST",
      enctype: "multipart/form-data",
      url: url,
      data: data,
      processData: false,
      contentType: false,
      cache: false,
      dataType: "json",

      success: function (resultData) {
        if (resultData.code === 200 || resultData.code === 201) {
          Swal.fire({
            title: "Success!",
            text: resultData.message,
            icon: "success",
          });

          $("#customer-modal").modal("hide");
          getCustomerDetails();
        } else {
          Swal.fire({
            title: "Failure",
            text: resultData.message,
            icon: "error",
          });
          $("#customer-modal").modal("hide");
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
    mode = "delete";
    var index = $(this).attr("id");
    user_id = res_DATA[index].user_id;

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
          url: base_Url + "admin/customer-details/delete-data",
          data: { user_id: user_id },
          dataType: "json",
          success: function (data) {
            var resData = data;

            if (resData.code == 200) {
              Swal.fire({
                title: "Congratulations!",
                text: resData["message"],
                icon: "success",
              });

              $("#model-data").modal("hide");
              getCustomerDetails();
            } else {
              Swal.fire({
                title: "Failure",
                text: resData["message"],
                icon: "error",
              });

              $("#model-data").modal("hide");
              getCustomerDetails();
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

  // *************************** [Edit Data] *************************************************************************

  $(document).on("click", ".btnEdit", function () {
    $("#customer-modal").modal("show");
    mode = "edit";
    var index = $(this).attr("id");
    if (mode == "edit") {
      $("#btn-submit").html("Update");
      $(".customer-title").text("Edit Customer Details");
    }

    $("#customer_name").val(res_DATA[index].username);
    $("#customer_mobile").val(res_DATA[index].number);
    $("#customer_email").val(res_DATA[index].email);
    if (res_DATA[index].is_verified == 1) {
      $("#is_verified").prop("checked", true);
    } else {
      $("#is_verified").prop("checked", false);
    }

    user_id = res_DATA[index].user_id;
  });
});
