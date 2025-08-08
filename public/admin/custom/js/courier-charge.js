$(document).ready(function () {
  var mode, JSON, res_DATA, delivery_id;

  $.when(getDetails()).done(function () {
    dispDetails(JSON);
  });

  $("#add-detail").click(function () {
    mode = "new";
    $("#offer_amount").val("");
    $("#menu-modal").modal("show");
    if (mode == "new") {
      $("#btn-submit").html("Submit");
      $(".menu-title").text("Add Courier Details");
    }
  });

  // *************************** [Validation] ********************************************************************

  $("#btn-submit").click(function () {
    $(".error").hide();
    if ($("#offer_amount").val() === "" && mode == "new") {
      $(".offer_amount").html("Enter offer amount*").show();
    } else {
      insertData();
    }
  });

  //*************************** [Insert] **************************************************************************

  function insertData() {
    let formData = new FormData();
    formData.append("offer_amount", $("#offer_amount").val());

    let url;
    if (mode === "new") {
      url = base_Url + "admin/courier/insert-data";
    } else if (mode === "edit") {
      url = base_Url + "admin/courier/update-data";
      formData.append("delivery_id", delivery_id);
    }

    $.ajax({
      type: "POST",
      enctype: "multipart/form-data",
      url: url,
      data: formData,
      processData: false,
      contentType: false,
      cache: false,
      dataType: "json",

      success: function (data) {
        var resultData = data;

        if (resultData.code == 200) {
          Swal.fire({
            title: "Congratulations!",
            text: resultData["msg"],
            icon: "success",
          });

          $("#menu-modal").modal("hide");
          getDetails();
        } else {
          Swal.fire({
            title: "Failure",
            text: resultData["msg"],
            icon: "danger",
          });

          $("#menu-modal").modal("hide");
          getDetails();
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
  // *************************** [get Data] *************************************************************************
  function getDetails() {
    $("#ajax-loader").removeClass("d-none");
    $.ajax({
      type: "POST",
      url: base_Url + "admin/courier/get-data",
      dataType: "json",
      success: function (data) {
        $("#ajax-loader").addClass("d-none");
        res_DATA = data;
        dispDetails(res_DATA);
      },
      error: function () {
        $("#ajax-loader").addClass("d-none");
        console.log("Error");
      },
    });
  }
  // *************************** [Display Data] *************************************************************************

  function dispDetails(JSON) {
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
          mDataProp: "offer_amount",
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

  // *************************** [Edit Data] *************************************************************************

  $(document).on("click", ".btnEdit", function () {
    $("#menu-modal").modal("show");
    mode = "edit";

    if (mode == "edit") {
      $("#btn-submit").html("Update");
      $(".menu-title").text("Edit Courier Details");
    }

    var index = $(this).attr("id");
    $("#offer_amount").val(res_DATA[index].offer_amount);

    delivery_id = res_DATA[index].delivery_id;
  });

  // *************************** [Delete Data] *************************************************************************
  $(document).on("click", ".BtnDelete", function () {
    mode = "delete";
    var index = $(this).attr("id");
    delivery_id = res_DATA[index].delivery_id;

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
          url: base_Url + "admin/courier/delete-data",
          data: { delivery_id: delivery_id },

          success: function (data) {
            var resData = $.parseJSON(data);

            if (resData.code == 200) {
              Swal.fire({
                title: "Congratulations!",
                text: resData["message"],
                icon: "success",
              });

              $("#model-data").modal("hide");
              getDetails();
            } else {
              Swal.fire({
                title: "Failure",
                text: resData["message"],
                icon: "error",
              });

              $("#model-data").modal("hide");
              getDetails();
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
});
