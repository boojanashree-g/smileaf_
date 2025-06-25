$(document).ready(function () {
  var mode, JSON, res_DATA, sub_id;

  $.when(getFeaturedProductDetails()).done(function () {
    dispProductDetails(JSON);
  });

  // *************************** [get Data] *************************************************************************
  function getFeaturedProductDetails() {
    $.ajax({
      type: "POST",
      url: base_Url + "admin/featured-products/getFeaturedProductDetails",
      dataType: "json",
      success: function (data) {
        res_DATA = data;
        console.log(data, "data");
        dispProductDetails(res_DATA);
      },
      error: function () {
        console.log("Error");
      },
    });
  }
  // *************************** [Display Data] *************************************************************************

  function dispProductDetails(JSON) {
    var i = 1;
    $("#datatable").DataTable({
      destroy: true,
      aaSorting: [],
      aaData: JSON,
      aoColumns: [
        {
          mData: null,
          render: function (data, type, row, meta) {
            return i++;
          },
        },
        {
          mData: "submenu",
        },
        {
          mData: "image_url",
          render: function (data, type, row, meta) {
            if (data !== null && data !== "") {
              return (
                "<a href='" +
                base_Url +
                data +
                "' target='_blank'><img src='" +
                base_Url +
                data +
                "' alt='banner image' width='30'></a>"
              );
            } else {
              return "";
            }
          },
        },
        {
          mData: "prod_name",
        },
        {
          mData: null,
          render: function (data, type, row, meta) {
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

  // *************************** [ Functions] ********************************************************************

  $("#add-detail").click(function () {
    mode = "new";
    $("#product-form")[0]?.reset();
    $("#product-modal").val("");
    $("#main_image_url").hide();
    $("#sub_id").val("");

    const menu_id = $("#menu_id").val();

    if (mode == "new") {
      $("#btn-submit").html("Submit");
      $(".subcat-title").text("Add Product Details");
    }

    $("#defaultSection").show();

    // Show modal using Bootstrap 5 JS API
    const modalEl = document.getElementById("product-modal");
    const modal = new bootstrap.Modal(modalEl, {
      backdrop: "static",
      keyboard: false,
    });
    modal.show();
  });

  // *************************** [Validation] ********************************************************************

  $("#btn-submit").click(function () {
    $(".error").hide();

    var mainImageInput = $("#main_image")[0];
    var file = mainImageInput.files[0];
    var maxSize = 500 * 1024; // 500 KB

    if ($("#prod_name").val() === "" && mode == "new") {
      $(".prod_name").html("Please Enter Product Name*").show();
      return;
    }

    if (mainImageInput.files.length === 0 && mode == "new") {
      $(".main_image").html("Please Select Image*").show();
      return;
    }

    if (file && file.size > maxSize && mode == "new") {
      $(".main_image").html("Image size must be less than 500KB*").show();
      return;
    }

    console.log("Calling insertData()");
    insertData();
  });

  //*************************** [Insert] **************************************************************************

  function insertData() {
    var form = $("#featured-product-form")[0];
    var data = new FormData(form);

    for (var pair of data.entries()) {
      console.log(pair[0] + ": " + pair[1]);
    }

    var url;
    if (mode === "new") {
      url = base_Url + "admin/featured-products/insert-data";
    } else if (mode === "edit") {
      url = base_Url + "admin/featured-products/update-data";

      $("input[name='existing_images[]']").each(function () {
        data.append("existing_images[]", $(this).val());
      });
      data.append("prod_id", prod_id);
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
        console.log(resultData);

        if (resultData.code == 200) {
          Swal.fire({
            title: "Success!",
            text: resultData["msg"],
            icon: "success",
          });

          const modalEl = document.getElementById("product-modal");
          const modal = bootstrap.Modal.getInstance(modalEl);
          modal.hide();

          getFeaturedProductDetails();
        } else {
          Swal.fire({
            title: "Failure",
            text: resultData["msg"],
            icon: "error",
          });

          const modalEl = document.getElementById("product-modal");
          const modal = bootstrap.Modal.getInstance(modalEl);
          modal.hide();

          getFeaturedProductDetails();
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

$(document).on("click", ".btnEdit", function () {
  $("#product-modal").modal("show");
  $("#images").val("");
  $("#preview").empty();

  selectedFiles = [];
  existingImages = [];
  mode = "edit";

  if (mode == "edit") {
    $("#btn-submit").html("Update");
    $(".subcat-title").text("Edit Product Details");
  }

  var index = $(this).attr("id");

  const data = res_DATA[index];

  prod_id = data.prod_id;

  $("#sub_id").val(data.submenu_id); 
  $("#prod_name").val(data.prod_name);

  if (data.image_url) {
    $("#main_image_url")
      .attr("src", base_Url + data.image_url)
      .css("display", "block");
  } else {
    $("#main_image_url").css("display", "none");
  }
});

$("#main_image").on("change", function (event) {
  const file = event.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function (e) {
      $("#main_image_url").attr("src", e.target.result).css("display", "block");
    };
    reader.readAsDataURL(file);
  }
});



  $(document).on("click", ".BtnDelete", function () {
    mode = "delete";
    var index = $(this).attr("id");
    prod_id = res_DATA[index].prod_id;
    console.log(prod_id);

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
          url: base_Url + "admin/featured-products/delete-data",
          data: { prod_id: prod_id },
          dataType: "json",

          success: function (resData) {
            if (resData.code == 200) {
              Swal.fire({
                title: "Congratulations!",
                text: resData["message"],
                icon: "success",
              });

              $("#product-modal").modal("hide");
              getFeaturedProductDetails();
            } else {
              Swal.fire({
                title: "Failure",
                text: resData["message"],
                icon: "error",
              });

              $("#product-modal").modal("hide");
              getFeaturedProductDetails();
            }
          },
          error: function (xhr, status, error) {
            Swal.fire({
              title: "Error!",
              text: "Something went wrong. Please try again later.",
              icon: "error",
            });

            console.error("AJAX Error:", status, error);
            $("#product-modal").modal("hide");
          },
        });
      }
    });
  });

});
