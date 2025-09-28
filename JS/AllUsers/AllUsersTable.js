$(document).ready(function () {
  $(document).on("click", ".delete-account", deletAccount);
  $(document).on("click", ".edit-account", editAccount);
});

async function deletAccount() {
  const accountId = $(this).data("account-id");
  const row = $(this).closest("tr");

  await Swal.fire({
    title: "Подтвержидение",
    text: "Вы уверены что хотите удалить аккаунт?",
    icon: "question",
    showDenyButton: true,
    confirmButtonText: "Да, хочу удалить",
    denyButtonText: "Нет, ненадо",
  }).then((result) => {
    if (result.isDenied) {
      Swal.fire({
        title: "Отмена",
        text: "Аккаунт не был удалён",
      });
      throw "Аккаунт не был удалён";
    }
  });

  $.ajax({
    url: "ajax/delete_user",
    type: "POST",
    contentType: "application/json",
    data: JSON.stringify({ id: accountId }),
    success: function (response) {
      if (response.success) {
        Swal.fire({
          title: "Успех!",
          text: "Пользователь успешно удалён",
          icon: "success",
        });
        if (accountId == sessionStorage.getItem("loginedID")) {
          sessionStorage.removeItem("loginedID");
        }
        row.fadeOut(300, function () {
          $(this).remove();
        });
      } else {
        Swal.fire({
          title: "Ошибка!",
          text: "Произошла ошибка при удалении: " + response.error,
          icon: "error",
        });
      }
    },
    error: function (response, xhr, status, error) {
      var errText =
        "Произошла критическая ошибка при удалении! Повторите попытку отправить позже.";
      if (
        response.responseJSON != null &&
        response.responseJSON != undefined &&
        response.responseJSON.error != undefined &&
        response.responseJSON.error != null
      )
        errText = response.responseJSON.error;
      Swal.fire({
        title: "Критическая ошибка!",
        text: errText,
        icon: "error",
      });
    },
  });
}

function editAccount() {
  const accountId = $(this).data("account-id");
  const accountName = $(this).data("account-name");
  const accountSurname = $(this).data("account-surname");
  const accountEmail = $(this).data("account-email");
  const accountMessage = $(this).data("account-message");

  const Form = $("#FormRegistration");

  Form.trigger("reset");
  if (
    Form.css("visibility") == "hidden" ||
    (Form.css("visibility") == "visible" && accountEmail != $("#InputEmail")) ||
    (Form.css("visibility") == "visible" &&
      $("#editAccountTitle").text() == "Создание нового аккаунта")
  ) {
    Form.css("visibility", "visible");
    Form.css("display", "block");
    $("#editAccountTitle").text("Редактирование аккаунта");
    $("#Send").text("Сохранить изменения");

    $("#InputID").val(accountId);
    $("#InputName").val(accountName);
    $("#InputSurname").val(accountSurname);
    $("#InputEmail").val(accountEmail);
    $("#InputMessageRegistration").text(accountMessage);
  } else {
    Form.css("visibility", "hidden");
    Form.css("display", "none");
  }
}
