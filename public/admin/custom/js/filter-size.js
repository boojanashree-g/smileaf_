$(document).ready(function () {
  var mode, JSON, res_DATA, size_id;

  $.when(getTypeDetails()).done(function () {
    dispTypeDetails(JSON);
  });

  $("#add-detail").click(function () {
    mode = "new";
    $("#menu-form")[0].reset();
    $("#size-modal").val("");
    $("#size-modal").modal("show");
    if (mode == "new") {
      $("#btn-submit").html("Submit");
      $(".size-title").text("Add Product Size");
    }
  });

  // *************************** [Validation] ********************************************************************

  $("#btn-submit").click(function () {
    $(".error").hide();
    if ($("#size_name").val() === "" && mode == "new") {
      $(".size_name").html("Please Enter name*").show();
    } else {
      insertData();
    }
  });

  //*************************** [Insert] **************************************************************************

  function insertData() {
    var form = $("#menu-form")[0];
    data = new FormData(form);

    var url;
    if (mode == "new") {
      url = base_Url + "admin/filter-size/insert-data";
    } else if (mode == "edit") {
      url = base_Url + "admin/filter-size/update-data";
      data.append("size_id", size_id);
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

      success: function (data) {
        var resultData = data;

        if (resultData.code == 200) {
          Swal.fire({
            title: "Congratulations!",
            text: resultData["msg"],
            icon: "success",
          });

          $("#size-modal").modal("hide");
          getTypeDetails();
        } else {
          Swal.fire({
            title: "Failure",
            text: resultData["msg"],
            icon: "danger",
          });

          $("#size-modal").modal("hide");
          getTypeDetails();
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
  function getTypeDetails() {
    $("#ajax-loader").removeClass("d-none");
    $.ajax({
      type: "POST",
      url: base_Url + "admin/filter-size/get-data",
      dataType: "json",
      success: function (data) {
        $("#ajax-loader").addClass("d-none");
        res_DATA = data;
        dispTypeDetails(res_DATA);
      },
      error: function () {
        $("#ajax-loader").addClass("d-none");
        console.log("Error");
      },
    });
  }
  // *************************** [Display Data] *************************************************************************

  function dispTypeDetails(JSON) {
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
          mDataProp: "size_name",
        },
        {
          mDataProp: "status",
          render: (data, type, row, meta) => {
            const isActive = data == 1;
            return `
      <a 
        id="${row.size_id}" 
        class="badge bg-label-${isActive ? "success" : "danger"} btnStatus"  
        data-id="${row.size_id}" 
        data-status="${data}">
        ${isActive ? "Active" : "Inactive"}
      </a>`;
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

  // *************************** [Edit Status] *************************************************************************
  let statusId = null;

  $(document).on("click", ".btnStatus", function () {
    $("#status-modal").modal("show");
    $("#update-status").val();
    $(".status-title").html("Status");

    let statuss = $(this).data("status");
    $("#update-status").val(statuss);

    statusId = $(this).attr("id");
    console.log(statusId);
  });

  $("#submit-status").click(function () {
    let status = $("#update-status").val();

    if (status === "") {
      $(".update-status").html("Please Select Status*").show();
    } else {
      $.ajax({
        type: "POST",
        url: base_Url + "admin/filter-size/update-status",
        data: { status: status, id: statusId },
        dataType: "json",

        success: function (data) {
          if (data.code == 200) {
            Swal.fire({
              title: "Congratulations!",
              text: data.msg,
              icon: "success",
            });
          } else {
            Swal.fire({
              title: "Failure",
              text: data.msg,
              icon: "error",
            });
          }

          $("#status-modal").modal("hide");
          getTypeDetails();
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
  });

  // *************************** [Edit Data] *************************************************************************

  $(document).on("click", ".btnEdit", function () {
    $("#size-modal").modal("show");
    mode = "edit";

    if (mode == "edit") {
      $("#btn-submit").html("Update");
      $(".size-title").text("Edit Product Size");
    }

    var index = $(this).attr("id");
    $("#size_name").val(res_DATA[index].size_name);

    size_id = res_DATA[index].size_id;
  });

  // *************************** [Delete Data] *************************************************************************
  $(document).on("click", ".BtnDelete", function () {
    mode = "delete";
    var index = $(this).attr("id");
    size_id = res_DATA[index].size_id;

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
          url: base_Url + "admin/filter-size/delete-data",
          data: { size_id: size_id },

          success: function (data) {
            var resData = $.parseJSON(data);
            console.log(resData);

            if (resData.code == 200) {
              Swal.fire({
                title: "Congratulations!",
                text: resData["message"],
                icon: "success",
              });

              $("#model-data").modal("hide");
              getTypeDetails();
            } else {
              Swal.fire({
                title: "Failure",
                text: resData["message"],
                icon: "error",
              });

              $("#model-data").modal("hide");
              getTypeDetails();
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
