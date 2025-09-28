<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\UserModel;
use App\Entities\Users\User;

class AllUsersController extends Controller
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
        $this->model = new UserModel();
    }

    /**
     * @return string
     */
    protected function layout(): string
    {
        return $this->usersList();
    }

    /**
     * @return string
     */
    private function usersList(): string
    {
        $model = $this->model;
        $users_list = $model->getAllUsers();
        if ($users_list == null) {
            $users_list = array();
            for ($i = 0; $i < 1; $i++) {
                $user = new User();
                $user->setID(-1);
                $user->setName("-");
                $user->setSurname("-");
                $user->setEmail("-");
                $user->setMessage("-");
                $users_list[] = $user;
            }
        }
        $stringify_users_list = array();
        for ($i = 0; $i < count($users_list); $i++) {
            $stringify_users_list[] = $this->userListElement($users_list[$i]);
        }
        return $this->template("/../Templates/AllUsers/AllUsersLayout.php", array("users" => $stringify_users_list, "userForm" => $this->userForm()));
    }

    /**
     * @param User $user
     * @return string
     */
    private function userListElement($user): string
    {
        return $this->template("/../Templates/AllUsers/UserListElement.php", $user->toArray());
    }

    /**
     * @return string
     */
    private function userForm(): string
    {
        return $this->template("/../Templates/Index/form_registration.html");
    }
}
