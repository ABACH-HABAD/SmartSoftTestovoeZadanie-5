document.addEventListener("DOMContentLoaded", function () {
  var userID = sessionStorage.getItem("loginedID");

  const YouHaveAccount = $("#YouHaveAccount");
  const EmailLogin = $("#EmailLogin");
  const FormRegistration = $("#FormRegistration");
  const Layout = $("#Layout");
  const UserReview = $("#UserReview");
  const Form = $("#FormCreateReview");
  const ReviewButton = $("#AddReview");
  const YouHaventReview = $("#YouHaventReview");

  if (userID != null && userID != undefined && userID != "undefined") {
    EmailLogin.css("visibility", "hidden");
    EmailLogin.css("display", "none");
    FormRegistration.css("visibility", "hidden");
    FormRegistration.css("display", "none");

    YouHaveAccount.css("visibility", "hidden");
    YouHaveAccount.css("display", "none");

    Layout.css("visibility", "visible");
    Layout.css("display", "block");

    $.ajax({
      url: "ajax/get_review/",
      type: "GET",
      contentType: "application/json",
      data: { id: userID },
      success: function (response) {
        if (response.success) {
          $("#reviewName").text(response.name);
          $("#reviewComment").text(response.comment);
          $("#InputMessageCreateReview").text(response.comment);
          ReviewButton.text("Редактировать отзыв");
          YouHaventReview.css("visibility", "hidden");
          YouHaventReview.css("display", "none");
          Form.css("visibility", "hidden");
          Form.css("display", "none");
        } else {
          UserReview.css("visibility", "hidden");
          UserReview.css("display", "none");
          Form.css("visibility", "hidden");
          Form.css("display", "none");
          if (response.error != "Отзыв не найден")
            console.error(
              "Произошла ошибка при загрузке отзыва: " + response.error
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
          UserReview.css("visibility", "hidden");
          UserReview.css("display", "none");
          Form.css("visibility", "hidden");
          Form.css("display", "none");
          if (response.responseJSON.error != "Отзыв не найден") {
            console.error(
              "Произошла ошибка при загрузке отзыва: " +
                response.responseJSON.error
            );
          }
        }
      },
    });

    $.ajax({
      url: "ajax/get_user_by_id/",
      type: "GET",
      data: {
        id: userID,
      },
      contentType: "application/json",
      success: function (response) {
        if (response.success) {
          $("#InputName").val(response.name);
          $("#InputSurname").val(response.surname);
          $("#InputEmail").val(response.email);
          $("#InputMessageRegistration").text(response.message);

          $("#name").text(response.name);
          $("#surname").text(response.surname);
          $("#email").text(response.email);
          $("#message").text(response.message);

          $("#InputName3").val(response.name);
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
          UserReview.css("visibility", "hidden");
          UserReview.css("display", "none");
          Form.css("visibility", "hidden");
          Form.css("display", "none");
          Layout.css("visibility", "hidden");
          Layout.css("display", "none");

          YouHaveAccount.css("visibility", "visible");
          YouHaveAccount.css("display", "block");

          Swal.fire(
            "Ошибка",
            "Произошла ошибка при загрузке пользователя: " +
              response.responseJSON.error,
            "error"
          );

          console.error(
            "Произошла ошибка при загрузке пользователя: " +
              response.responseJSON.error
          );
        }
      },
    });
  } else {
    EmailLogin.css("visibility", "hidden");
    EmailLogin.css("display", "none");
    FormRegistration.css("visibility", "hidden");
    FormRegistration.css("display", "none");

    Layout.css("visibility", "hidden");
    Layout.css("display", "none");
  }
});
