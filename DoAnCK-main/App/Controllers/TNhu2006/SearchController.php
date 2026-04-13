<?php
require_once __DIR__ . '/../../../Config/database.php';

class SearchController {

    private $mysqli;

    public function __construct() {
        $this->mysqli = Database::getInstance()->getMysqliConnection();
    }

    public function ajax() {

        header('Content-Type: application/json; charset=utf-8');

        $context = $_GET['context'] ?? 'home';
        $keyword = trim($_GET['keyword'] ?? '');
        $keyword = "%$keyword%";

        $results = [];

        if ($context === 'actor') {

    $sql = "SELECT Actor_ID, Actor_Name 
            FROM tbl_actor 
            WHERE Actor_Name LIKE ?
            LIMIT 10";

            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param("s", $keyword);
            $stmt->execute();
            $res = $stmt->get_result();

            while ($row = $res->fetch_assoc()) {
                $results[] = [
                    "title" => $row['Actor_Name'],
                    "type"  => "Diễn viên",
                    "link"  => "index.php?controller=actor&action=showProfile&id=" . $row['Actor_ID']
                ];
            }
        }

        // ================= MOVIE =================
        elseif ($context == 'movie') {

            $sql = "SELECT Movie_ID, Movie_Title 
                    FROM tbl_movie 
                    WHERE Movie_Title LIKE ? 
                    LIMIT 10";

            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param("s", $keyword);
            $stmt->execute();
            $res = $stmt->get_result();

            while ($row = $res->fetch_assoc()) {
                $results[] = [
                    "title" => $row['Movie_Title'],
                    "type"  => "Phim",
                    "link"  => "index.php?controller=movie&action=showDetail&id=" . $row['Movie_ID']
                ];
            }
        }

        // ================= NEWS =================
        elseif ($context == 'news') {

            $sql = "SELECT New_ID, New_Title 
                    FROM tbl_new 
                    WHERE New_Title LIKE ? 
                    LIMIT 10";

            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param("s", $keyword);
            $stmt->execute();
            $res = $stmt->get_result();

            while ($row = $res->fetch_assoc()) {
                $results[] = [
                    "title" => $row['New_Title'],
                    "type"  => "Tin tức",
                    "link"  => "index.php?controller=news&action=showDetail&id=" . $row['New_ID']
                ];
            }
        }

        // ================= DEFAULT =================
        else {

            $sql = "SELECT New_ID, New_Title 
                    FROM tbl_new 
                    WHERE New_Title LIKE ? 
                    LIMIT 5";

            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param("s", $keyword);
            $stmt->execute();
            $res = $stmt->get_result();

            while ($row = $res->fetch_assoc()) {
                $results[] = [
                    "title" => $row['New_Title'],
                    "type"  => "Tin tức",
                    "link"  => "index.php?controller=news&action=showDetail&id=" . $row['New_ID']
                ];
            }
        }

        echo json_encode($results);
        exit;
    }
}