document.addEventListener("DOMContentLoaded", function () {
  const Form = $("#FormCreateReview");
  Form.css("visibility", "hidden");
  Form.css("display", "none");
});

$(document).ready(function () {
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
});
