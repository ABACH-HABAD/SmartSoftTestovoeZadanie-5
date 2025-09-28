<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\ReviewModel;
use App\Entities\Reviews\Review;

class IndexController extends Controller
{
    /**
     * @var ReviewModel
     */
    protected $model;

    /**
     * @return void
     */
    public function __construct()
    {
        $this->model = new ReviewModel();
    }

    /**
     * @return string
     */
    protected function layout(): string
    {
        return $this->formRegistration() . $this->formOrder() . $this->reviewList() . $this->scripts();
    }

    /**
     * @return string
     */
    private function formRegistration(): string
    {
        return $this->template("/../Templates/Index/form_registration.html");
    }

    /**
     * @return string
     */
    private function formOrder(): string
    {
        return $this->template("/../Templates/Index/form_order.html");
    }

    /**
     * @return string
     */
    private function reviewList(): string
    {
        $model = $this->model;
        $reviews_list = $model->getReviews();
        if ($reviews_list == null) {
            $reviews_list = array();
            for ($i = 0; $i < 6; $i++) {
                $review = new Review();
                $review->setName("Ошикба");
                $review->setComment("Неудалось загрузить отзыв");
                $reviews_list[] = $review;
            }
        }
        $stringify_reviews_list = array();
        for ($i = 0; $i < count($reviews_list); $i++) {
            $stringify_reviews_list[] = $this->reviewListElement($reviews_list[$i]);
        }
        return $this->template("/../Templates/Index/ReviewsList.php", array("formCreateReview" => $this->fromCreateReview(), "reviews" => $stringify_reviews_list));
    }

    /**
     * @param Review $review
     * @return string
     */
    private function reviewListElement($review): string
    {
        return $this->template("/../Templates/Index/ReviewListElement.php", $review->ToArray());
    }

    /**
     * @return string
     */
    private function fromCreateReview(): string
    {
        return $this->template("/../Templates/Index/form_create_review.html");
    }

    /**
     * @return string
     */
    private function scripts(): string
    {
        return $this->template("/../Templates/Index/scripts.html");
    }
}
