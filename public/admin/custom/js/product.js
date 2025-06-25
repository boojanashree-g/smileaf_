// *************************** [  Offer Price calculation] *****************************************************

$(document).on("change", ".offer_type", function () {
  const $row = $(this).closest(".row");
  const offerType = $(this).val();
  const mrp = parseFloat($row.find(".mrp").val()) || 0;
  const $offerDetails = $row.find(".offer_details");
  const $offerPrice = $row.find(".offer_price");

  $offerPrice.val("");

  if (offerType === "0" || offerType === "1") {
    $offerDetails.val("").attr("readonly", true).addClass("readonly-style");
    $offerPrice.val(mrp);
  } else {
    $offerDetails.val("").attr("readonly", false).removeClass("readonly-style");
  }
});

$(document).on("change", ".offer_details", function () {
  const $row = $(this).closest(".row");
  const offerDetail = parseFloat($(this).val()) || 0;
  const mrp = parseFloat($row.find(".mrp").val()) || 0;

  if (offerDetail >= 0 && mrp > 0) {
    const discounted = (mrp - (mrp * offerDetail) / 100).toFixed(2);
    $row.find(".offer_price").val(discounted);
  }
});
