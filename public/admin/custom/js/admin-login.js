$(document).ready(function () {
  // ****************************************************************** Validation **************************************************************

  const validation = () => {
    let isValid = true;
    if ($("#username").val().trim() === "") {
      $("#username").css("border", "2px solid #ff4c51");
      $(".name-error")
        .html("Please enter username")
        .css("color", "#ff4c51")
        .show();
      isValid = false;
    } else {
      $("#username").css("border", "");
      $(".name-error").hide();
    }

    // Password validation
    if ($("#password").val().trim() === "") {
      $("#password").css("border", "2px solid #ff4c51");
      $(".password-error")
        .html("Please enter password")
        .css("color", "#ff4c51")
        .show();
      isValid = false;
    } else {
      $("#password").css("border", "");
      $(".password-error").hide();
    }

    if (isValid) {
      checkLogin();
    }
  };

  $("#admin-loginbtn").click(function (e) {
    e.preventDefault();
    validation();
  });

  $("#admin-login-form input").on("keypress", function (e) {
    if (e.which === 13) {
      e.preventDefault();
      validation();
    }
  });

  function checkLogin() {
    var form = $("#admin-login-form")[0];

    var formData = new FormData(form);
    console.log(base_Url);

    $.ajax({
      type: "POST",
      url: base_Url + "admin/check-login",
      data: formData,
      processData: false,
      contentType: false,
      cache: false,
      dataType: "json",
      success: function (JSONdata) {
        if (JSONdata.code == 400) {
          $("#login-alert")
            .removeClass("d-none alert-solid-success")
            .addClass("alert-solid-danger");
          $("#login-alert")
            .html(`<span class="alert-icon rounded" ><i class="ti ti-ban text-danger"></i></span>
          ${JSONdata.message}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>`);
        } else if (JSONdata.code == 200) {
          $("#login-alert")
            .removeClass("d-none alert-solid-danger")
            .addClass("alert-solid-success");
          $("#login-alert")
            .html(`<span class="alert-icon rounded "><i class="ti ti-check"></i></span>
          ${JSONdata.message}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>`);
          $("#loading").hide();
          window.location.href = base_Url + "admin/dashboard";
        }
      },
      error: function (xhr, status, error) {
        $("#loading").addClass("d-none");

        if (xhr.status === 401) {
          $("#invalid-data")
            .text("Unauthorized: Please log in again.")
            .removeClass("d-none");

          window.location.href = base_Url;
        } else {
          $("#invalid-data")
            .text("Error inserting data. Please try again.")
            .removeClass("d-none");
        }
      },
    });
  }
});
