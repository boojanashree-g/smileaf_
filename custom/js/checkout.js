$(document).ready(function () {
  let currentStage = "send";
  let otpSentAt = null;
  let resendEnabled = false;
  let mode = "new";
  var token = null;

  const targetSection = localStorage.getItem("goToSection");

  if (targetSection === "deliverySection") {
    $("#loginSection").addClass("inactive-section");

    const $deliverySection = $("#deliverySection");
    $deliverySection.removeClass("inactive-section");
    $deliverySection
      .find(".step-header")
      .removeClass("inactive-header")
      .css("color", "white");
    $deliverySection.find(".inactive-content").hide();

    toggleAddressForm();

    localStorage.removeItem("goToSection");
  }

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
        localStorage.setItem("loginStatus", "YES");
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

          $("#addressForm").removeClass("active");

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

  // *************************** [3. Address Details] *************************************************************************
  $("#address-checkout").click(function () {
    let pincode = $("#pincode").val().trim().replace(/\s/g, "");

    if ($("#address").val() === "" && mode == "new") {
      showToast("Please fill address!", "info");
    } else if ($("#state_id").val() === "" && mode == "new") {
      showToast("Please Select State!", "info");
    } else if ($("#dist_id").val() === "") {
      showToast("Please Select District!", "info");
    } else if ($("#landmark").val() === "" && mode == "new") {
      showToast("Please Enter Landmark", "info");
    } else if ($("#city").val() === "" && mode == "new") {
      showToast("Please Enter City", "info");
    } else if (pincode === "" && mode == "new") {
      showToast("Please Enter Pincode", "info");
    } else {
      checkoutAddAddress();
    }
  });

  $("#state_id").change(function () {
    let state_id = $(this).val();
    var token = localStorage.getItem("token");

    // Load fresh districts
    $.ajax({
      type: "POST",
      url: base_Url + "getdist-data",
      data: { state_id: state_id },
      headers: { Authorization: "Bearer " + token },
      dataType: "json",
      success: function (res) {
        let distDta = "<option value=''>Select District</option>";
        for (let i = 0; i < res["response"].length; i++) {
          distDta += `<option value="${res["response"][i]["dist_id"]}">${res["response"][i]["dist_name"]}</option>`;
        }
        $("#dist_id").html(distDta);
        $("#dist_id").niceSelect("update");
      },
    });
  });

  function checkoutAddAddress() {
    var form = $("#checkoutAddressForm")[0];
    var data = new FormData(form);
    var token = localStorage.getItem("token");

    var url;
    if (mode == "new") {
      url = base_Url + "insert-address";
      var isChecked = $("#default_addr").prop("checked");
      data.append("default_addr", isChecked);
    } else if (mode == "edit") {
      url = base_Url + "update-address";
      var isChecked = $("#default_addr").prop("checked");
      data.append("default_addr", isChecked);
      data.append("add_id", add_id);
    }

    $.ajax({
      type: "POST",
      url: url,
      data: data,
      processData: false,
      contentType: false,
      cache: false,
      dataType: "JSON",
      headers: { Authorization: "Bearer " + token },
      success: function (resultData) {
        console.log(resultData.address);
        if (resultData.code == 200) {
          showToast(resultData.message, "success");
          $("#personalDetaila").hide();
          $("#loginSection").addClass("inactive-section");

          const $deliverySection = $("#deliverySection");
          $deliverySection.removeClass("inactive-section");
          $deliverySection
            .find(".step-header")
            .removeClass("inactive-header")
            .css("color", "white");
          $deliverySection.find(".inactive-content").hide();
          $("#checkoutAddressForm").find("input, textarea, select").val("");

          // Scroll to Delivery Address section
          $("html, body").animate(
            {
              scrollTop: $deliverySection.offset().top - 100,
            },
            500
          );

          // Create new address card
          const a = resultData.address;

          const currentChecked = $("input.checkout-add:checked");
          let newdefaultCheck = false;
          if (a.default_addr == 1) {
            if (currentChecked.length > 0) {
              currentChecked.prop("checked", false);
            }
            newdefaultCheck = true;
          }

          // Build HTML string
          let newAddressHTML = `
            <div class="address-card" id="address-${a.id}">
                <div class="address-card-head">
                    <div class="address-header-info">
                    
                       <input type="radio" class="checkout-add text-red" 
                       ${newdefaultCheck ? "checked" : ""} >
                        <div class="address-name-type">
                            <span class="address-name">${a.username}</span>
                            <span class="address-phone">${a.number}</span>
                        </div>
                    </div>
                    <div class="address-edit">
                        <button>Change</button>
                    </div>
                </div>
                <div class="address-text">
                    <p class="mb-2">${a.email}</p>
                    ${a.address} , <br>
                    ${a.landmark} , ${a.city}<br>
                    ${a.state_title} , ${a.dist_name},<br>
                    ${a.pincode}
                </div>
            </div>
          `;

          console.log($("#addressForm .address-card").length);
          if ($("#addressForm .address-card").length > 0) {
            $("#addressForm .address-card").last().after(newAddressHTML);
          } else {
            $("#addressForm").append(newAddressHTML);
          }
        } else {
          showToast(resultData.message, "error");
          $("#addAddressModal").modal("hide");
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
  // *************************** [4. Address Delete] *************************************************************************

  $(".address-delete").click(function () {
    let addid = $(this).attr("data-addid");
  });

  // *************************** [5.Default Address Change] *************************************************************************

  $(".default_address").click(function () {
    let addressID = $(this).data("addid");

    const currentChecked = $("input.checkout-add:checked");
    let newdefaultCheck = false;
    let addresshtml = "";

    token = localStorage.getItem("token");
    $.ajax({
      type: "POST",
      url: base_Url + "update-defaultaddress",
      data: { add_id: addressID },
      dataType: "JSON",
      headers: { Authorization: "Bearer " + token },
      success: function (JSONdata) {
        if (JSONdata.code == 400) {
          showToast(JSONdata.message, "error");
        } else if (JSONdata.code == 200) {
          showToast(JSONdata.message, "success");
          localStorage.setItem("goToSection", "deliverySection");
          setTimeout(() => {
            window.location.reload();
          });
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
  });

  $("#close-address").click(function () {
    $("#personalDetaila").hide();
  });

  // *************************** [6.Place Order] *************************************************************************

  function validateCheckout() {
    const token = localStorage.getItem("token");
    const loginStatus = sessionStorage.getItem("loginStatus");

    //1 - Login
    if (!token && loginStatus != "YES") {
      showToast("Please log in to continue.", "error");
      return false;
    }

    //2 - User Details
    const username = $("#username").val().trim();
    const email = $("#email").val().trim();

    if (username == "" || email == "") {
      showToast("Please Fill UserDetails", "error");
      return false;
    }

    // 3 - Address Details
    const addressElem = $(".default_address:checked");
    const default_address = addressElem.attr("data-addid") ?? "";
    if (!default_address) {
      showToast("Please select a delivery address.", "error");
      return false;
    }
    return true;
  }

  $("#place-order").click(function () {
    const token = localStorage.getItem("token");

    const type = $(".checkout-type").val();

    if (!validateCheckout()) {
      return;
    } else {
      $.ajax({
        type: "POST",
        url: "place-order",
        data: { type: type },
        dataType: "JSON",
        headers: { Authorization: "Bearer " + token },
        success: function (resultData) {
          if (resultData.code == 200) {
            showToast(resultData.message, "success");
            $("#addAddressModal").modal("hide");
            setTimeout(function () {
              window.location.href =
                window.location.pathname + "#liton_tab_1_4";
              location.reload();
            }, 1000);
          } else {
            showToast(resultData.message, "error");
            $("#addAddressModal").modal("hide");
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
  });
});
