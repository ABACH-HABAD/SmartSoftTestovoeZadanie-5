$(document).ready(function () {
  $(document).on("click", ".delete-review", deletReview);
  $(document).on("click", ".edit-review", editReview);
});

async function deletReview() {
  const reviewId = $(this).data("review-id");
  const row = $(this).closest("tr");

  await Swal.fire({
    title: "Подтвержидение",
    text: "Вы уверены что хотите удалить отзыв?",
    icon: "question",
    showDenyButton: true,
    confirmButtonText: "Да, хочу удалить",
    denyButtonText: "Нет, ненадо",
  }).then((result) => {
    if (result.isDenied) {
      Swal.fire({
        title: "Отмена",
        text: "Отзыв не был удалён",
      });
      throw "Отзыв не был удалён";
    }
  });

  $.ajax({
    url: "ajax/delete_review",
    type: "POST",
    contentType: "application/json",
    data: JSON.stringify({ id: reviewId }),
    success: function (response) {
      if (response.success) {
        Swal.fire({
          title: "Успех!",
          text: "Отзыв успешно удалён",
          icon: "success",
        });
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

function editReview() {
  const reviewId = $(this).data("review-id");
  const reviewComment = $(this).data("review-comment");

  const Label = $("#InputName3_label");
  const InputName = $("#InputName3");

  $("#InputName3").prop("disabled", true);

  const Form = $("#FormCreateReview");

  Form.trigger("reset");
  if (
    Form.css("visibility") == "hidden" ||
    (Form.css("visibility") == "visible" && reviewId != $("#InputName3")) ||
    (Form.css("visibility") == "visible" &&
      $("#editReviewTitle").text() == "Создание нового отзыва")
  ) {
    Form.css("visibility", "visible");
    Form.css("display", "block");
    $("#editReviewTitle").text("Редактирование отзыва");

    InputName.attr("placeholder", "Введите id отзыва");
    Label.text("ID отзыва");

    $("#InputName3").val(reviewId);
    $("#InputMessageCreateReview").text(reviewComment);
  } else {
    Form.css("visibility", "hidden");
    Form.css("display", "none");
  }
}
