<?php

namespace App\Cfg;

use Phroute\Phroute;
use Phroute\Phroute\RouteCollector;
use Phroute\Phroute\Dispatcher;
use Phroute\Phroute\Exception\HttpRouteNotFoundException;
use App\Models\ReviewModel;
use App\Models\UserModel;
use App\Controllers\IndexController;
use App\Controllers\UserController;
use App\Controllers\AllReviewsController;
use App\Controllers\AllUsersController;
use Exception;

class Router
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var RouteCollector
     */
    private $router;

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $value
     * @return void
     */
    public function setPath($value)
    {
        $this->path = $value;
    }

    /**
     * @return RouteCollector
     */
    public function getRouter(): RouteCollector
    {
        return $this->router;
    }

    /**
     * @param string $value
     * @return void
     */
    public function setRouter($value)
    {
        $this->router = $value;
    }

    public function __construct()
    {
        $this->path = $this->detectBasePath();
        $this->router = new RouteCollector();

        $this->loadRouts();
    }

    /**
     * @return string
     */
    private function detectBasePath(): string
    {
        $url = $_SERVER['SCRIPT_NAME'] ?? '';
        $base_path = dirname($url);

        return rtrim($base_path, '/');
    }

    /**
     * @return void
     */
    public function loadRouts()
    {
        $router = $this->getRouter();

        //Страницы
        $router->get("/index", (function () {
            return (new IndexController())->view();
        }));
        $router->get("/user", (function () {
            return (new UserController())->view();
        }));
        $router->get("/allUsers", (function () {
            return (new AllUsersController())->view();
        }));
        $router->get("/allReviews", (function () {
            return (new AllReviewsController())->view();
        }));

        //Запросы user
        //get
        $router->get("/ajax/get_user_by_email", (function () {
            try {
                $email = $_GET['email'] ?? '';
                $email = urldecode($email);

                $model = new UserModel();
                $found_user = $model->findByEmail($email);
                if ($found_user == null) {
                    throw new Exception("Пользователь не найден");
                }
                $response = json_encode([
                    'success' => true,
                    'message' => 'Пользователь получен из базы данных',
                    'id' => $found_user->getID(),
                    'name' => $found_user->getName(),
                    'surname' => $found_user->getSurname(),
                    'email' => $found_user->getEmail(),
                    'message' => $found_user->getMessage(),
                ], JSON_UNESCAPED_UNICODE);
                header('Content-Type: application/json; charset=utf-8');
                return $response;
            } catch (Exception $e) {
                http_response_code(400);
                header('Content-Type: application/json; charset=utf-8');
                return  json_encode([
                    'success' => false,
                    'error' => $e->getMessage()
                ], JSON_UNESCAPED_UNICODE);
            }
        }));
        $router->get("/ajax/get_user_by_id", (function () {
            try {
                $id = $_GET['id'] ?? '';
                $id = urldecode($id);

                $model = new UserModel();
                $found_user = $model->findByID($id);

                if ($found_user == null) {
                    throw new Exception("Пользователь не найден");
                }
                $response = json_encode([
                    'success' => true,
                    'message' => 'Пользователь получен из базы данных',
                    'id' => $found_user->getID(),
                    'name' => $found_user->getName(),
                    'surname' => $found_user->getSurname(),
                    'email' => $found_user->getEmail(),
                    'message' => $found_user->getMessage(),
                ], JSON_UNESCAPED_UNICODE);
                header('Content-Type: application/json; charset=utf-8');
                return $response;
            } catch (Exception $e) {
                http_response_code(400);
                header('Content-Type: application/json; charset=utf-8');
                return  json_encode([
                    'success' => false,
                    'error' => $e->getMessage()
                ], JSON_UNESCAPED_UNICODE);
            }
        }));
        //add
        $router->post("/ajax/add_user", (function () {
            try {
                $input = json_decode(file_get_contents('php://input'), true);

                $model = new UserModel();
                $model->addUserToDataBase($input['name'], $input['surname'], $input['email'], $input['message']);

                $response = json_encode([
                    'success' => true,
                    'message' => 'Пользователь успешно зарегестрирован'
                ], JSON_UNESCAPED_UNICODE);
                header('Content-Type: application/json; charset=utf-8');
                return $response;
            } catch (Exception $e) {
                http_response_code(400);
                header('Content-Type: application/json; charset=utf-8');
                return  json_encode([
                    'success' => false,
                    'error' => $e->getMessage()
                ], JSON_UNESCAPED_UNICODE);
            }
        }));
        //edit
        $router->post("/ajax/edit_user", (function () {
            try {
                $input = json_decode(file_get_contents('php://input'), true);

                $model = new UserModel();
                $model->editUserInDataBase($input['id'], $input['name'], $input['surname'], $input['email'], $input['message']);
                $response = json_encode([
                    'success' => true,
                    'message' => 'Данные пользователя успешно изменены'
                ], JSON_UNESCAPED_UNICODE);
                header('Content-Type: application/json; charset=utf-8');
                return $response;
            } catch (Exception $e) {
                http_response_code(400);
                header('Content-Type: application/json; charset=utf-8');
                return  json_encode([
                    'success' => false,
                    'error' => $e->getMessage()
                ], JSON_UNESCAPED_UNICODE);
            }
        }));
        //delte
        $router->post("/ajax/delete_user", (function () {
            try {
                $input = json_decode(file_get_contents('php://input'), true);

                $model = new UserModel();
                $model->deleteUserInDataBase($input['id']);
                $response = json_encode([
                    'success' => true,
                    'message' => 'Пользователь успешно удалён'
                ], JSON_UNESCAPED_UNICODE);
                header('Content-Type: application/json; charset=utf-8');
                return $response;
            } catch (Exception $e) {
                http_response_code(400);
                header('Content-Type: application/json; charset=utf-8');
                return  json_encode([
                    'success' => false,
                    'error' => $e->getMessage()
                ], JSON_UNESCAPED_UNICODE);
            }
        }));

        //Запросы review
        //get
        $router->get("/ajax/get_review", (function () {
            try {
                $id = $_GET['id'] ?? '';
                $id = urldecode($id);

                $model = new ReviewModel();
                $found_review = $model->FindReviewByUserID($id);

                if ($found_review == null) {
                    throw new Exception("Отзыв не найден");
                }
                $response = json_encode([
                    'success' => true,
                    'message' => 'Отзыв найден в базе данных',
                    'name' => $found_review->getName(),
                    'comment' => $found_review->getComment()
                ], JSON_UNESCAPED_UNICODE);
                header('Content-Type: application/json; charset=utf-8');
                return $response;
            } catch (Exception $e) {
                http_response_code(400);
                header('Content-Type: application/json; charset=utf-8');
                return  json_encode([
                    'success' => false,
                    'error' => $e->getMessage()
                ], JSON_UNESCAPED_UNICODE);
            }
        }));
        //add
        $router->post("/ajax/add_review", (function () {
            try {
                $input = json_decode(file_get_contents('php://input'), true);

                $model = new ReviewModel();
                $model->addReviewToDataBase($input['id'], $input['comment']);
                $response = json_encode([
                    'success' => true,
                    'message' => 'Отзыв успешно добавлен'
                ], JSON_UNESCAPED_UNICODE);
                header('Content-Type: application/json; charset=utf-8');
                return $response;
            } catch (Exception $e) {
                http_response_code(400);
                header('Content-Type: application/json; charset=utf-8');
                return  json_encode([
                    'success' => false,
                    'error' => $e->getMessage()
                ], JSON_UNESCAPED_UNICODE);
            }
        }));
        //edit
        $router->post("/ajax/edit_review", (function () {
            try {
                $input = json_decode(file_get_contents('php://input'), true);

                $model = new ReviewModel();
                error_log(" " . $input['id'] . " " . $input['comment'] . " ");
                $model->changeReviewInDataBase($input['id'], $input['comment']);

                $response = json_encode([
                    'success' => true,
                    'message' => 'Отзыв успешно изменён'
                ], JSON_UNESCAPED_UNICODE);
                header('Content-Type: application/json; charset=utf-8');
                return $response;
            } catch (Exception $e) {
                http_response_code(400);
                header('Content-Type: application/json; charset=utf-8');
                return  json_encode([
                    'success' => false,
                    'error' => $e->getMessage()
                ], JSON_UNESCAPED_UNICODE);
            }
        }));
        //delete
        $router->post("/ajax/delete_review", (function () {
            try {
                $input = json_decode(file_get_contents('php://input'), true);

                $model = new ReviewModel();
                $model->deleteReviewInDataBase($input['id']);
                $response = json_encode([
                    'success' => true,
                    'message' => 'Отзыв успешно удалён'
                ], JSON_UNESCAPED_UNICODE);
                header('Content-Type: application/json; charset=utf-8');
                return $response;
            } catch (Exception $e) {
                http_response_code(400);
                header('Content-Type: application/json; charset=utf-8');
                return  json_encode([
                    'success' => false,
                    'error' => $e->getMessage()
                ], JSON_UNESCAPED_UNICODE);
            }
        }));
    }


    /**
     * @return void
     */
    public function dispatch()
    {
        error_log("=== DISPATCH START ===");

        $request_uri = $_SERVER['REQUEST_URI'];

        if ($this->needRedirect($request_uri)) {
            return;
        }

        $url = $this->extractUrl($request_uri);

        error_log("Request URI: " . $request_uri);
        error_log("Extracted URL: " . $url);
        error_log("Request method: " . ($_SERVER['REQUEST_METHOD'] ?? 'GET'));

        $dispatcher = new Dispatcher($this->router->getData());

        try {
            $response = $dispatcher->dispatch($_SERVER["REQUEST_METHOD"], $url);
        } catch (HttpRouteNotFoundException $e) {
            error_log("Request fail with code 404: " . $e->getMessage());

            http_response_code(404);
            $response = (new IndexController)->getError();
        }

        return $response;
    }

    /**
     * @param string $request_uri
     * @return bool
     */
    private function needRedirect($request_uri): bool
    {
        if (preg_match('#/index\.php$#', $request_uri)) {
            $request_uri = str_replace('/index.php', '/index', $request_uri);
            header('Location: ' . $request_uri, true, 301);
            exit;
        }

        return false;
    }

    /**
     * @param string $uri
     * @return string
     */
    private function extractUrl($uri): string
    {
        $uri = strtok($uri, '?');

        if (strpos($uri, $this->getPath()) === 0) {
            $route = substr($uri, strlen($this->getPath()));
        } else {
            $route = $uri;
        }

        $route = trim($route, '/');
        $route = $route === '' ? '/' : '/' . $route;

        return $route;
    }

    /**
     * @param string $path
     * @return string
     */
    public function asset(string $path): string
    {
        $path = ltrim($path, '/');
        return $this->getPath() . '/' . $path;
    }
}
