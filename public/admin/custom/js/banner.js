$(document).ready(function () {
  var mode, JSON, res_DATA, banner_id;

  $.when(getBannerDetails()).done(function () {
    dispBannerDetails(JSON);
  });

  function refreshDetails() {
    $.when(getBannerDetails()).done(function (brandDetails) {
      var table = $("#datatable").DataTable();
      table.clear();
      table.rows.add(brandDetails);
      table.draw();
      window.location.reload();
    });
  }

  $("#add-detail").click(function () {
    mode = "new";
    $("#banner-form")[0].reset();
    $("#banner_image_url").css("display", "none");
    $("#banner-modal").val("");
    $("#banner-modal").modal("show");
    if (mode == "new") {
      $("#btn-submit").html("Submit");
      $(".banner-title").text("Add Banner Details");
    }
  });

  // *************************** [Validation] ********************************************************************

  $("#btn-submit").click(function () {
    $(".error").hide();
    if ($("#banner_title").val() === "" && mode == "new") {
      $(".banner_title").html("Please Enter Title*").show();
    } else if ($("#banner_desc1").val() === "" && mode == "new") {
      $(".banner_desc1").html("Please Enter Description*").show();
    } else if ($("#banner_desc2").val() === "" && mode == "new") {
      $(".banner_desc2").html("Please Enter Description*").show();
    } else if ($("#banner_image").val() === "" && mode == "new") {
      $(".banner_image").html("Please Select Image*").show();
    } else if ($("#banner_link").val() === "" && mode == "new") {
      $(".banner_link").html("Please Enter link*").show();
    } else {
      insertData();
    }
  });

  //*************************** [Insert] **************************************************************************

  function insertData() {
    var form = $("#banner-form")[0];
    data = new FormData(form);

    var url;
    if (mode == "new") {
      url = base_Url + "admin/banner/insert-data";
    } else if (mode == "edit") {
      url = base_Url + "admin/banner/update-data";
      data.append("banner_id", banner_id);
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

          $("#banner-modal").modal("hide");
          refreshDetails();
        } else {
          Swal.fire({
            title: "Failure",
            text: resultData["msg"],
            icon: "danger",
          });

          $("#banner-modal").modal("hide");
          refreshDetails();
        }
      },
    });
  }

  // *************************** [Display the image on Modal ] ****************************************************

  $("#banner_image").on("change", function () {
    dispImg(this, "banner_image_url");
  });
  function dispImg(input, id) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $("#" + id).attr("src", e.target.result);
        $("#" + id).css("display", "block");
      };
      reader.readAsDataURL(input.files[0]);
    }
  }
  // *************************** [get Data] *************************************************************************
  function getBannerDetails() {
    $("#ajax-loader").removeClass("d-none");
    $.ajax({
      type: "POST",
      url: base_Url + "admin/banner/get-data",
      dataType: "json",
      success: function (data) {
        $("#ajax-loader").addClass("d-none");
        res_DATA = data;

        dispBannerDetails(res_DATA);
      },
      error: function () {
        $("#ajax-loader").addClass("d-none");
        console.log("Error");
      },
    });
  }
  // *************************** [Display Data] *************************************************************************

  function dispBannerDetails(JSON) {
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
          mDataProp: "banner_title",
        },
        {
          mDataProp: "banner_desc1",
        },
        {
          mDataProp: "banner_desc2",
        },
        {
          mDataProp: function (data, type, full, meta) {
            if (data.banner_image !== null)
              return (
                "<a href='" +
                base_Url +
                data.banner_image +
                "' target='_blank'><img src='" +
                base_Url +
                data.banner_image +
                "' alt='banner image' width='30'></a>"
              );
            else return "";
          },
        },
        {
          mDataProp: "banner_link",
        },

        {
          mDataProp: "has_banner",
          render: (data, type, row, meta) => {
            const isChecked = data == 1 ? "checked" : "";
            return `
      <label class="switch switch-success">
        <input type="checkbox" class="switch-input toggleBannerStatus"
               data-id="${row.banner_id}" data-status="${data}" ${isChecked}>
        <span class="switch-toggle-slider">
          <span class="switch-on">
            <i class="icon-base ti tabler-check"></i>
          </span>
          <span class="switch-off">
            <i class="icon-base ti tabler-x"></i>
          </span>
        </span>
        <span class="switch-label">${isChecked ? "Active" : "Inactive"}</span>
      </label>
    `;
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
  let bannerID = null;

  $(document).on("change", ".toggleBannerStatus", function () {
    const checkbox = $(this);
    const bannerID = checkbox.data("id");
    const newStatus = checkbox.is(":checked") ? 1 : 0;

    const prevStatus = !newStatus;

    $.ajax({
      type: "POST",
      url: base_Url + "admin/banner/update-status",
      data: { status: newStatus, id: bannerID },
      dataType: "json",

      success: function (data) {
        if (data.code == 200) {
          const label = checkbox.closest(".switch").find(".switch-label");
          label.text(newStatus ? "Active" : "Inactive");

          Swal.fire({
            title: "Congratulations!",
            text: data.msg,
            icon: "success",
          });
        } else {
          checkbox.prop("checked", prevStatus);

          Swal.fire({
            title: "Failure",
            text: data.msg,
            icon: "error",
          });
        }

        $("#status-modal").modal("hide");
        getSubmenuDetails();
      },

      error: function (xhr, status, error) {
        checkbox.prop("checked", prevStatus);

        Swal.fire({
          title: "Request Failed",
          text: "Something went wrong. Please try again later.",
          icon: "error",
        });
        console.error("AJAX Error:", status, error);
      },
    });
  });

  // *************************** [Edit Data] *************************************************************************

  $(document).on("click", ".btnEdit", function () {
    $("#banner-modal").modal("show");
    mode = "edit";

    if (mode == "edit") {
      $("#btn-submit").html("Update");
      $(".banner-title").text("Edit Banner Details");
    }

    var index = $(this).attr("id");

    $("#banner_link").val(res_DATA[index].banner_link);

    $("#banner_image_url").attr("src", base_Url + res_DATA[index].banner_image);
    $("#banner_image_url").addClass("active");
    $("#banner_image_url").css("display", "block");

    $("#banner_desc1").val(res_DATA[index].banner_desc1);
    $("#banner_desc2").val(res_DATA[index].banner_desc2);
    $("#banner_title").val(res_DATA[index].banner_title);
    banner_id = res_DATA[index].banner_id;
  });

  // *************************** [Delete Data] *************************************************************************
  $(document).on("click", ".BtnDelete", function () {
    mode = "delete";
    var index = $(this).attr("id");
    banner_id = res_DATA[index].banner_id;
    console.log(banner_id);

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
          url: base_Url + "admin/banner/delete-data",
          data: { banner_id: banner_id },

          success: function (data) {
            var resData = $.parseJSON(data);

            if (resData.code == 200) {
              Swal.fire({
                title: "Congratulations!",
                text: resData["message"],
                icon: "success",
              });

              $("#model-data").modal("hide");
              refreshDetails();
            } else {
              Swal.fire({
                title: "Failure",
                text: resData["message"],
                icon: "error",
              });

              $("#model-data").modal("hide");
              refreshDetails();
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
