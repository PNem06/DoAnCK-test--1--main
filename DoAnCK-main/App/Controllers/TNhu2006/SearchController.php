<?php

class SearchController {

    private $mysqli;

    public function __construct() {
        $this->mysqli = Database::getInstance()->getMysqliConnection();
    }

    public function ajax() {

        header('Content-Type: application/json; charset=utf-8');

        $context = $_GET['context'] ?? 'home';
        $keyword = $_GET['keyword'] ?? '';
        $keyword = "%$keyword%";

        $results = [];

        $sql = "SELECT New_ID, New_Title FROM tbl_new WHERE New_Title LIKE ? LIMIT 5";
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

        echo json_encode($results);
        exit;
    }
}