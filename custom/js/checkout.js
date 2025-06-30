$(document).ready(function () {
  let currentStage = "send";
  let otpSentAt = null;
  let resendEnabled = false;

  // *************************** [1. Check Login ] *************************************************************************

  $("#continue-login").click(function () {
    const number = $("#number").val().trim();
    const otp = $("#otpInput").val().trim();

    if (currentStage === "send") {
      if (number === "") {
        showToast("Please Enter Number", "error");
      } else if (!isPhoneNumber(number)) {
        showToast("Please enter valid mobile number.", "error");
      } else {
        sendOTP(number);
      }
    } else if (currentStage === "verify") {
      if (otp === "") {
        showToast("Please Enter OTP", "error");
      } else if (!/^\d{4}$/.test(otp)) {
        showToast("OTP must be a 4-digit number", "error");
      } else {
        verifyOTP(otp);
      }
    }
  });

  function isPhoneNumber(phone_no) {
    var pattern = /^\d{10}$/;
    return pattern.test(phone_no);
  }

  function sendOTP(number) {
    $.ajax({
      type: "POST",
      url: base_Url + "signin-otp",
      data: { number: number },

      dataType: "json",
      success: function (JSONdata) {
        if (JSONdata.code == 400) {
          showToast(JSONdata.message, "error");
        } else if (JSONdata.code == 200) {
          currentStage = "verify";
          otpSentAt = Date.now();
          $(".otp-text").removeClass("d-none");
          $(".otp-field").removeClass("d-none");
          startOtpExpiryTimer();
        } else if (JSONdata.checkoutcode == 403) {
          $(".otp-text").addClass("d-none");
          $(".otp-text").removeClass("d-none");
        }
      },
      error: function (xhr, status, error) {
        console.error("AJAX error:", error);
        showToast("Something went wrong. Please try again.", "error");
      },
    });
  }

  function startOtpExpiryTimer() {
    setTimeout(() => {
      $(".otp-text").text("OTP expired. Please resend.");
      resendEnabled = true;
      $(".otp-resend").removeClass("d-none");
    }, 60000); // 1 minute
  }

  $(".resend-btn").click(function () {
    if (!resendEnabled) {
      showToast("Please wait before resending OTP", "error");
      return;
    }

    $.ajax({
      type: "POST",
      url: base_Url + "resend-otp",
      dataType: "json",
      success: function (datas) {
        if (datas.code == 200) {
          currentStage = "verify";
          otpSentAt = Date.now();
          $(".otp-field").removeClass("d-none");
          $(".otp-resend").addClass("d-none");
          $(".otp-text").text("The OTP is valid for 1 minute only.");

          startOtpExpiryTimer();
        }
        if (datas.code == 400) {
          showToast(datas.message, "error");
        }
      },
    });
  });

  function verifyOTP(otp) {
    $.ajax({
      type: "POST",
      url: base_Url + "verify-otp",
      data: { otp: otp },
      dataType: "JSON",
      success: function (JSONdata) {
        localStorage.setItem("token", JSONdata.token);
        if (JSONdata.code == 400) {
          showToast(JSONdata.message, "error");
          if (JSONdata.checkoutcode == 403) {
            $(".otp-text").text("OTP expired. Please resend.");
            $(".otp-resend").removeClass("d-none");
            $(".otp-text").removeClass("d-none");
          }
        } else if (JSONdata.code == 200) {
          location.reload();
        }
      },
      error: function (xhr, status, error) {
        console.error("AJAX error:", error);
        showToast("Something went wrong. Please try again.", "error");
      },
    });
  }

  // *************************** [2. User Details] *************************************************************************
  $("#continue-userdetail").click(function () {
    const username = $("#username").val().trim();
    const email = $("#email").val().trim();

    if (username === "") {
      showToast("Please Enter Username", "error");
    } else if (email === "") {
      showToast("Please Enter Email", "error");
    } else if (!isValidEmail(email)) {
      showToast("Please Enter valid mail", "error");
    } else {
      saveDetails(username, email);
    }
  });

  function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
  }

  var token = localStorage.getItem("token");

  function saveDetails(username, email) {
    $.ajax({
      type: "POST",
      url: base_Url + "save-userdetails",
      data: { username: username, email: email },
      dataType: "JSON",
      headers: { Authorization: "Bearer " + token },
      success: function (JSONdata) {
        if (JSONdata.code == 400) {
          showToast(JSONdata.message, "error");
        } else if (JSONdata.code == 200) {
          showToast(JSONdata.message, "success");
          $("#loginSection").addClass("inactive-section");
          const $deliverySection = $("#deliverySection");
          $deliverySection.removeClass("inactive-section");
          $deliverySection
            .find(".step-header")
            .removeClass("inactive-header")
            .css("color", "white");
          $deliverySection.find(".inactive-content").hide();

          // Show address form
          toggleAddressForm();
        }
      },
      error: function (error) {
        let status = error.status;
        if (status === 401) {
          localStorage.removeItem("token");
          window.location.href = base_Url;
        } else {
          showToast(error, "error");
        }
      },
    });
  }

  function toggleAddressForm() {
    $("#addressForm").addClass("active");
  }
});
