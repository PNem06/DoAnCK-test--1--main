$(document).ready(function() {
    let currentCategory = '';

    // Pagination AJAX (không reload trang)
    $('.pagination .page-link').click(function(e) {
        e.preventDefault();
        let page = $(this).data('page');
        let category = $(this).data('category') || '';
        
        loadNews(page, category);
        });
    });
    $(document).ready(function() {
    // Pagination AJAX
    $(document).on('click', '.pagination .page-link', function(e) {
        e.preventDefault();
        let page = $(this).data('page');
        let category = $(this).data('category') || '';
        loadNews(page, category);
    });

    // Add comment AJAX
    $('#commentForm').on('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        
        $.ajax({
            url: 'index.php?controller=home&action=addComment',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                let data = JSON.parse(response);
                if (data.success) {
                    $('#commentForm')[0].reset();
                    loadComments($('input[name="news_id"]').val());
                    alert(data.message);
                } else {
                    alert(data.message);
                }
            }
        });
    });

    // Search AJAX
    $('#searchForm').on('submit', function(e) {
        e.preventDefault();
        let keyword = $('#searchInput').val();
        if (keyword) {
            window.location.href = `index.php?controller=home&action=search&keyword=${encodeURIComponent(keyword)}`;
        }
    });
});

function loadNews(page = 1, category = '') {
    $.ajax({
        url: `index.php?controller=home&action=index&page=${page}&category=${category}`,
        method: 'GET',
        success: function(html) {
            $('#newsContainer').html($(html).find('#newsContainer').html());
            $('.pagination').html($(html).find('.pagination').html());
            window.scrollTo(0, 0);
        }
    });
}

function loadComments(newsId) {
    $.ajax({
        url: `index.php?controller=home&action=loadComments&id=${newsId}`,
        method: 'GET',
        success: function(response) {
            let comments = JSON.parse(response);
            let html = '';
            comments.forEach(comment => {
                html += `
                    <div class="comment-item mb-3 p-3 border rounded">
                        <div class="d-flex align-items-start">
                            <img src="uploads/${comment.Account_img || 'default.png'}" 
                                 class="rounded-circle me-3" width="50" height="50">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">${comment.Username}</h6>
                                <p class="mb-1">${comment.Comment_Data}</p>
                                <small class="text-muted">${new Date(comment.Comment_Date).toLocaleString('vi-VN')}</small>
                            </div>
                        </div>
                    </div>
                `;
            });
            $('#commentsList').html(html);
        }
    });
}