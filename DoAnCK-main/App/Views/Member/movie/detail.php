<?php 
$movie = $GLOBALS['movie'] ?? null;
$characters = $GLOBALS['characters'] ?? [];
?>
<?php if (!$movie): ?>
<div class="text-center py-8">
    <i class="fas fa-video-slash fa-5x text-white-50 mb-4"></i>
    <h3 class="text-white">Phim không tồn tại!</h3>
    <a href="index.php?controller=movie" class="btn btn-outline-light btn-lg mt-3">← Quay lại danh sách</a>
</div>
<?php else: ?>

<div class="row g-5 mb-5">
    <!-- PHIM INFO -->
    <div class="col-lg-8">
        <div class="card shadow-xl border-0 overflow-hidden" style="border-radius: 24px; background: rgba(255,255,255,0.95);">
            <div class="row g-0">
                <div class="col-md-4">
                    <div class="position-relative h-100" style="height: 500px;">
                        <?php if ($movie['Movie_Img']): ?>
                            <img src="uploads/movies/<?= htmlspecialchars($movie['Movie_Img']) ?>" 
                                 class="h-100 w-100 object-fit-cover" alt="<?= htmlspecialchars($movie['Movie_Title']) ?>">
                        <?php else: ?>
                            <div class="h-100 d-flex align-items-center justify-content-center bg-gradient-primary">
                                <i class="fas fa-film fa-5x text-white opacity-75"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card-body p-5">
                        <h1 class="display-4 fw-bold text-dark mb-4 lh-1">
                            <?= htmlspecialchars($movie['Movie_Title']) ?>
                        </h1>
                        
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <strong>🎬 Ngày công chiếu:</strong><br>
                                <span class="fs-5 text-primary"><?= $movie['Movie_ReleaseDate'] ? date('d/m/Y', strtotime($movie['Movie_ReleaseDate'])) : 'Chưa công chiếu' ?></span>
                            </div>
                            <?php if ($movie['Movie_StreamingDate']): ?>
                            <div class="col-md-6 mb-3">
                                <strong>📱 Streaming:</strong><br>
                                <span class="fs-5 text-success"><?= date('d/m/Y', strtotime($movie['Movie_StreamingDate'])) ?></span>
                            </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-4">
                            <h5 class="fw-bold text-dark mb-3">📖 Mô tả:</h5>
                            <p class="lead text-muted lh-lg"><?= nl2br(htmlspecialchars($movie['Movie_Description'] ?: 'Không có mô tả')) ?></p>
                        </div>
                        
                        <?php if ($movie['Account_img'] && $movie['Username']): ?>
                        <div class="d-flex align-items-center border-top pt-4">
                            <img src="uploads/<?= htmlspecialchars($movie['Account_img']) ?>" 
                                 class="rounded-circle me-3" style="width: 50px; height: 50px;" alt="">
                            <div>
                                <strong>Đăng bởi: <?= htmlspecialchars($movie['Username']) ?></strong>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- CHARACTERS -->
    <div class="col-lg-4">
        <div class="card shadow-xl border-0 h-100 overflow-hidden" style="border-radius: 24px; background: rgba(255,255,255,0.95);">
            <div class="card-body p-4">
                <h4 class="fw-bold mb-4 pb-2 border-bottom">👥 Diễn viên</h4>
                
                <?php if (empty($characters)): ?>
                <div class="text-center py-4 text-muted">
                    <i class="fas fa-users fa-3x mb-3 opacity-50"></i>
                    <p>Chưa có thông tin diễn viên</p>
                </div>
                <?php else: ?>
                    <?php foreach ($characters as $char): ?>
                    <div class="d-flex align-items-center p-3 border-bottom last:border-b-0 hover:bg-gray-50 rounded-lg cursor-pointer">
                        <div class="w-12 h-12 bg-gradient-primary rounded-full flex items-center justify-center me-3 flex-shrink-0">
                            <span class="text-white font-bold text-lg"><?= strtoupper(substr($char['Character_Name'] ?? $char['Actor_Name'], 0, 1)) ?></span>
                        </div>
                        <div>
                            <div class="font-semibold text-gray-900"><?= htmlspecialchars($char['Character_Name'] ?? 'N/A') ?></div>
                            <div class="text-sm text-gray-600"><?= htmlspecialchars($char['Actor_Name']) ?></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Back Button -->
<div class="text-center">
    <a href="index.php?controller=movie" class="btn btn-outline-primary btn-lg px-5 py-3 shadow-lg">
        <i class="fas fa-arrow-left me-2"></i>Quay lại danh sách phim
    </a>
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
}
.hover\:bg-gray-50:hover {
    background-color: #f9fafb !important;
}
.last\:border-b-0:last-child {
    border-bottom: none !important;
}
.cursor-pointer {
    cursor: pointer;
}
.shadow-xl {
    box-shadow: 0 20px 25px -5px rgba(0, 0,0, 0.1), 0 10px 10px -5px rgba(0, 0,0, 0.04) !important;
}
</style>

<?php endif; ?>