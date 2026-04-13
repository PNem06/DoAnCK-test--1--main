<?php
session_start();
require_once 'Config/database.php';
require_once 'Config/config.php';

ob_start();

try {
    $controller = $_GET['controller'] ?? 'home';
    $action = $_GET['action'] ?? 'index';
    $page = $_GET['page'] ?? 1;
    $id = $_GET['id'] ?? 0;

    switch ($controller) {

        // ================= HOME =================
        case 'home':
            require_once 'App/Controllers/PNem06/HomeController.php';
            $ctrl = new HomeController(Database::getInstance()->getConnection());

            switch ($action) {
                case 'movies':
                    $ctrl->movies($page);
                    break;
                case 'actors':
                    $ctrl->actors($page);
                    break;
                case 'search':
                    $ctrl->search($_GET['keyword'] ?? '');
                    break;
                case 'showNewsDetail':
                    $ctrl->showNewsDetail($id);
                    break;
                default:
                    $ctrl->index($page);
                    break;
            }
            break;

        // ================= ACTOR =================
       case 'actor':
            require_once 'App/Controllers/PNem06/ActorController.php';
            $ctrl = new ActorController();

            if ($action === 'showProfile' && $id) {
                $ctrl->showProfile($id);
            } else {
                $ctrl->index($page);
            }
            break;

        // ================= NEWS =================
        case 'news':
            require_once 'App/Controllers/TNhu2006/NewsController.php';
            $ctrl = new NewsController();

            if ($action === 'showDetail' && $id) {
                $ctrl->showDetail($id);
            } else {
                $ctrl->index();
            }
            break;

        // ================= MOVIE =================
        case 'movie':
            require_once 'App/Controllers/birb109/MovieController.php';
            $ctrl = new MovieController();

            if ($action === 'showDetail' && $id) {
                $ctrl->showDetail($id);
            } else {
                $ctrl->index($page);
            }
            break;

        // ================= DEFAULT =================
        default:
            require_once 'App/Controllers/PNem06/HomeController.php';
            $ctrl = new HomeController(Database::getInstance()->getConnection());
            $ctrl->index(1);
            break;
    }

} catch (Exception $e) {
    echo "<div class='alert alert-danger'>Lỗi: " . $e->getMessage() . "</div>";
}

$content = ob_get_clean();
include 'App/Views/member/layouts/main.php';
?>