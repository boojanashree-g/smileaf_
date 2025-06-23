$(document).ready(function () {
  let timeLeft = 60;
  let timerId;
  const otpInputs = $(".otp-input input");
  const timerDisplay = $("#timer");
  const resendButton = $("#resendButton");

  // Form validation and modal control
  $(document).on("click", "#registerButton", function (e) {
    e.preventDefault();

    e.stopPropagation();

    const form = $(".signup_form");
    const username = form.find('input[name="username"]');
    const number = form.find('input[name="number"]');
    const email = form.find('input[name="email"]');
    const password = form.find('input[name="password"]');
    const confirm_password = form.find('input[name="confirm_password"]');

    let isValid = true;
    let errorMessage = "";

    // Reset previous error styling
    $("input").css("border-color", "#ccc");

    // Validate fields
    if (!$.trim(username.val())) {
      isValid = false;
      username.css("border-color", "red");
      errorMessage = "Please enter your username.";
    } else if (!$.trim(number.val())) {
      isValid = false;
      number.css("border-color", "red");
      errorMessage = "Please enter your mobile number.";
    } else if (!isPhoneNumber($.trim(number.val()))) {
      isValid = false;
      number.css("border-color", "red");
      errorMessage = "Please enter valid mobile number.";
    } else if (!$.trim(email.val())) {
      isValid = false;
      email.css("border-color", "red");
      errorMessage = "Please enter your email address.";
    } else if (!isValidEmail($.trim(email.val()))) {
      isValid = false;
      email.css("border-color", "red");
      errorMessage = "Please enter a valid email address.";
    } else if (!$.trim(password.val())) {
      isValid = false;
      password.css("border-color", "red");
      errorMessage = "Please enter a password.";
    } else if (password.val().length < 6) {
      isValid = false;
      password.css("border-color", "red");
      errorMessage = "Password must be at least 6 characters long.";
    } else if (!$.trim(confirm_password.val())) {
      isValid = false;
      confirm_password.css("border-color", "red");
      errorMessage = "Please confirm your password.";
    } else if (password.val() !== confirm_password.val()) {
      isValid = false;
      password.css("border-color", "red");
      confirm_password.css("border-color", "red");
      errorMessage = "Passwords do not match.";
    } else {
      sendOTP();
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
    var pattern = /^\d{10}$/;
    return pattern.test(phone_no);
  }

  // *************************** [sendOTP] *************************************************************************
  $("#otpModal").modal({
    backdrop: "static",
    keyboard: false,
  });

  function sendOTP() {
    var form = $("#register-form")[0];
    var formData = new FormData(form);

    $.ajax({
      type: "POST",
      url: base_Url + "signup-otp",
      data: formData,
      processData: false,
      contentType: false,
      cache: false,
      dataType: "json",
      success: function (JSONdata) {
        localStorage.setItem("token", JSONdata.token);
        console.log(JSONdata);

        if (JSONdata.code == 400) {
          showToast(JSONdata.message, "error");
        } else if (JSONdata.code == 200) {
          // Open OTP modal
          $("#otpModal").modal("show");
          $("#otpModal input").val("");
          startOTPTimer();
        }
      },
      error: function (xhr, status, error) {
        $("#loading").addClass("d-none");
        $("#invalid-data")
          .text("Error inserting data. Please try again.")
          .removeClass("d-none");
      },
    });
  }

  // *************************** [ResendOTP] *************************************************************************
  $("#verify-otp").click(function (event) {
    event.preventDefault();

    let otpInputs = $(".otp-input input");
    let otp = "";
    let isValid = true;

    otpInputs.each(function () {
      if ($(this).val() === "" || $(this).val().length !== 1) {
        isValid = false;
        return false;
      }
      otp += $(this).val();
    });

    if (!isValid) {
      showToast("Please enter all 4 digits", "error");
    } else {
      let btn = $(this);
      btn.prop("disabled", true);
      let originalText = btn.html();
      btn.html('<i class="fa fa-refresh fa-spin fa-fw"></i> Verifying...');

      checkOTP(otp);

      // insertData(otp, function () {
      //   // Re-enable and restore the button after OTP is processed
      //   $btn.prop("disabled", false);
      //   $btn.html(originalText);
      // });
    }
  });

  const checkOTP = (otp) => {
    console.log(otp);
    $.ajax({
      type: "POST",
      url: base_Url + "check-signotp",
      data: { otp: otp },
      cache: false,
      dataType: "json",
      success: function (JSONdata) {
        localStorage.setItem("token", JSONdata.token);

        if (JSONdata.code == 400) {
          showToast(JSONdata.message, "error");
        } else if (JSONdata.code == 200) {
          // Open OTP modal
          $("#otpModal").modal("show");
          startOTPTimer();
        }
      },
      error: function (xhr, status, error) {
        $("#loading").addClass("d-none");
        $("#invalid-data")
          .text("Error inserting data. Please try again.")
          .removeClass("d-none");
      },
    });
  };

  // *************************** [OTP Timer functions] *************************************************************************

  function startOTPTimer() {
    clearInterval(timerId);
    timeLeft = 60;
    otpInputs.val("").prop("disabled", false);
    resendButton.prop("disabled", true);
    otpInputs.first().focus();
    updateTimerDisplay();
    timerId = setInterval(updateTimer, 1000);
  }

  function updateTimer() {
    timeLeft--;
    updateTimerDisplay();

    if (timeLeft <= 0) {
      clearInterval(timerId);
      timerDisplay.text("Code expired");
      resendButton.prop("disabled", false);
      otpInputs.prop("disabled", true);
    }
  }

  function updateTimerDisplay() {
    const minutes = Math.floor(timeLeft / 60);
    const seconds = timeLeft % 60;
    timerDisplay.text(
      `Time remaining: ${minutes}:${seconds.toString().padStart(2, "0")}`
    );
  }

  function resendOTP() {
    showToast("New OTP sent!", "success");
    startOTPTimer();
  }

  // OTP Input handling
  otpInputs.on("input", function () {
    const index = otpInputs.index(this);
    if (this.value.length > 1) {
      this.value = this.value.slice(0, 1);
    }
    if (this.value.length === 1 && index < otpInputs.length - 1) {
      otpInputs.eq(index + 1).focus();
    }
  });

  otpInputs.on("keydown", function (e) {
    const index = otpInputs.index(this);
    if (e.key === "Backspace" && !this.value && index > 0) {
      otpInputs.eq(index - 1).focus();
    }
    if (e.key === "e") {
      e.preventDefault();
    }
  });

  function verifyOTP() {
    const otp = otpInputs
      .map(function () {
        return this.value;
      })
      .get()
      .join("");
    if (otp.length === 4) {
      if (timeLeft > 0) {
        showToast("Verifying OTP...", "info");
        setTimeout(() => {
          showToast("Account created successfully!", "success");
          const modal = bootstrap.Modal.getInstance(
            document.getElementById("otpModal")
          );
          modal.hide();
        }, 1500);
      } else {
        showToast("OTP has expired. Please request a new one.", "error");
      }
    } else {
      showToast("Please enter a 4-digit OTP", "error");
    }
  }

  // *************************** [Toast] *************************************************************************

  function showToast(message, type = "info") {
    $(".custom-toast").remove();

    const bgColor =
      type === "error" ? "#f8d7da" : type === "success" ? "#d1e7dd" : "#cff4fc";
    const textColor =
      type === "error" ? "#721c24" : type === "success" ? "#0f5132" : "#055160";
    const borderColor =
      type === "error" ? "#f1aeb5" : type === "success" ? "#a3cfbb" : "#b8daff";
    const icon = type === "error" ? "❌" : type === "success" ? "✅" : "ℹ️";

    const toast = $(`
                        <div class="custom-toast toast-${type}" style="
                            position: fixed;
                            top: 20px;
                            right: 20px;
                            z-index: 9999;
                            padding: 16px 20px;
                            background: ${bgColor};
                            color: ${textColor};
                            border: 1px solid ${borderColor};
                            border-radius: 8px;
                            font-size: 14px;
                            font-weight: 500;
                            min-width: 300px;
                            max-width: 400px;
                            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
                            transform: translateX(100%);
                            opacity: 0;
                            transition: all 0.3s ease-in-out;
                            cursor: pointer;
                        ">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <span style="font-size: 16px;">${icon}</span>
                                <span style="flex: 1;">${message}</span>
                                <span style="margin-left: 10px; cursor: pointer; font-weight: bold; opacity: 0.7;">&times;</span>
                            </div>
                        </div>
                    `);

    $("body").append(toast);

    setTimeout(() => {
      toast.css({ transform: "translateX(0)", opacity: "1" });
    }, 10);

    const autoRemove = setTimeout(() => removeToast(toast), 5000);

    toast.on("click", function () {
      clearTimeout(autoRemove);
      removeToast(toast);
    });
  }

  function removeToast(toast) {
    toast.css({ transform: "translateX(100%)", opacity: "0" });
    setTimeout(() => toast.remove(), 300);
  }
});
