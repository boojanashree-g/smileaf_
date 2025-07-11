// *************************** [Address Detail ] *************************************************************************
$(document).ready(function () {
  var mode, add_id, res_DATA;

  const hash = window.location.hash;
  if (hash) {
    // Activate the tab based on hash
    $('a[href="' + hash + '"]').tab("show");
  }

  getAddressDetails();

  $("#add-address").click(function () {
    mode = "new";
    $("#addAddressModal").modal("show");
    $(".address-title").html("Add Address");

    $("#state_id").change(function () {
      let state_id = $(this).val();

      let token = localStorage.getItem("token");

      $.ajax({
        type: "POST",
        url: base_Url + "getdist-data",
        data: { state_id: state_id },
        headers: { Authorization: "Bearer " + token },
        dataType: "json",

        success: function (res) {
          var distDta = "";
          for (let i = 0; i < res["response"].length; i++) {
            distDta += `<option value="${res["response"][i]["dist_id"]}">${res["response"][i]["dist_name"]}</option>`;
          }
          $("#dist_id").html(
            `<option value=''> Select District </option>` + distDta
          );
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
      headers: { Authorization: "Bearer " + token },
      success: function (data) {
        res_DATA = data;
        editFunction(res_DATA);
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
  // *************************** [Edit Data] *************************************************************************

  function editFunction(res_DATA) {
    mode = "edit";

    $(".edit-address").click(function () {
      $(".address-title").html("Edit Address");
      var index = $(this).attr("index");

      $("#addAddressModal").modal("show");

      // Set selected district
      var dist = "";
      dist += `<option value="${res_DATA[index]["dist_id"]}">${res_DATA[index]["dist_name"]}</option>`;
      $("#dist_id").html(dist);

      // Set selected state
      $("#state_id").html(
        `<option value="${res_DATA[index]["state_id"]}">${res_DATA[index]["state_title"]}</option>`
      );

      $("#state_id").niceSelect("update");
      $("#dist_id").niceSelect("update");

      $("#landmark").val(res_DATA[index]["landmark"]);
      $("#city").val(res_DATA[index]["city"]);
      $("#address").val(res_DATA[index]["address"]);
      $("#pincode").val(res_DATA[index]["pincode"]);

      let defaultAddr = res_DATA[index]["default_addr"];
      if (defaultAddr == 1) {
        $("#default_addr").prop("checked", true);
      } else {
        $("#default_addr").prop("checked", false);
      }
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
