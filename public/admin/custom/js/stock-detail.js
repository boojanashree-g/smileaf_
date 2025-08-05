$(document).ready(function () {
  var mode, JSON, res_DATA, prod_id;

  $.when(getProductDetails()).done(function () {
    dispProductDetails(JSON);
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

      $("#variant-container")
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

  $("#best_seller").change(function () {
    if (this.checked) {
      $("#best_seller").val(1);
    } else {
      $("#best_seller").val(0);
    }
  });

  $("#btn-submit").click(function () {
    insertData();
  });

  //*************************** [Insert] **************************************************************************

  function insertData() {
    var form = $("#product-form")[0];
    data = new FormData(form);
    let hasVariant = $("#hasVariant").val();

    url = base_Url + "admin/stock/update-data";
    data.append("has_variant", hasVariant);
    data.append("prod_id", prod_id);

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
    $("#ajax-loader").removeClass("d-none");
    let Status = $("#status").val();

    $.ajax({
      type: "POST",
      url: base_Url + "admin/stock/get-data",
      data: { status: Status },
      dataType: "json",
      success: function (data) {
        $("#ajax-loader").addClass("d-none");
        res_DATA = data;
        dispProductDetails(res_DATA);
      },
      error: function () {
        $("#ajax-loader").addClass("d-none");
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
            if (data.main_image !== null) {
              return (
                "<a href='" +
                base_Url +
                data.main_image +
                "' target='_blank'>" +
                "<img src='" +
                base_Url +
                data.main_image +
                "' alt='banner image' width='30' height='30'  style='object-fit:cover; border-radius:4px;' />" +
                "</a>"
              );
            } else {
              return "";
            }
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

  // *************************** [Edit Data] *************************************************************************

  $(document).on("click", ".btnEdit", function () {
    $("#product-modal").modal("show");

    $("#preview").empty();

    mode = "edit";

    if (mode == "edit") {
      $("#btn-submit").html("Update");
      $(".subcat-title").text("Edit Product Quantity");
    }

    var index = $(this).attr("id");
    prod_id = res_DATA[index].prod_id;
    let has_variant = res_DATA[index].has_variant;
    let isVariantChecked = Number(has_variant) === 1;
    $("#hasVariant").prop("checked", isVariantChecked).trigger("change");

    var variantIDs = [];

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
  });

  // If variant exist
  const populateVariants = (variants) => {
    removeVariantBlocks();
    variants.forEach((variant, index) => {
      const variantHtml = `
            <div class="variant-block row g-2" data-index="${variantIndex}">
                <div class="row g-3 mt-2">

                <input type="hidden" name="variants[${variantIndex}][variant_id]" class="form-control pack_qty" value="${
        variant.variant_id
      }" placeholder="Pack Quantity*">

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
