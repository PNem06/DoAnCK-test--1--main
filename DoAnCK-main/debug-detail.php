<?php
session_start();
require_once 'Config/database.php';
require_once 'Config/config.php';
require_once 'App/Controllers/PNem06/HomeController.php';

echo "<div style='padding:30px;background:#f0f8ff;border-radius:15px;max-width:800px;margin:20px auto;'>";
echo "<h2>🔍 DEBUG CHI TIẾT - V2</h2>";

// Tạo controller instance
$db = Database::getInstance()->getConnection();
$ctrl = new HomeController($db);

$id = $_GET['id'] ?? 1;
echo "<h4>📍 URL Test: <code style='background:#ffc107;padding:5px;border-radius:5px;'>";
echo "index.php?controller=home&amp;action=showNewsDetail&amp;id=$id";
echo "</code></h4>";

// Test database connection
echo "<h4>1. Kết nối DB:</h4>";
echo $db ? "✅ OK" : "❌ LỖI";

echo "<h4>2. Test getNewsById($id):</h4>";
// FIX: Dùng Reflection để gọi private method
$reflector = new ReflectionClass($ctrl);
$method = $reflector->getMethod('getNewsById');
$method->setAccessible(true);
$news = $method->invoke($ctrl, $id);

if ($news) {
    echo "<div style='background:#d4edda;padding:15px;border-radius:10px;border-left:5px solid #28a745;'>";
    echo "✅ TÌM THẤY TIN ID=$id<br>";
    echo "<strong>Tiêu đề:</strong> " . htmlspecialchars($news['New_Title']) . "<br>";
    echo "<strong>Nội dung:</strong> " . substr(strip_tags($news['New_Content']), 0, 100) . "...<br>";
    echo "<strong>Tác giả:</strong> " . ($news['Username'] ?? 'N/A');
    echo "</div>";
} else {
    echo "<div style='background:#f8d7da;padding:15px;border-radius:10px;border-left:5px solid #dc3545;'>";
    echo "❌ KHÔNG TÌM THẤY TIN ID=$id<br>";
    echo "Kiểm tra bảng <code>tbl_new</code> có dữ liệu không?";
    echo "</div>";
}

// Test view
$viewPath = __DIR__ . '/App/Views/member/news-detail.php';
echo "<h4>3. View file:</h4>";
echo file_exists($viewPath) ? 
    "✅ TỒN TẠI: <code>$viewPath</code>" : 
    "❌ THIẾU: Tạo file <code>App/Views/member/news-detail.php</code>";

echo "</div>";

// Test trực tiếp SQL
echo "<h4>4. SQL trực tiếp:</h4>";
$mysqli = Database::getInstance()->getMysqliConnection();
$result = $mysqli->query("SELECT * FROM tbl_new WHERE New_ID = $id LIMIT 1");
if ($result && $row = $result->fetch_assoc()) {
    echo "<p style='color:green;'>✅ DB có dữ liệu ID=$id</p>";
} else {
    echo "<p style='color:red;'>❌ Bảng tbl_new KHÔNG có ID=$id</p>";
}
?>
