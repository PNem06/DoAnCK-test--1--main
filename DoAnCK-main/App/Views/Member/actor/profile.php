<div class="row mb-4">
    <div class="col-12">
        <a href="index.php?controller=actor" class="btn btn-outline-light mb-3">
            <i class="fas fa-arrow-left me-2"></i>Quay lại danh sách
        </a>
        <h1 class="text-white mb-4"><?= htmlspecialchars($actor->Actor_Name ?? 'N/A') ?></h1>
    </div>
</div>

<div class="row">
    <!-- Sidebar info -->
    <div class="col-lg-4 mb-4">
        <div class="card hover-shadow">
            <div class="card-img-top position-relative" style="height: 400px;">
                <img src="https://via.placeholder.com/400x400/764ba2/ffffff?text=<?= urlencode($actor->Actor_Name) ?>" 
                     class="w-100 h-100 object-fit-cover" alt="<?= htmlspecialchars($actor->Actor_Name) ?>">
            </div>
            <div class="card-body">
                <h5 class="card-title fw-bold"><?= htmlspecialchars($actor->Actor_Name) ?></h5>
                <ul class="list-unstyled">
                    <li><i class="fas fa-id-badge me-2 text-info"></i>ID: <?= $actor->Actor_ID ?></li>
                    <?php if ($actor->Actor_Social): ?>
                    <li><i class="fas fa-link me-2 text-primary"></i>
                        <a href="<?= htmlspecialchars($actor->Actor_Social) ?>" target="_blank"><?= htmlspecialchars($actor->Actor_Social) ?></a>
                    </li>
                    <?php endif; ?>
                    <?php if ($actor->Character_ID): ?>
                    <li><i class="fas fa-mask me-2 text-warning"></i>Character ID: <?= $actor->Character_ID ?></li>
                    <?php endif; ?>
                </ul>
                <span class="badge bg-primary">
                    <i class="fas fa-film me-1"></i><?= !empty($movies) ? count($movies) : 0 ?> phim
                </span>
            </div>
        </div>
    </div>

    <!-- Actor_Info = Tiểu sử -->
    <div class="col-lg-8 mb-4">
        <div class="card hover-shadow h-100">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-book me-2"></i>Tiểu sử</h5>
            </div>
            <div class="card-body">
                <?php if ($actor->Actor_Info): ?>
                    <?= nl2br(htmlspecialchars($actor->Actor_Info)) ?>
                <?php else: ?>
                    <p class="text-muted">Chưa có thông tin.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Movies list -->
<?php if (!empty($movies)): ?>
<div class="row mt-4">
    <div class="col-12">
        <h3 class="text-white mb-4"><i class="fas fa-film me-2 text-warning"></i>Phim tham gia</h3>
    </div>
    <div class="row g-3">
        <?php foreach (array_slice($movies, 0, 12) as $movie): ?>
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="card h-100 hover-shadow" style="height: 250px;">
                <img src="uploads/movies/<?= $movie->Movie_Img ?? 'default-poster.png' ?>" 
                     class="card-img-top h-75 object-fit-cover" 
                     alt="<?= htmlspecialchars($movie->Movie_Title) ?>"
                     onerror="this.src='https://via.placeholder.com/200x300/667eea/ffffff?text=Phim'">
                <div class="card-body p-2">
                    <h6 class="card-title mb-1"><?= htmlspecialchars(substr($movie->Movie_Title, 0, 25)) ?>...</h6>
                    <small class="text-muted"><?= $movie->Movie_ReleaseDate ?? 'N/A' ?></small>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>