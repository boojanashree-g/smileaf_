$(".addto_cartbtn").click(function () {
  insertCartData();
});

function insertCartData() {
  let selected = $('input[name="pack_qty"]:checked');
  let pack_qty = selected.val();
  let prod_id = selected.data("prodid");
  let quantity = $(".selected-qty").val();

  $.ajax({
    type: "POST",
    url: base_Url + "insert-cart",
    data: { pack_qty: pack_qty, prod_id: prod_id, quantity: quantity },
    dataType: "json",
    success: function (result) {
      if (result.code == 200) {
        showToast(result.message, "success");
        $(".addto_cart_text").html("Goto cart");
        $("#quick_buy_modal").modal("hide");
      } else {
        showToast(result.message, "error");
        $("#quick_buy_modal").modal("hide");
      }
    },
  });
}
