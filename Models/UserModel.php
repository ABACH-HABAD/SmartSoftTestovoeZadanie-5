<?php

namespace App\Models;

use Exception;
use App\Entities\Users\User;

class UserModel extends Model
{
    /**
     * @param string $name
     * @param string $surname
     * @param string $email
     * @param string $message
     * @return void
     */
    public function addUserToDataBase($name, $surname, $email, $message)
    {
        if (empty($name) || empty($surname) || empty($email) || empty($message)) {
            throw new Exception("Все поля обязательны для заполнения");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Некорректный email");
        }

        if ($this->findByEmail($email)) {
            throw new Exception("На данную почту аккаунт уже зарегестрирован");
        }

        $query = "INSERT INTO users (name, surname, email, message) VALUES (?, ?, ?, ?);";
        $stmt = $this->connection->prepare($query);
        try {
            $stmt->bind_param("ssss", $name, $surname, $email, $message);

            if (!$stmt->execute()) {
                throw new Exception("Ошибка при добавлении пользователя: " . $this->connection->error);
            }
        } finally {
            $stmt->close();
        }
    }

    /**
     * @param int $id
     * @return void
     */
    public function deleteUserInDataBase($id)
    {
        $reviewCheckQuery = "SELECT id FROM reviews WHERE user = ?;";
        $stmt = $this->connection->prepare($reviewCheckQuery);
        try {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $deleteReviewsQuery = "DELETE FROM reviews WHERE id = ?;";
                $stmt2 = $this->connection->prepare($deleteReviewsQuery);
                try {
                    $stmt2->bind_param("i", $result->fetch_assoc()['id']);
                    $stmt2->execute();
                } finally {
                    $stmt2->close();
                }
            }
        } finally {
            $stmt->close();
        }

        $deleteUserQuery = "DELETE FROM users WHERE id = ?;";
        $stmt3 = $this->connection->prepare($deleteUserQuery);
        try {
            $stmt3->bind_param("i", $id);

            if (!$stmt3->execute()) {
                throw new Exception("Ошибка при удалении пользователя: " . $this->connection->error);
            }
        } finally {
            $stmt3->close();
        }
    }

    /**
     * @param int $id
     * @param string $name
     * @param string $surname
     * @param string $email
     * @param string $message
     * @return void
     */
    public function editUserInDataBase($id, $name, $surname, $email, $message)
    {
        $query = "UPDATE users SET name = ?, surname = ?, email = ?, message=? WHERE id = ?;";
        $stmt = $this->connection->prepare($query);
        try {
            $stmt->bind_param("ssssi", $name, $surname, $email, $message, $id);

            if (!$stmt->execute()) {
                throw new Exception("Ошибка при изменении данных пользователя: " . $this->connection->error);
            }
        } finally {
            $stmt->close();
        }
    }

    /**
     * @param string $email
     * @return User|null
     */
    public function findByEmail($email)
    {
        if (empty($email)) {
            throw new Exception("Укажите электронную почту");
        }

        $query = "SELECT * FROM users WHERE email = ?;";
        $stmt = $this->connection->prepare($query);
        try {
            $stmt->bind_param("s", $email);
            $stmt->execute();

            if ($result = $stmt->get_result()) {
                foreach ($result as $row) {
                    $user = new User();
                    $user->setID($row["id"]);
                    $user->setName($row["name"]);
                    $user->setSurname($row["surname"]);
                    $user->setEmail($row["email"]);
                    $user->setMessage($row["message"]);
                    return $user;
                }
            } else {
                throw new Exception("Ошибка при поиске пользователя: " . $this->connection->error);;
            }
        } finally {
            $stmt->close();
        }
    }

    /**
     * @param int $userID
     * @return User|null
     */
    public function findByID($userID)
    {
        $query = "SELECT * FROM users WHERE id = ?;";
        $stmt = $this->connection->prepare($query);
        try {
            $stmt->bind_param("i", $userID);
            $stmt->execute();

            if ($result = $stmt->get_result()) {
                foreach ($result as $row) {
                    $user = new User();
                    $user->setID($row["id"]);
                    $user->setName($row["name"]);
                    $user->setSurname($row["surname"]);
                    $user->setEmail($row["email"]);
                    $user->setMessage($row["message"]);
                    return $user;
                }
            } else {
                throw new Exception("Ошибка при поиске пользователя: " . $this->connection->error);;
            }
        } finally {
            $stmt->close();
        }
    }

    /**
     * @return array
     */
    public function getAllUsers()
    {
        $query = "SELECT * FROM users;";
        $stmt = $this->connection->prepare($query);
        try {
            $stmt->execute();

            if ($result = $stmt->get_result()) {
                $array = array();
                foreach ($result as $row) {
                    $user = new User();
                    $user->setID($row["id"]);
                    $user->setName($row["name"]);
                    $user->setSurname($row["surname"]);
                    $user->setEmail($row["email"]);
                    $user->setMessage($row["message"]);
                    $array[] = $user;
                }
                return $array;
            } else {
                throw new Exception("Ошибка при получении списка пользователей " . $this->connection->error);;
            }
        } finally {
            $stmt->close();
        }
    }
}
