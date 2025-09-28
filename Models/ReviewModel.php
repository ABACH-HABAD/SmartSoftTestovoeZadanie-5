<?php

namespace App\Models;

use Exception;
use App\Models\Model;
use App\Entities\Reviews\Review;

class ReviewModel extends Model
{
    /**
     * @return array|null|void
     */
    public function getReviews()
    {

        $query = "SELECT reviews.id, name, comment FROM reviews JOIN users ON users.id = reviews.user ORDER BY RAND() LIMIT 6;";
        $stmt = $this->connection->prepare($query);
        try {
            $stmt->execute();

            if ($result = $stmt->get_result()) {
                $array = array();
                foreach ($result as $row) {
                    $review = new Review();
                    $review->setID($row["id"]);
                    $review->setName($row["name"]);
                    $review->setComment($row["comment"]);
                    $array[] = $review;
                }
                return $array;
            } else {
                throw new Exception("Ошибка при получении отзывов: " . $this->connection->error);
            }
        } finally {
            $stmt->close();
        }
    }

    /**
     * @param int $user_id
     * @return Review|null|void
     */
    public function findReviewByUserId($user_id)
    {
        if (empty($user_id)) {
            throw new Exception("Нужно указать ID");
        }

        $query = "SELECT name, comment FROM reviews JOIN users ON users.id = reviews.user WHERE  users.id = ?;";
        $stmt = $this->connection->prepare($query);
        try {
            $stmt->bind_param("i", $user_id);
            $stmt->execute();

            if ($result = $stmt->get_result()) {
                foreach ($result as $row) {
                    $foundReview = new Review();
                    $foundReview->setName($row["name"]);
                    $foundReview->setComment($row["comment"]);
                    return $foundReview;
                }
            } else {
                throw new Exception("Ошибка при поиске отзыва: " . $this->connection->error);
            }
        } finally {
            $stmt->close();
        }
    }

    /**
     * @param int $user_id
     * @param string $comment
     * @return void
     */
    public function addReviewToDataBase($user_id, $comment)
    {

        if (empty($user_id)) {
            throw new Exception("Нужно указать ID пользователя, от чьего имени оставляется отзыв");
        }

        if ($this->findReviewByUserId($user_id)) {
            $this->changeReviewInDataBaseByUser($user_id, $comment);
            return;
        }

        if (empty($comment)) {
            throw new Exception("Все поля обязательны для заполнения");
        }

        $query = "INSERT INTO reviews (user, comment) VALUES (?, ?);";
        $stmt = $this->connection->prepare($query);
        try {
            $stmt->bind_param("is", $user_id, $comment);

            if (!$stmt->execute()) {
                throw new Exception("Ошибка при добавлении отзыва в базу данных: " . $this->connection->error);
            }
        } finally {
            $stmt->close();
        }
    }

    /**
     * @param int $id
     * @return void
     */
    public function deleteReviewInDataBase($id)
    {
        $query = "DELETE FROM reviews WHERE id = ?;";
        $stmt = $this->connection->prepare($query);
        try {
            $stmt->bind_param("i", $id);

            if (!$stmt->execute()) {
                throw new Exception("Ошибка при удалении отзыва: " . $this->connection->error);
            }
        } finally {
            $stmt->close();
        }
    }

    /**
     * @param int $id
     * @param string $comment
     * @return void
     */
    public function changeReviewInDataBase($id, $comment)
    {
        if (empty($id)) {
            throw new Exception("Нужно указать ID отзыва");
        }

        if (empty($comment)) {
            throw new Exception("Все поля обязательны для заполнения");
        }

        $query = "UPDATE reviews SET comment=? WHERE id=?;";
        $stmt = $this->connection->prepare($query);
        try {
            $stmt->bind_param("si", $comment, $id);


            if (!$stmt->execute()) {
                throw new Exception("Ошибка при изменении отзыва: " . $this->connection->error);
            }
        } finally {
            $stmt->close();
        }
    }

    /**
     * @param int $user_id
     * @param string $comment
     * @return void
     */
    public function changeReviewInDataBaseByUser($user_id, $comment)
    {
        if (empty($user_id)) {
            throw new Exception("Нужно указать ID пользователя");
        }

        if (empty($comment)) {
            throw new Exception("Все поля обязательны для заполнения");
        }

        $query = "UPDATE reviews SET comment=? WHERE user=?;";
        $stmt = $this->connection->prepare($query);
        try {
            $stmt->bind_param("si", $comment, $user_id);

            if (!$stmt->execute()) {
                throw new Exception("Ошибка при изменении отзыва: " . $this->connection->error);
            }
        } finally {
            $stmt->close();
        }
    }

    /**
     * @return array|null|void
     */
    public function getAllReviews()
    {
        $query = "SELECT reviews.id AS id, name, comment FROM reviews JOIN users ON users.id = reviews.user;";
        try {
            $stmt = $this->connection->prepare($query);
            $stmt->execute();

            if ($result = $stmt->get_result()) {
                $array = array();
                foreach ($result as $row) {
                    $review = new Review();
                    $review->setID($row["id"]);
                    $review->setName($row["name"]);
                    $review->setComment($row["comment"]);
                    $array[] = $review;
                }
                return $array;
            } else {
                throw new Exception("Ошибка при получении отзывов: " . $this->connection->error);
            }
        } finally {
            $stmt->close();
        }
    }
}
