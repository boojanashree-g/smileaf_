$(document).ready(function () {
  $("#btn-account").click(function (e) {
    e.preventDefault();

    let isValid = true;
    let errorMessage = "";

    const form = $("#account-form");

    const username = form.find('input[name="username"]');
    const number = form.find('input[name="number"]');
    const email = form.find('input[name="email"]');

    $("input").css("border-color", "#ccc");

    if (!$.trim(username.val())) {
      isValid = false;
      username.css("border-color", "red");
      errorMessage = "Please enter your name.";
    } else if (!$.trim(number.val())) {
      isValid = false;
      number.css("border-color", "red");
      errorMessage = "Please enter your mobile number.";
    } else if (!isPhoneNumber($.trim(number.val()))) {
      isValid = false;
      number.css("border-color", "red");
      errorMessage = "Please enter a valid 10-digit mobile number.";
    } else if (!$.trim(email.val())) {
      isValid = false;
      email.css("border-color", "red");
      errorMessage = "Please enter your email.";
    } else if (!isValidEmail($.trim(email.val()))) {
      isValid = false;
      email.css("border-color", "red");
      errorMessage = "Please enter a valid email address.";
    } else {
      insertAccount();
    }

    if (!isValid) {
      showToast(errorMessage, "error");
      return;
    }
  });

  function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
  }

  function isPhoneNumber(phone_no) {
    return /^\d{10}$/.test(phone_no);
  }

  // *************************** [Insert Account ] *************************************************************************

  function insertAccount() {
    var form = $("#account-form")[0];
    data = new FormData(form);

    $.ajax({
      type: "POST",
      url: base_Url + "insert-account",
      data: data,
      dataType: "json",
      processData: false,
      contentType: false,

      success: function (data) {
        var resultData = data;

        console.log(resultData);
        if (resultData.code == 200) {
          showToast(resultData.message, "success");
        } else {
          showToast(resultData.message, "error");
        }
      },
      error: function (xhr, status, error) {
        howToast(error, "error");
      },
    });
  }
});
