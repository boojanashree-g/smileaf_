$(document).ready(function () {
  var mode, JSON, res_DATA, cat_id;

  $.when(getProductDetails()).done(function () {
    dispProductDetails(JSON);
  });

  // *************************** [  Filter  Submenu] **************************************************************

  $("#menu_id").change(function () {
    let menu_id = $(this).val();
    if (mode == "new") {
      $.ajax({
        type: "POST",
        url: base_Url + "admin/product-details/submenu",
        data: { menu_id: menu_id },
        dataType: "json",
        success: function (res) {
          console.log(res);

          var subMenu = "";

          for (let i = 0; i < res.length; i++) {
            subMenu += `
            <option value="${res[i]["sub_id"]}">${res[i]["submenu"]}</option>`;
          }
          $("#sub_id").html(subMenu);
        },
      });
    } else if (mode == "edit") {
      $.ajax({
        type: "POST",
        url: base_Url + "admin/product-details/submenu",
        data: { menu_id: menu_id },
        success: function (data) {
          var res = $.parseJSON(data);

          var subMenu = "";

          subMenu += `<option value="${hsubMenuID}">${hsubMenu}</option>`;
          for (let i = 0; i < res.length; i++) {
            subMenu += `<option value="${res[i]["h_submenu_id"]}">${res[i]["h_submenu"]}</option>`;
          }

          $("#h_submenu_id").html(subMenu);
        },
      });
    }
  });

  // *************************** [ Functions] ********************************************************************

  $("#add-detail").click(function () {
    mode = "new";
    $("#product-form")[0].reset();
    $("#product-modal").val("");
    $("#product-modal").modal("show");
    
    if (mode == "new") {
      $("#btn-submit").html("Submit");
      $(".subcat-title").text("Add Product Details");
    }
    $("#variant-container").hide();
    $("#defaultSection").show();
  });

  $("#hasVariant").change(function () {
    if (this.checked) {
      $("#variant-container").show();
      $("#hasVariant").val(1);
      $("#defaultSection").hide();

      // Clear all fields inside defaultSection
      $("#defaultSection")
        .find("input, select")
        .val("")
        .prop("checked", false)
        .prop("selected", false);
    } else {
      $("#variant-container").hide();
      $("#defaultSection").show();
      $("#hasVariant").val(0);

      removeAllVariantBlocks();
    }
  });

  // Disable closing on backdrop click
  $("#product-modal").modal({
    backdrop: "static",
    keyboard: false,
  });

  // *************************** [Validation] ********************************************************************

  $("#btn-submit").click(function () {
    $(".error").hide();
    if ($("#menu_id").val() === "") {
      $(".menu_id").html("Please Select Menu*").show();
    }
    //  else if ($("#type_id").val() === "" && mode == "new") {
    //   $(".type_id").html("Please Select Type*").show();
    // } else if ($("#shape_id").val() === "" && mode == "new") {
    //   $(".shape_id").html("Please Select Shape*").show();
    // } else if ($("#size_id").val() === "" && mode == "new") {
    //   $(".size_id").html("Please Select Size*").show();
    // } else if ($("#prod_name").val() === "" && mode == "new") {
    //   $(".prod_name").html("Please Enter Productname*").show();
    // } else if ($("#main_image").val() === "" && mode == "new") {
    //   $(".main_image").html("Please Select Image*").show();
    // } else if (description.getData() === "" && mode == "new") {
    //   $(".description").html("Please Enter Description*").show();
    // }
    // else if (produsage.getData() === "" && mode == "new") {
    //   $(".product_usage").html("Please Enter ProductUsage*").show();
    // }
    else {
      insertData();
    }
  });

  //*************************** [Insert] **************************************************************************

  function insertData() {
    var form = $("#product-form")[0];
    data = new FormData(form);
    let proddesc = description.getData();
    let usage = produsage.getData();
    let hasVariant = $("#hasVariant").val();

    selectedFiles.forEach((file, i) => {
      data.append("images[]", file);
    });

    var url;
    if (mode == "new") {
      url = base_Url + "admin/product-details/insert-data";
      data.append("description", proddesc);
      data.append("product_usage", usage);
      data.append("has_variant", hasVariant);
    } else if (mode == "edit") {
      url = base_Url + "admin/product-details/update-data";
      data.append("cat_id", cat_id);
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

          $("#product-modal").modal("hide");
          getProductDetails();
        } else {
          Swal.fire({
            title: "Failure",
            text: resultData["msg"],
            icon: "danger",
          });
          $("#product-modal").modal("hide");
          getProductDetails();
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
  function getProductDetails() {
    $.ajax({
      type: "POST",
      url: base_Url + "admin/sub-category/get-data",
      dataType: "json",
      success: function (data) {
        res_DATA = data;
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
          mDataProp: null,
          render: function (data, type, row, meta) {
            return i++;
          },
        },
        {
          mDataProp: "menu_name",
        },
        {
          mDataProp: "submenu",
        },
        {
          mDataProp: "cat_name",
        },
        {
          mDataProp: "status",
          render: (data, type, row, meta) => {
            const isActive = data == 1;
            return `
      <a 
        id="${row.cat_id}" 
        class="badge bg-label-${isActive ? "success" : "danger"} btnStatus"  
        data-id="${row.cat_id}" 
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
    $(".status-title").html("Submenu Status");

    let statuss = $(this).data("status");
    $("#update-status").val(statuss);

    statusId = $(this).attr("id");
  });

  $("#submit-status").click(function () {
    if ($("#update-status").val()) {
      $(".update-status").html("Please Select Status*").show();
    } else {
      $.ajax({
        type: "POST",
        url: base_Url + "admin/sub-category/update-status",
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
          getProductDetails();
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

  // *************************** [Display the image on Modal ] ****************************************************

  $("#main_image").on("change", function () {
    dispImg(this, "main_image_url");
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

  // *************************** [Edit Data] *************************************************************************

  $(document).on("click", ".btnEdit", function () {
    $("#product-modal").modal("show");
    mode = "edit";

    if (mode == "edit") {
      $("#btn-submit").html("Update");
      $(".subcat-title").text("Edit SubCategory Details");
    }

    var index = $(this).attr("id");
    $("#cat_name").val(res_DATA[index].cat_name);
    $("#submenu_id").val(res_DATA[index].submenu_id);

    cat_id = res_DATA[index].cat_id;
  });

  // *************************** [Delete Data] *************************************************************************
  $(document).on("click", ".BtnDelete", function () {
    mode = "delete";
    var index = $(this).attr("id");
    cat_id = res_DATA[index].cat_id;

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
          url: base_Url + "admin/sub-category/delete-data",
          data: { cat_id: cat_id },

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
              getProductDetails();
            } else {
              Swal.fire({
                title: "Failure",
                text: resData["message"],
                icon: "error",
              });

              $("#model-data").modal("hide");
              getProductDetails();
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
