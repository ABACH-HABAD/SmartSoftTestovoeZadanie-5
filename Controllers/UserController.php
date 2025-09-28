<?php

namespace App\Controllers;

use App\Controllers\Controller;

class UserController extends Controller
{

    /**
     * @return string
     */
    protected function layout(): string
    {
        return $this->userAuthorization() . $this->userLogin() . $this->userRegistration() . $this->userData();
    }

    /**
     * @return string
     */
    protected function userAuthorization(): string
    {
        return $this->template("/../Templates/User/you_have_account.html");
    }

    /**
     * @return string
     */
    protected function userLogin(): string
    {
        return $this->template("/../Templates/User/email_login.html");
    }

    /**
     * @return string
     */
    protected function userRegistration(): string
    {
        return $this->template("/../Templates/Index/form_registration.html");
    }

    /**
     * @return string
     */
    protected function userData(): string
    {
        return $this->template("/../Templates/User/UserLayout.php", array("userReview" => $this->userReview(), "createReview" => $this->createReview()));
    }

    /**
     * @return string
     */
    protected function userReview(): string
    {
        return $this->template("/../Templates/Index/ReviewListElement.php");
    }

    /**
     * @return string
     */
    protected function createReview(): string
    {
        return $this->template("/../Templates/Index/form_create_review.html");
    }

    /**
     * @return string
     */
    protected function updateData(): string
    {
        return $this->template("/../Templates/Index/form_registration.html");
    }
}
