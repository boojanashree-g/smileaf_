$(".addto_cartbtn").click(function () {
  let sourceType = $(this).data("source");

  insertCartData(sourceType);
});

function insertCartData(sourceType) {
  let selected = $('input[name="pack_qty"]:checked');
  let pack_qty = selected.val();
  let prod_id = selected.data("prodid");
  let quantity = $(".selected-qty").val();
  let source_type = sourceType;

  $.ajax({
    type: "POST",
    url: base_Url + "insert-cart",
    data: {
      pack_qty: pack_qty,
      prod_id: prod_id,
      quantity: quantity,
      source_type: source_type,
    },
    dataType: "json",
    success: function (result) {
      if (result.code == 200) {
        showToast(result.message, "success");
        window.location.href = base_Url + "/cart";
        $("#quick_buy_modal").modal("hide");
        setTimeout(() => {
          window.location.reload();
        }, 1000);
      } else {
        showToast(result.message, "error");
        $("#quick_buy_modal").modal("hide");
      }
    },
  });
}

$(".buynow_btn").click(function () {
  let sourceType = $(this).data("source");

  insertBuynowData(sourceType);
});

function insertBuynowData(sourceType) {
  let selected = $('input[name="pack_qty"]:checked');
  let pack_qty = selected.val();
  let prod_id = selected.data("prodid");
  let quantity = $(".selected-qty").val();
  let source_type = sourceType;

  $.ajax({
    type: "POST",
    url: base_Url + "insert-buynow",
    data: {
      pack_qty: pack_qty,
      prod_id: prod_id,
      quantity: quantity,
      source_type: source_type,
    },
    dataType: "json",
    success: function (result) {
      if (result.code == 200) {
        window.location.href = base_Url + "checkout?type=" + source_type;
      } else {
        showToast(result.message, "error");
      }
    },
  });
}
