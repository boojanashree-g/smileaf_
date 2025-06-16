// Multi file upload Start

let selectedFiles = [];

function formatFileSize(bytes) {
  const kb = bytes / 1024;
  return kb < 1024 ? kb.toFixed(2) + " KB" : (kb / 1024).toFixed(2) + " MB";
}

$(document).ready(function () {
  $("#images").on("change", function (e) {
    const files = Array.from(e.target.files);
    const $preview = $("#preview");

    files.forEach((file) => {
      // Check if file already exists (by name and size)
      const exists = selectedFiles.some(
        (f) => f.name === file.name && f.size === file.size
      );
      if (exists) return; // skip duplicate

      selectedFiles.push(file);

      const reader = new FileReader();

      reader.onload = function (event) {
        const $container = $("<div>").addClass("preview-box");
        const $img = $("<img>").attr("src", event.target.result);
        const size = formatFileSize(file.size);

        const $caption = $("<p>").text(file.name);
        const $sizeCaption = $("<p>").addClass("img-size").text(`(${size})`);

        const $removeBtn = $("<button>").addClass("remove-btn").text("Remove");

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

    // Clear the input so same file can be selected again
    $("#images").val("");
  });
});

// Multi file upload End

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
