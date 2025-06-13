$(document).ready(function () {
  // Get the current URL path
  var currentPath = window.location.pathname;

  $(".menu-item .menu-link").each(function () {
    var link = $(this).attr("href");

    var hrefPath = new URL(link, window.location.origin).pathname;

    // Compare the current path with the href
    if (hrefPath === currentPath) {
      $(this).closest(".menu-item").addClass("active");
      $(this).closest(".menu-sub").addClass("open");
      $(this)
        .closest(".menu-item")
        .parents(".menu-item")
        .addClass("active open");
    }
  });

  const html_data = $("html");

  const logo = $("#sidenav-img");
  const toggle = $(".menu-toggle-icon");

  const fullLogo = base_Url + "public/admin/img/smileaf_black.png";
  const smallLogo = base_Url + "public/assets/img/favicon.png";

  const updateLogo = () => {
    if (
      html_data.hasClass("layout-menu-collapsed") ||
      html_data.hasClass("layout-menu-collapsed layout-menu-hover")
    ) {
      logo.attr("src", smallLogo).attr("width", 50);
    } else {
      logo.attr("src", fullLogo).attr("width", 160);
    }
  };

  toggle.on("click", function () {
    setTimeout(updateLogo, 50);
  });

  $(document).ready(updateLogo);
});
