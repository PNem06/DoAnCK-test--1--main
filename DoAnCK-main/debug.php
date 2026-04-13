<?php
echo "<h2>🔍 DEBUG PATH - Actor System</h2>";
echo "<pre>";

// 1. THÔNG TIN THỨ MỤC HIỆN TẠI
echo "📁 Thư mục hiện tại: " . __DIR__ . "\n";
echo "📁 DOCUMENT_ROOT: " . $_SERVER['DOCUMENT_ROOT'] . "\n\n";

// 2. KIỂM TRA FILE TỒN TẠI
$files = [
    'Config/config.php' => 'Config/config.php',
    'Config/database.php' => 'Config/database.php',
    'App/Models/PNem06/Actor.php' => 'App/Models/PNem06/Actor.php',
    'App/Controllers/PNem06/ActorController.php' => 'App/Controllers/PNem06/ActorController.php'
];

foreach ($files as $test => $path) {
    $full_path = realpath($path);
    $exists = file_exists($path);
    echo "✅ $test: " . ($exists ? "<span style='color:green'>TỒN TẠI ($full_path)</span>" : "<span style='color:red'>KHÔNG TỒN TẠI</span>") . "\n";
}

// 3. TEST PATH TỪ Actor.php
echo "\n🎯 TEST PATH TỪ App/Models/PNem06/Actor.php:\n";
$actor_dir = __DIR__ . '/App/Models/PNem06';
if (is_dir($actor_dir)) {
    chdir($actor_dir);
    echo "  Từ Actor.php → Config/config.php: " . (file_exists('../../Config/config.php') ? 'OK' : 'FAIL') . "\n";
    echo "  Từ Actor.php → Config/database.php: " . (file_exists('../../Config/database.php') ? 'OK' : 'FAIL') . "\n";
} else {
    echo "  ❌ Thư mục App/Models/PNem06 KHÔNG TỒN TẠI\n";
}

// 4. TEST REQUIRE
echo "\n🚀 TEST REQUIRE:\n";
try {
    require_once 'Config/config.php';
    echo "  Config/config.php: OK\n";
} catch (Exception $e) {
    echo "  Config/config.php: FAIL - " . $e->getMessage() . "\n";
}

try {
    require_once 'Config/database.php';
    echo "  Config/database.php: OK\n";
} catch (Exception $e) {
    echo "  Config/database.php: FAIL - " . $e->getMessage() . "\n";
}

// 5. CẤU TRÚC THỨ MỤC
echo "\n📂 CẤU TRÚC THỨ MỤC:\n";
$dirs = ['Config', 'App/Models/PNem06', 'App/Controllers/PNem06'];
foreach ($dirs as $dir) {
    echo "  $dir/ " . (is_dir($dir) ? '✅' : '❌') . "\n";
}

echo "</pre>";
echo "<hr>";
echo "<a href='index.php?controller=actor' class='btn btn-primary'>Test Actor</a>";
?>