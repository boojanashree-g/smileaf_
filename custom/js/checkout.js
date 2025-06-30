$(document).ready(function () {
  // *************************** [Check Login ] *************************************************************************

  $("#continue-login").click(function () {
    const number = $("#number").val().trim(); // or use $.trim($("#number").val())

    if (number === "") {
      showToast("Please Enter Number", "error");
    } else if (!isPhoneNumber(number)) {
      showToast("Please enter valid mobile number.", "error");
    } else {
      // valid number
    }
  });

  function isPhoneNumber(phone_no) {
    var pattern = /^\d{10}$/;
    return pattern.test(phone_no);
  }
});
