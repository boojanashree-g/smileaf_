// *************************** [Address Detail ] *************************************************************************
$(document).ready(function () {
  var mode, add_id, res_DATA;

  mode = "new";

  const hash = window.location.hash;
  if (hash) {
    // Activate the tab based on hash
    $('a[href="' + hash + '"]').tab("show");
  }

  getAddressDetails();

  $("#add-address").click(function () {
    $("#addAddressModal").modal("show");
    $(".address-title").html("Add Address");

    $("#state_id").change(function () {
      let state_id = $(this).val();
      let token = localStorage.getItem("token");

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
  });

  // *************************** [Save Address ] *************************************************************************

  $("#btn_save").click(function () {
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
      insertData();
    }
  });

  // *************************** [Insert Funtion ] ********************************************************************

  function insertData() {
    var form = $("#addAddressForm")[0];
    var data = new FormData(form);
    let token = localStorage.getItem("token");

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
        if (resultData.code == 200) {
          showToast(resultData.message, "success");
          $("#addAddressModal").modal("hide");
          setTimeout(function () {
            window.location.href = window.location.pathname + "#liton_tab_1_4";
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

  // *************************** [get Data] *************************************************************************
  function getAddressDetails() {
    let token = localStorage.getItem("token");
    $.ajax({
      type: "GET",
      url: base_Url + "get-address",
      dataType: "json",
      success: function (data) {
        res_DATA = data;
        editFunction(res_DATA);
      },
      error: function (error) {
        let status = error.status;
        showToast(error, "error");
      },
    });
  }
  // *************************** [Edit Data] *************************************************************************

  var stateID;
  var distID;
  var distName;
  function editFunction(res_DATA) {
    $(".edit-address").click(function () {
      $(".address-title").html("Edit Address");
      var index = $(this).attr("index");

      $("#addAddressModal").modal("show");
      mode = "edit";

      stateID = res_DATA[index]["state_id"];
      distID = res_DATA[index]["dist_id"];
      distName = res_DATA[index]["dist_name"];

      // Load states and trigger district fetch manually
      let token = localStorage.getItem("token");

      $.ajax({
        type: "POST",
        url: base_Url + "getdist-data",
        data: { state_id: stateID },
        headers: { Authorization: "Bearer " + token },
        dataType: "json",
        success: function (res) {
          let stateDta = "";
          let distDta = "";

          // States
          for (let i = 0; i < res["state"].length; i++) {
            let state = res["state"][i];
            stateDta += `<option value="${state["state_id"]}" ${
              state["state_id"] == stateID ? "selected" : ""
            }>${state["state_title"]}</option>`;
          }
          $("#state_id").html(stateDta);
          $("#state_id").niceSelect("update");

          // Districts
          for (let i = 0; i < res["response"].length; i++) {
            let dist = res["response"][i];
            distDta += `<option value="${dist["dist_id"]}" ${
              dist["dist_id"] == distID ? "selected" : ""
            }>${dist["dist_name"]}</option>`;
          }
          $("#dist_id").html(distDta);
          $("#dist_id").niceSelect("update");
        },
        error: function (error) {
          let status = error.status;
          if (status === 401) {
            localStorage.removeItem("token");
            window.location.href = base_Url;
          }
          console.log(error);
        },
      });

      // Fill other fields
      $("#landmark").val(res_DATA[index]["landmark"]);
      $("#city").val(res_DATA[index]["city"]);
      $("#address").val(res_DATA[index]["address"]);
      $("#pincode").val(res_DATA[index]["pincode"]);
      $("#default_addr").prop("checked", res_DATA[index]["default_addr"] == 1);
      add_id = res_DATA[index]["add_id"];
    });
  }

  // *************************** [Delete Data] *************************************************************************
  $(".address-delete").click(function () {
    mode = "delete";
    let token = localStorage.getItem("token");
    $("#deleteConfirmModal").modal("show");

    var index = $(this).attr("index");
    add_id = res_DATA[index]["add_id"];
    $(".btndelete").click(function () {
      $.ajax({
        type: "POST",
        url: base_Url + "delete-address",
        data: { add_id: add_id },
        headers: { Authorization: "Bearer " + token },
        dataType: "JSON",
        success: function (resultData) {
          if (resultData.code == 200) {
            showToast(resultData.message, "success");
            $("#deleteConfirmModal").modal("hide");
            setTimeout(function () {
              window.location.href =
                window.location.pathname + "#liton_tab_1_4";
              location.reload();
            }, 1000);
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
});
