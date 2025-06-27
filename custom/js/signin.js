$(document).ready(function () {
  var otpInput = "";
  var timerId = null;
  let isOTPModalActive = false;
  let timeLeft = 60;

  $("#login-form").keypress(function (e) {
    if (e.which === 13) {
      e.preventDefault();
      $("#btn-submit").click();
    }
  });

  //Preventing modal close
  $("#signinotp-modal").modal({
    backdrop: "static",
    keyboard: false,
  });

  $("#btn-submit").click(function (e) {
    const $button = $("#verify-otp");
    $button.prop("disabled", false).text("Verify OTP");

    e.preventDefault();
    let isValid = true;
    let errorMessage = "";
    const form = $("#login-form");
    const number = form.find('input[name="number"]');
    $("input").css("border-color", "#ccc");

    if (!$.trim(number.val())) {
      isValid = false;
      number.css("border-color", "red");
      errorMessage = "Please enter your mobile number.";
    } else if (!isPhoneNumber($.trim(number.val()))) {
      isValid = false;
      number.css("border-color", "red");
      errorMessage = "Please enter valid mobile number.";
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

  const sendOTP = () => {
    var form = $("#login-form")[0];
    var formData = new FormData(form);

    $.ajax({
      type: "POST",
      url: base_Url + "signin-otp",
      data: formData,
      processData: false,
      contentType: false,
      cache: false,
      dataType: "json",
      success: function (JSONdata) {
        if (JSONdata.code == 400) {
          showToast(JSONdata.message, "error");
        } else if (JSONdata.code == 200) {
          // Show modal first
          $("#signinotp-modal").modal("show");

          // Bind modal event
          $("#signinotp-modal").on("shown.bs.modal", function () {
            isOTPModalActive = true;

            window.onpopstate = function () {
              if (isOTPModalActive) {
                history.pushState(null, null, location.href); // Prevent back
                Swal.fire({
                  icon: "warning",
                  title: "OTP Pending",
                  text: "Please complete OTP verification before going back.",
                  confirmButtonText: "OK",
                  backdrop: true,
                });
              }
            };

            history.pushState(null, null, location.href);
            const otpInputs = $(".otp-digit");
            otpInputs.val("").prop("disabled", false);
            const timerDisplay = $("#timer");
            const resendButton = $("#resendButton");

            timeLeft = 60;

            function updateTimerDisplay() {
              const minutes = Math.floor(timeLeft / 60);
              const seconds = timeLeft % 60;
              timerDisplay.text(
                `Time remaining: ${minutes}:${seconds
                  .toString()
                  .padStart(2, "0")}`
              );
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

            function startOTPTimer() {
              clearInterval(timerId);
              timeLeft = 60;
              otpInputs.val("").prop("disabled", false);
              resendButton.prop("disabled", true);
              otpInputs.first().focus();
              updateTimerDisplay();
              timerId = setInterval(updateTimer, 1000);
            }

            // Start timer
            startOTPTimer();

            // OTP input: auto move + restrict to 1 digit
            otpInputs.on("input", function (e) {
              const index = otpInputs.index(this);
              let value = this.value.replace(/\D/g, "");
              this.value = value.slice(0, 1); // Keep only first digit
              if (value && index < otpInputs.length - 1) {
                otpInputs.eq(index + 1).focus();
              }
            });

            otpInputs.on("keydown", function (e) {
              const index = otpInputs.index(this);
              if (
                ["e", "E", "+", "-", ".", "ArrowUp", "ArrowDown"].includes(
                  e.key
                ) ||
                (!/^\d$/.test(e.key) &&
                  e.key !== "Backspace" &&
                  e.key !== "Tab")
              ) {
                e.preventDefault();
              }

              if (e.key === "Backspace" && !this.value && index > 0) {
                otpInputs.eq(index - 1).focus();
              }
            });

            // Handle paste across all input fields
            otpInputs.on("paste", function (e) {
              e.preventDefault();
              const pasteData = e.originalEvent.clipboardData
                .getData("text")
                .replace(/\D/g, "")
                .slice(0, otpInputs.length);

              [...pasteData].forEach((char, i) => {
                if (otpInputs[i]) {
                  otpInputs.eq(i).val(char);
                }
              });

              if (otpInputs[pasteData.length - 1]) {
                otpInputs.eq(pasteData.length - 1).focus();
              }
            });
          });
        }
      },
      error: function (xhr, status, error) {},
    });
  };

  // *************************** [Verify OTP] *************************************************************************

  $("#verify-otp").click(function () {
    let otpInput = "";
    $(".otp-digit").each(function () {
      otpInput += $(this).val();
    });

    if (otpInput.length != 4) {
      showToast("Please enter all 4 digits of the OTP", "error");
      return;
    }

    const $button = $(this);
    $button.prop("disabled", true).text("Verifying...");

    clearInterval(timerId);
    verifyOTP(otpInput, $button);
  });

  const verifyOTP = (otp, button) => {
    $.ajax({
      type: "POST",
      url: base_Url + "verify-otp",
      data: { otp: otp },
      cache: false,
      dataType: "json",
      success: function (JSONdata) {
        localStorage.setItem("token", JSONdata.token);

        const redirectURL = JSONdata.c_url === "" ? base_Url : JSONdata.c_url;

        if (JSONdata.code == 400) {
          showToast(JSONdata.message, "error");

          setTimeout(() => {
            $(button)
              .prop("disabled", false)
              .removeClass("disabled")
              .css("pointer-events", "auto")
              .text("Verify OTP");

            $("#resendButton").prop("disabled", false).removeClass("disabled");
          }, 100);

          isOTPModalActive = true;
          window.onpopstate = null;

          // reset timer
          const otpInputs = $(".otp-digit");
          otpInputs.val("").prop("disabled", false);
          const timerDisplay = $("#timer");
          const resendButton = $("#resendButton");

          console.log(timeLeft);

          function updateTimerDisplay() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            timerDisplay.text(
              `Time remaining: ${minutes}:${seconds
                .toString()
                .padStart(2, "0")}`
            );
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

          function startOTPTimer() {
            clearInterval(timerId);
            timeLeft = 60;
            otpInputs.val("").prop("disabled", false);
            resendButton.prop("disabled", true);
            otpInputs.first().focus();
            updateTimerDisplay();
            timerId = setInterval(updateTimer, 1000);
          }

          // Start timer
          startOTPTimer();
        } else if (JSONdata.code == 200) {
          showToast(JSONdata.message, "success");
          $("#signinotp-modal").modal("hide");

          setTimeout(() => {
            window.location.href = redirectURL;
          }, 1000);
        } else if (JSONdata.code == 500) {
          showToast(JSONdata.message, "error");
          $("#signinotp-modal").modal("hide");
          $(button).prop("disabled", false).text("Verify OTP");
        }
      },
      error: function (xhr, status, error) {
        console.error("AJAX error:", error);
        showToast("Something went wrong. Please try again.", "error");
      },
    });
  };

  // *************************** [Resend OTP] *************************************************************************
  $("#resendButton").click(function (e) {
    e.preventDefault();

    $.ajax({
      type: "POST",
      url: base_Url + "resend-otp",
      dataType: "json",
      success: function (datas) {
        if (datas.code == 200) {
          showToast(datas.message, "success");

          // Reset OTP inputs
          const otpInputs = $(".otp-digit");
          otpInputs.val("").prop("disabled", false);
          otpInputs.first().focus();

          // Reset timer
          const timerDisplay = $("#timer");
          timeLeft = 60;

          clearInterval(timerId);
          $("#resendButton").prop("disabled", true);

          function updateTimerDisplay() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            timerDisplay.text(
              `Time remaining: ${minutes}:${seconds
                .toString()
                .padStart(2, "0")}`
            );
          }

          function updateTimer() {
            timeLeft--;
            updateTimerDisplay();
            if (timeLeft <= 0) {
              clearInterval(timerId);
              timerDisplay.text("Code expired");
              $("#resendButton").prop("disabled", false);
              otpInputs.prop("disabled", true);
            }
          }

          updateTimerDisplay(); // Initial time shown
          timerId = setInterval(updateTimer, 1000); // Start countdown
        } else {
          showToast(datas.message, "error");
        }
      },
      error: function () {
        showToast(datas.message, "error");
      },
    });
  });

  // *************************** [Logout page ] *************************************************************************

  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.get("expired") === "1") {
    localStorage.clear();
  }
  // *************************** [Logout page ] *************************************************************************
});
