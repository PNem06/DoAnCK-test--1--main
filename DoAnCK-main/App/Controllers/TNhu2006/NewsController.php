<?php
// ✅ ĐƯỜNG DẪN CHÍNH XÁC TỪ TNhu2006
require_once __DIR__ . '/../../../Config/database.php';
require_once __DIR__ . '/../../Models/TNhu2006/News.php';
require_once __DIR__ . '/../../Models/TNhu2006/Comment.php';

class NewsController {
    private $mysqli;
    
    public function __construct() {
        $this->mysqli = Database::getInstance()->getMysqliConnection();
    }
    
    public function index() {
        $sql = "SELECT n.*, a.Username, a.Account_img 
                FROM tbl_new n 
                LEFT JOIN tbl_account a ON n.Account_ID = a.Account_ID 
                WHERE n.New_Status = 'Publish' 
                ORDER BY n.New_PublishDate DESC 
                LIMIT 12";
        $result = $this->mysqli->query($sql);
        
        $GLOBALS['newsList'] = [];
        while ($row = $result->fetch_assoc()) {
            $row['short_content'] = substr(strip_tags($row['New_Content'] ?? ''), 0, 120) . '...';
            $row['short_desc'] = substr(strip_tags($row['New_Description'] ?? $row['New_Content'] ?? ''), 0, 150) . '...';
            $row['category_label'] = $row['New_Category'] === 'Actor' ? '👥 Diễn viên' : '🎬 Phim ảnh';
            $GLOBALS['newsList'][] = $row;
        }
        $GLOBALS['pageTitle'] = 'Tin tức điện ảnh';
        $GLOBALS['totalPages'] = 1;
        $GLOBALS['pageNum'] = 1;
        
        include __DIR__ . '/../../../App/Views/member/home.php'; // ✅ DÙNG home.php
    }
    
    public function showDetail($news_id) {
        $news = $this->getNewsById($news_id);
        if (!$news) {
            $_SESSION['error'] = 'Tin tức không tồn tại!';
            header('Location: index.php');
            exit;
        }
        
        // TĂNG VIEW
        $this->incrementView($news_id);
        
        $GLOBALS['news'] = $news;
        $GLOBALS['comments'] = $this->getCommentsByNewsId($news_id);
        $GLOBALS['relatedNews'] = $this->getRelatedNews($news_id);
        $GLOBALS['pageTitle'] = $news['New_Title'];
        
        include __DIR__ . '/../../../App/Views/member/news-detail.php';
    }
    
    private function getNewsById($news_id) {
        $sql = "SELECT n.*, a.Username, a.Account_img 
                FROM tbl_new n 
                LEFT JOIN tbl_account a ON n.Account_ID = a.Account_ID 
                WHERE n.New_ID = ? AND n.New_Status = 'Publish'";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("i", $news_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    
    private function getCommentsByNewsId($news_id) {
        $sql = "SELECT c.*, a.Username, a.Account_img 
                FROM tbl_comment c 
                JOIN tbl_account a ON c.Account_ID = a.Account_ID 
                WHERE c.New_ID = ? 
                ORDER BY c.Comment_Date DESC 
                LIMIT 10";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("i", $news_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    private function getRelatedNews($excludeId, $limit = 4) {
        $sql = "SELECT n.New_ID, n.New_Title, n.New_PublishDate, a.Username
                FROM tbl_new n 
                LEFT JOIN tbl_account a ON n.Account_ID = a.Account_ID
                WHERE n.New_ID != ? AND n.New_Status = 'Publish' 
                ORDER BY n.New_PublishDate DESC 
                LIMIT ?";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("ii", $excludeId, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    private function incrementView($news_id) {
        $sql = "UPDATE tbl_new SET New_View = New_View + 1 WHERE New_ID = ?";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("i", $news_id);
        $stmt->execute();
    }
}
?>