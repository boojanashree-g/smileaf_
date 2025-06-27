// *************************** [Address Detail ] *************************************************************************
$("#add-address").click(function () {
  mode = "new";
  $("#addAddressModal").modal("show");

  $("#state_id").change(function () {
    let state_id = $(this).val();

    let token = localStorage.getItem("token");

    alert(token);
    

    $.ajax({
      type: "POST",
      url: base_Url + "getdist-data",
      data: { state_id: state_id },
      headers: { authorization: "Bearer " + "test" },
      dataType: "json",

      success: function (res) {
        console.log(res["response"].length);
       
        var distDta = "";
        for ($i = 0; $i < res["response"].length; $i++) {
          distDta += `<option value="${res["response"][$i]["dist_id"]}">${res["response"][$i]["dist_name"]}</option>`;
        }
        $("#dist_id").html(
          `<option value=''> Select District </option>` + distDta
        );
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
