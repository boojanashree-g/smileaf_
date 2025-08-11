var mode;
var add_id = null;
$(document).ready(function () {
  let currentStage = "send";
  let otpSentAt = null;
  let resendEnabled = false;
  var token = null;

  var deleteAddr = "";

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

  if (localStorage.getItem("goToStep3") === "yes") {
    localStorage.removeItem("goToStep3");

    // Trigger your Step 3 transition
    $("#loginSection").addClass("inactive-section");

    const $deliverySection = $("#deliverySection");
    $deliverySection.removeClass("inactive-section");
    $deliverySection
      .find(".step-header")
      .removeClass("inactive-header")
      .css("color", "white");
    $deliverySection.find(".inactive-content").hide();

    toggleAddressForm();
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
      $("#otpInput").val("");
    }, 60000); // 1 minute
  }

  $(".resend-btn").click(function () {
    if (!resendEnabled) {
      showToast("Please wait before resending OTP", "error");
      $("#otpInput").val("");

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
  $("input[name='whatsapp_verify']").change(function () {
    $("#whatsapp_number").addClass("d-none");
    const verifynum = $(this).val();
    if (verifynum == "no") {
      $("#whatsapp_number").removeClass("d-none");
    }
  });
  $("#continue-userdetail").click(function () {
    const username = $("#username").val().trim();
    const email = $("#email").val().trim();
    const isverify = $("input[name='whatsapp_verify']:checked").val();
    const whatsappNumber = $("#whatsapp_number").val();

    if (username === "") {
      showToast("Please Enter Username", "error");
    } else if (email === "") {
      showToast("Please Enter Email", "error");
    } else if (!isValidEmail(email)) {
      showToast("Please Enter valid mail", "error");
    } else if (!isverify) {
      showToast("Please select an option", "error");
    } else if (isverify == "no" && whatsappNumber == "") {
      showToast("Please Enter whatsapp number", "error");
    } else if (isverify == "no" && !isPhoneNumber(whatsappNumber)) {
      showToast("Please Enter valid number", "error");
    } else {
      saveDetails(username, email, isverify, whatsappNumber);
    }
  });

  function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
  }
  function isPhoneNumber(phone_no) {
    return /^\d{10}$/.test(phone_no);
  }

  var token = localStorage.getItem("token");

  function saveDetails(username, email, isverify, whatsappNumber) {
    $.ajax({
      type: "POST",
      url: base_Url + "save-userdetails",
      data: {
        username: username,
        email: email,
        isverify: isverify,
        whatapp_number: whatsappNumber,
      },
      dataType: "JSON",
      headers: { Authorization: "Bearer " + token },
      success: function (JSONdata) {
        if (JSONdata.code == 400) {
          showToast(JSONdata.message, "error");
        } else if (JSONdata.code == 200) {
          showToast(JSONdata.message, "success");
          $("#place-order")
            .prop("disabled", false)
            .addClass("enable")
            .removeClass("disable");
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
          $(".edit-userdetails").addClass("d-none");
          $(".userdetails-display").css("display", "block").html(`
                <span class="logged_in me-5"><i class="fas fa-check-circle me-2"></i>Username  - ${username} </span>
                <span class="logged_in"><i class="fas fa-check-circle me-2"></i>Email  - ${email} </span>
              `);
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
    $("#addressForm").addClass("active").removeClass("d-none");
  }

  // *************************** [3. Address Details] *************************************************************************
  $("#address-checkout").click(function () {
    let pincode = $("#pincode").val().trim().replace(/\s/g, "");

    if ($("#address").val() === "" && (mode === "new" || mode === "edit")) {
      showToast("Please fill address!", "info");
    } else if (
      $("#state_id").val() === "" &&
      (mode === "new" || mode === "edit")
    ) {
      showToast("Please Select State!", "info");
    } else if (
      $("#dist_id").val() === "" &&
      (mode === "new" || mode === "edit")
    ) {
      showToast("Please Select District!", "info");
    } else if (
      $("#landmark").val() === "" &&
      (mode === "new" || mode === "edit")
    ) {
      showToast("Please Enter Landmark", "info");
    } else if ($("#city").val() === "" && (mode === "new" || mode === "edit")) {
      showToast("Please Enter City", "info");
    } else if (pincode === "" && (mode === "new" || mode === "edit")) {
      showToast("Please Enter Pincode", "info");
    } else if (
      !/^\d{6}$/.test(pincode) &&
      (mode === "new" || mode === "edit")
    ) {
      showToast("Please enter a valid 6-digit pincode", "info");
    } else {
      checkoutAddAddress();
    }
  });

  function checkoutAddAddress() {
    var form = $("#checkoutAddressForm")[0];
    var data = new FormData(form);
    var token = localStorage.getItem("token");
    var isChecked = "";

    var url;
    if (mode == "new") {
      url = base_Url + "insert-address";
      isChecked = $(".form_defaultaddr").prop("checked");
      data.append("default_addr", isChecked);
    } else if (mode == "edit") {
      url = base_Url + "update-address";
      isChecked = $(".form_defaultaddr").prop("checked");
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
        if (resultData.code == 200) {
          localStorage.setItem("goToStep3", "yes");
          location.reload();
        } else if (resultData.code == 400) {
          showToast(resultData.message, "error");
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

  $(".add-address-btn").click(function () {
    $("#personalDetaila").show();
    mode = "new";
  });
  $("#state_id").change(function () {
    let state_id = $(this).val();

    var token = localStorage.getItem("token");
    if (mode == "new") {
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
        },
      });
    } else if (mode == "edit") {
      $.ajax({
        type: "POST",
        url: base_Url + "getdist-data",
        data: { state_id: state_id },
        headers: { Authorization: "Bearer " + token },
        dataType: "json",
        success: function (res) {
          let distDta = "";
          distDta = `<option value='${distID}'>${distName}</option>`;
          for (let i = 0; i < res["response"].length; i++) {
            distDta += `<option value="${res["response"][i]["dist_id"]}">${res["response"][i]["dist_name"]}</option>`;
          }
          $("#dist_id").html(distDta);
        },
      });
    }
  });
  // *************************** [4. Address Delete] *************************************************************************
  token = localStorage.getItem("token");
  $(".address-delete").click(function () {
    deleteAddr = $(this).attr("data-addid");
    $("#address-delete").modal("show");
  });

  $(".btn-delete").click(function () {
    $.ajax({
      type: "POST",
      url: base_Url + "delete-address",
      data: { add_id: deleteAddr },
      headers: { Authorization: "Bearer " + token },
      dataType: "JSON",
      success: function (resultData) {
        if (resultData.code == 200) {
          localStorage.setItem("goToStep3", "yes");
          location.reload();
        } else {
          showToast(resultData.message, "error");
          $("#deleteConfirmModal").modal("hide");
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
});

// *************************** [5.Default Address Change & Edit Address] *************************************************************************

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

        $(".checkout-add").prop("checked", false);
        $(".checkout-add[data-addid='" + addressID + "']").prop(
          "checked",
          true
        );
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

// Edit Address
$("#addressForm").on("click", ".address-edit", function () {
  mode = "edit";

  let addID = $(this).data("addid");
  $("#personalDetaila").show();
  $(".address-title").html("Edit Address");

  token = localStorage.getItem("token");

  $.ajax({
    type: "POST",
    url: base_Url + "get-single-address",
    data: { add_id: addID },
    dataType: "JSON",
    headers: { Authorization: "Bearer " + token },
    success: function (JSONdata) {
      if (JSONdata.code == 400) {
        showToast(JSONdata.message, "error");
      } else if (JSONdata.code == 200) {
        editViewAddress(JSONdata.address);
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

  setTimeout(() => {
    $("html, body").animate(
      {
        scrollTop:
          $("#personalDetaila").offset().top +
          $("#personalDetaila").outerHeight() -
          $(window).height() +
          50,
      },
      500
    );
  }, 100);
});

var stateID = null;
var distID = null;
var distName = null;

function editViewAddress(address) {
  mode = "edit";
  add_id = address.add_id;
  stateID = address.state_id;
  distID = address.dist_id;
  distName = address.dist_name;

  $("#state_id").val(stateID).trigger("change");

  $("#address").val(address.address);
  $("#landmark").val(address.landmark);
  $("#city").val(address.city);
  $("#pincode").val(address.pincode);
  $("#default_addr").prop("checked", address.default_addr == 1);
}

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
  // const username = $("#username").val().trim();
  // const email = $("#email").val().trim();

  // if (username == "" || email == "") {
  //   showToast("Please Fill UserDetails", "error");
  //   return false;
  // }

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
  var subIDs = [];
  $(".sub-id").each(function () {
    subIDs.push($(this).val());
  });

  if (!validateCheckout()) {
    return;
  } else {
    $.ajax({
      type: "POST",
      url: "place-order",
      data: { type: type, subid: subIDs },
      dataType: "JSON",
      headers: { Authorization: "Bearer " + token },
      success: function (resultData) {
        if (resultData.code == 200) {
          window.location.href = base_Url + "payment?type=" + type;
        } else if (resultData.code == 400) {
          showToast(resultData.message, "error");
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
