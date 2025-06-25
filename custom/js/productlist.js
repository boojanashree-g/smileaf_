$(document).ready(function () {
  $(".quick_btn").click(function () {
    var prodId = $(this).data("prodid");
    var menuId = $(this).data("menuid");
    var submenuId = $(this).data("submenuid");
    quickviewModal(prodId, menuId, submenuId);
  });

  $(".quick_btn_list").click(function () {
    var prodId = $(this).data("prodid");
    var menuId = $(this).data("menuid");
    var submenuId = $(this).data("submenuid");

    quickviewModal(prodId, menuId, submenuId);
  });

  const quickviewModal = (prodId, menuId, submenuId) => {
    $.ajax({
      type: "POST",
      url: base_Url + "quick-view-details",
      data: { prod_id: prodId, menu_id: menuId, submenu_id: submenuId },

      success: function (html) {
        $(".quick-modal-view").html(html);
        $("#quick_buy_modal").modal("show");
      },
    });
  };
});
