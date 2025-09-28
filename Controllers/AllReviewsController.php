<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\ReviewModel;
use App\Entities\Reviews\Review;

class AllReviewsController extends Controller
{
    /**
     * @var UserModel
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
        return $this->reviewsList();
    }

    /**
     * @return string
     */
    private function reviewsList(): string
    {
        $model = $this->model;
        $reviews_list = $model->getAllReviews();
        if ($reviews_list == null) {
            $reviews_list = array();
            for ($i = 0; $i < 1; $i++) {
                $review = new Review();
                $review->setName("-");
                $review->setComment("-");
                $reviews_list[] = $review;
            }
        }
        $stringify_reviews_list = array();
        for ($i = 0; $i < count($reviews_list); $i++) {
            $stringify_reviews_list[] = $this->ReviewListElement($reviews_list[$i]);
        }
        return $this->template("/../Templates/AllReviews/AllReviewsLayout.php", array("reviews" => $stringify_reviews_list, "reviewForm" => $this->reviewForm()));
    }

    /**
     * @param Review $review
     * @return string
     */
    private function reviewListElement($review): string
    {
        return $this->template("/../Templates/AllReviews/ReviewListElement.php", $review->ToArray());
    }

    /**
     * @return string
     */
    private function reviewForm(): string
    {
        return $this->template("/../Templates/Index/form_create_review.html");
    }
}
