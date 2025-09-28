$(document).ready(function () {
  $("#FormRegistration").on("submit", Registration);
  $("#EmailLogin").on("submit", Authorization);
  $("#FormCreateReview").on("submit", CreateReview);

  const EmailLogin = $("#EmailLogin");
  const FormRegistration = $("#FormRegistration");
  const UserData = $("#userData");

  $(document).on("click", "#SelectLogin", function () {
    if (EmailLogin.css("visibility") == "hidden") {
      EmailLogin.css("visibility", "visible");
      EmailLogin.css("display", "block");
      FormRegistration.css("visibility", "hidden");
      FormRegistration.css("display", "none");
    } else {
      EmailLogin.css("visibility", "hidden");
      EmailLogin.css("display", "none");
    }
  });

  $(document).on("click", "#SelectRegistration", function () {
    if (FormRegistration.css("visibility") == "hidden") {
      FormRegistration.css("visibility", "visible");
      FormRegistration.css("display", "block");
      EmailLogin.css("visibility", "hidden");
      EmailLogin.css("display", "none");
    } else {
      FormRegistration.css("visibility", "hidden");
      FormRegistration.css("display", "none");
    }
  });

  $(document).on("click", "#AddReview", function () {
    const Form = $("#FormCreateReview");
    if (Form.css("visibility") == "hidden") {
      Form.css("visibility", "visible");
      Form.css("display", "block");
    } else {
      Form.css("visibility", "hidden");
      Form.css("display", "none");
    }
  });

  $(document).on("click", "#EditUser", function () {
    const EditTitle = $("#editAccountTitle");
    if (FormRegistration.css("visibility") == "hidden") {
      EditTitle.text("Редактирование профиля");
      FormRegistration.css("visibility", "visible");
      FormRegistration.css("display", "block");

      UserData.css("visibility", "hidden");
      UserData.css("display", "none");
    } else {
      EditTitle.text("");
      FormRegistration.css("visibility", "hidden");
      FormRegistration.css("display", "none");

      UserData.css("visibility", "visible");
      UserData.css("display", "block");
    }
  });
});
