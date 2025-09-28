document.addEventListener("DOMContentLoaded", function () {
  const Form = $("#FormCreateReview");

  Form.css("marginBottom", 0);
  Form.css("visibility", "hidden");
  Form.css("display", "none");
});

$(document).ready(function () {
  $("#FormCreateReview").on("submit", sendForm);
  $(document).on("click", "#AddReview", function () {
    const Form = $("#FormCreateReview");
    const InputName = $("#InputName3");
    Form.trigger("reset");
    $("#InputMessageCreateReview").val("");
    if (
      Form.css("visibility") == "hidden" ||
      (Form.css("visibility") == "visible" &&
        $("#editReviewTitle").text() == "Редактирование отзыва")
    ) {
      Form.css("visibility", "visible");
      Form.css("display", "block");
      $("#editReviewTitle").text("Создание нового отзыва");
      InputName.prop("disabled", false);

      InputName.attr(
        "placeholder",
        "Введите ID пользователя, от имени которого хотите оставить отзыв"
      );
      $("#InputName3_label").text("ID пользователя");
    } else {
      Form.css("visibility", "hidden");
      Form.css("display", "none");
    }
  });
});

function sendForm(event) {
  event.preventDefault();

  var exMessage = "";

  if ($("#editReviewTitle").text() == "Создание нового отзыва") {
    if ($("#InputName3").val().length < 1) {
      exMessage +=
        "Введите ID пользователя, от имени которого хотите оставить отзыв<br>";
    }

    if (
      isNaN(parseFloat($("#InputName3").val())) ||
      !isFinite($("#InputName3").val())
    ) {
      exMessage +=
        "В поле 'Имя' ведите ID пользователя, от имени которого хотите оставить отзыв<br>";
    }
  } else {
    if ($("#InputName3").val().length < 1) {
      exMessage +=
        "Введите имя пользователя, от имени которого хотите оставить отзыв<br>";
    }
  }

  if ($("#InputMessageCreateReview").val().length < 1) {
    exMessage += "Введите сообщение<br>";
  }

  if (exMessage) {
    Swal.fire("Неверные данные", exMessage, "error");
    return;
  }

  var formData = {
    id: $("#InputName3").val(),
    comment: $("#InputMessageCreateReview").val(),
  };

  if ($("#editReviewTitle").text() == "Редактирование отзыва") {
    $.ajax({
      url: "ajax/edit_review",
      type: "POST",
      contentType: "application/json",
      data: JSON.stringify(formData),
      success: function (response) {
        if (response.success) {
          Swal.fire({
            title: "Успех!",
            text: "Отзыв успешно обновлён",
            icon: "success",
          }).then((result) => {
            if (result.isConfirmed) {
              location.reload();
            }
          });
        } else {
          Swal.fire({
            title: "Ошибка!",
            text: "Произошла ошибка при отправке: " + response.error,
            icon: "error",
          });
        }
      },
      error: function (response, xhr, status, error) {
        var errText =
          "Произошла критическая ошибка при отправке! Повторите попытку отправить позже.";
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
  } else {
    $.ajax({
      url: "ajax/add_review",
      type: "POST",
      contentType: "application/json",
      data: JSON.stringify(formData),
      success: function (response) {
        if (response.success) {
          Swal.fire({
            title: "Успех!",
            text: "Отзыв успешно добавлен",
            icon: "success",
          }).then((result) => {
            if (result.isConfirmed) {
              location.reload();
            }
          });
        } else {
          Swal.fire({
            title: "Ошибка!",
            text: "Произошла ошибка при отправке: " + response.error,
            icon: "error",
          });
        }
      },
      error: function (response, xhr, status, error) {
        var errText =
          "Произошла критическая ошибка при отправке! Повторите попытку отправить позже.";
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
}
