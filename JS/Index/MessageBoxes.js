document.addEventListener("DOMContentLoaded", function () {
  const textarea1 = $("#InputMessageRegistration");
  const textarea2 = $("#InputMessageOrder");
  const textarea3 = $("#InputMessageCreateReview");
  textarea1.css("height", "100px");
  textarea2.css("height", "100px");
  textarea3.css("height", "100px");

  if (
    sessionStorage.getItem("loginedID") != null &&
    sessionStorage.getItem("loginedID") != undefined &&
    sessionStorage.getItem("loginedID") != "undefined"
  ) {
    $.ajax({
      url: "ajax/get_user_by_id",
      type: "GET",
      contentType: "application/json",
      data: { id: sessionStorage.getItem("loginedID") },
      success: function (response) {
        if (response.success) {
          if (response.name != null) $("#InputName3").val(response.name);
        } else {
          console.error(
            "Произошла ошибка при загрузке пользователя: " + response.error
          );
        }
      },
      error: function (response, xhr, status, error) {
        if (
          response.responseJSON != null &&
          response.responseJSON != undefined &&
          response.responseJSON.error != undefined &&
          response.responseJSON.error != null
        ) {
          console.error(
            "Произошла ошибка при загрузке пользователя: " +
              response.responseJSON.error
          );
        }
      },
    });
  }
});

$("#InputMessageRegistration").on("input", function () {
  $("#InputMessageRegistration").css("height", "auto");
  $("#InputMessageRegistration").css(
    "height",
    Math.max(this.scrollHeight, 100) + "px"
  );
});

$("#InputMessageOrder").on("input", function () {
  $("#InputMessageRegistration").css("height", "auto");
  $("#InputMessageRegistration").css(
    "height",
    Math.max(this.scrollHeight, 100) + "px"
  );
});

$("#InputMessageCreateReview").on("input", function () {
  $("#InputMessageRegistration").css("height", "auto");
  $("#InputMessageRegistration").css(
    "height",
    Math.max(this.scrollHeight, 100) + "px"
  );
});
