$(document).ready(function () {
  var mode, JSON, res_DATA, prod_id;

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
        dataType: "json",
        success: function (res) {
          var subMenu = "";
          subMenu += `<option value="${subMenuID}">${subMenuu}</option>`;
          for (let i = 0; i < res.length; i++) {
            subMenu += `<option value="${res[i]["sub_id"]}">${res[i]["submenu"]}</option>`;
          }

          $("#sub_id").html(subMenu);
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
    $("#main_image_url").css("display", "none");
    $("#images").val("");
    $("#preview").empty();

    $("#menu_id").val("");
    $("#sub_id").val("");

    if (produsage) {
      produsage.setData("");
    }

    if (description) {
      description.setData("");
    }

    selectedFiles = [];

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

    var mainImageInput = $("#main_image")[0];
    var file = mainImageInput.files[0];
    var maxSize = 500 * 1024; // 500 KB

    if ($("#menu_id").val() === "") {
      $(".menu_id").html("Please Select Menu*").show();
      return;
    }

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

    if (description.getData() === "" && mode == "new") {
      $(".description").html("Please Enter Description*").show();
      return;
    }

    if (produsage.getData() === "" && mode == "new") {
      $(".product_usage").html("Please Enter ProductUsage*").show();
      return;
    }

    console.log("Calling insertData()");
    insertData();
  });

  //*************************** [Insert] **************************************************************************

  function insertData() {
    mode == "new";
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
      data.append("description", proddesc);
      data.append("product_usage", usage);
      data.append("has_variant", hasVariant);

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
      url: base_Url + "admin/product-details/get-data",
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
          mDataProp: "menu",
        },
        {
          mDataProp: "submenu",
        },
        {
          mDataProp: "prod_name",
        },
        {
          mDataProp: function (data, type, full, meta) {
            if (data.main_image !== null)
              return (
                "<a href='" +
                base_Url +
                data.main_image +
                "' target='_blank'><img src='" +
                base_Url +
                data.main_image +
                "' alt='banner image' width='30'></a>"
              );
            else return "";
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

  var MenuID;
  var Menu;
  var subMenuID;
  var subMenuu;

  $(document).on("click", ".btnEdit", function () {
    $("#product-modal").modal("show");
    $("#main_image_url").css("display", "none");
    $("#images").val("");
    $("#preview").empty();
    if (description) {
      description.setData("");
    }

    if (produsage) {
      produsage.setData("");
    }

    selectedFiles = [];
    existingImages = [];
    mode = "edit";

    if (mode == "edit") {
      $("#btn-submit").html("Update");
      $(".subcat-title").text("Edit Product Details");
    }

    var index = $(this).attr("id");

    MenuID = res_DATA[index].menu_id;
    subMenuID = res_DATA[index].submenu_id;
    subMenuu = res_DATA[index].submenu;
    $("#menu_id").val(MenuID).trigger("change");

    $("#type_id").val(res_DATA[index].type_id);
    $("#shape_id").val(res_DATA[index].shape_id);
    $("#size_id").val(res_DATA[index].size_id);

    $("#prod_name").val(res_DATA[index].prod_name);
    $("#prod_name").val(res_DATA[index].prod_name);
    description.setData(res_DATA[index].description);
    produsage.setData(res_DATA[index].product_usage);

    $("#main_image_url").attr("src", base_Url + res_DATA[index].main_image);
    $("#main_image_url").addClass("active");
    $("#main_image_url").css("display", "block");

    let has_variant = res_DATA[index].has_variant;
    let isVariantChecked = Number(has_variant) === 1;
    $("#hasVariant").prop("checked", isVariantChecked).trigger("change");

    if (isVariantChecked) {
      let variants = res_DATA[index].variants;
      populateVariants(variants);
    } else {
      let variant = res_DATA[index].variants[0];
      let offerDetails = variant.offer_details;
      $("input[name='pack_qty']").val(variant.pack_qty);
      $("input[name='quantity']").val(variant.quantity);
      $("input[name='mrp']").val(variant.mrp);
      $("select[name='offer_type']").val(variant.offer_type);
      $("input[name='offer_details']").val(variant.offer_details);
      $("input[name='offer_price']").val(variant.offer_price);
      $("select[name='stock_status']").val(variant.stock_status);
      $("input[name='weight']").val(variant.weight);

      if (offerDetails === "0" || offerDetails === "1") {
        $(".offer_details")
          .val("")
          .attr("readonly", true)
          .addClass("readonly-style");
      } else {
        $(".offer_details")
          .val("")
          .attr("readonly", false)
          .removeClass("readonly-style");
      }
    }

    // Multi Images
    let images = res_DATA[index].product_images;
    existingImages = images;

    images.forEach((imgPath) => {
      const fileName = imgPath.split("/").pop();
      const $container = $("<div>").addClass("preview-box");
      const $img = $("<img>")
        .attr("src", base_Url + imgPath)
        .css("width", "100px");
      const $caption = $("<p>").text(fileName);
      const $removeBtn = $("<button>").addClass("remove-btn").text("Remove");

      // Create hidden input for existing image
      const $hiddenInput = $("<input>")
        .attr("type", "hidden")
        .attr("name", "existing_images[]")
        .val(imgPath);

      $removeBtn.on("click", function () {
        $container.remove();
        existingImages = existingImages.filter((path) => path !== imgPath);
        $hiddenInput.remove();
      });

      $container.append($img, $caption, $removeBtn, $hiddenInput);
      $("#preview").append($container);
    });

    prod_id = res_DATA[index].prod_id;
  });

  // If variant exist
  const populateVariants = (variants) => {
    removeVariantBlocks();
    variants.forEach((variant, index) => {
      const variantHtml = `
            <div class="variant-block row g-2" data-index="${variantIndex}">
                <div class="row g-3 mt-2">
                    <div class="col-md-3"><input type="text" name="variants[${variantIndex}][pack_qty]" class="form-control pack_qty" value="${
        variant.pack_qty
      }" placeholder="Pack Quantity*"></div>
                    <div class="col-md-3"><input type="text" name="variants[${variantIndex}][quantity]" class="form-control quantity" value="${
        variant.quantity
      }" placeholder="Quantity*"></div>
                    <div class="col-md-3"><input type="text" name="variants[${variantIndex}][mrp]" class="form-control mrp" value="${
        variant.mrp
      }" placeholder="MRP*"></div>
                    <div class="col-md-3">
                        <select name="variants[${variantIndex}][offer_type]" class="form-select offer_type">
                            <option value="">Select Offer Type</option>
                            <option value="0" ${
                              variant.offer_type == 0 ? "selected" : ""
                            }>None</option>
                            <option value="1" ${
                              variant.offer_type == 1 ? "selected" : ""
                            }>Flat</option>
                            <option value="2" ${
                              variant.offer_type == 2 ? "selected" : ""
                            }>Percentage</option>   
                        </select>
                    </div>
                    <div class="col-md-3"><input type="text" name="variants[${variantIndex}][offer_details]" class="form-control offer_details" value="${
        variant.offer_details
      }" placeholder="Offer Details*"></div>
                    <div class="col-md-3"><input type="text" name="variants[${variantIndex}][offer_price]" class="form-control offer_price" value="${
        variant.offer_price
      }" placeholder="Offer Price*"></div>
                    <div class="col-md-3">
                        <select name="variants[${variantIndex}][stock_status]" class="form-select stock_status">
                            <option value="1" ${
                              variant.stock_status == 1 ? "selected" : ""
                            }>Available</option>
                            <option value="0" ${
                              variant.stock_status == 0 ? "selected" : ""
                            }>Out Of Stock</option> 
                        </select>
                    </div>
                    <div class="col-md-3"><input type="text" class="form-control weight" name="variants[${variantIndex}][weight]" value="${
        variant.weight
      }" placeholder="Weight*"></div>
                </div>

                <div class="text-end mt-2">
                    <button type="button" class="btn btn-label-danger waves-effect remove-variant" data-rid="${variantIndex}">
                        <i class="fa-solid fa-trash-arrow-up"></i> &nbsp;&nbsp; Delete
                    </button>
                </div>
                <hr>
            </div>`;

      $("#variant-list").append(variantHtml);
      const $currentOfferDetails = $(
        `input[name="variants[${variantIndex}][offer_details]"]`
      );

      // Apply readonly and style
      if (variant.offer_details === "0" || variant.offer_details === "1") {
        $currentOfferDetails
          .val("")
          .attr("readonly", true)
          .addClass("readonly-style");
      } else {
        $currentOfferDetails
          .val(variant.offer_details)
          .attr("readonly", false)
          .removeClass("readonly-style");
      }

      variantIndex++;
    });
  };

  // *************************** [Multi file upload Start] *************************************************************************
  let selectedFiles = [];
  let existingImages = [];

  function formatFileSize(bytes) {
    const kb = bytes / 1024;
    return kb < 1024 ? kb.toFixed(2) + " KB" : (kb / 1024).toFixed(2) + " MB";
  }

  $(document).ready(function () {
    $(window).on("keydown", function (e) {
      if (e.key === "Enter" || e.keyCode === 13) {
        // Prevent Enter ONLY if not focused on textarea or button
        const tag = e.target.tagName.toLowerCase();
        if (tag !== "textarea" && tag !== "button") {
          e.preventDefault();
          return false;
        }
      }
    });
    $("#images").on("change", function (e) {
      const files = Array.from(e.target.files);
      const $preview = $("#preview");

      files.forEach((file) => {
        // Check if file already exist
        const exists = selectedFiles.some(
          (f) => f.name === file.name && f.size === file.size
        );
        if (exists) return;

        selectedFiles.push(file);

        const reader = new FileReader();
        reader.onload = function (event) {
          const $container = $("<div>").addClass("preview-box");
          const $img = $("<img>").attr("src", event.target.result);
          const size = formatFileSize(file.size);

          const $caption = $("<p>").text(file.name);
          const $sizeCaption = $("<p>").addClass("img-size").text(`(${size})`);

          const $removeBtn = $("<button>")
            .addClass("remove-btn")
            .text("Remove");

          $removeBtn.on("click", function () {
            $container.remove();
            // Remove from array by matching name + size
            selectedFiles = selectedFiles.filter(
              (f) => !(f.name === file.name && f.size === file.size)
            );
          });

          $container.append($img, $caption, $sizeCaption, $removeBtn);
          $preview.append($container);
        };

        reader.readAsDataURL(file);
      });
      $("#images").val("");
    });
  });

  // *************************** [Delete Data] *************************************************************************
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
          url: base_Url + "admin/product-details/delete-data",
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
              getProductDetails();
            } else {
              Swal.fire({
                title: "Failure",
                text: resData["message"],
                icon: "error",
              });

              $("#product-modal").modal("hide");
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
            $("#product-modal").modal("hide");
          },
        });
      }
    });
  });
});
