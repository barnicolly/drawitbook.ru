<div id="article-pictures">
    <button type="button" class="btn btn-sm btn-link add-picture form-group" <?= (empty($article)) ? 'disabled' : '' ?>>
        Добавить
    </button>
    <table class="table table-sm">
        <thead>
        <th>#</th>
        <th>sort</th>
        <th>Caption</th>
        <th></th>
        <th></th>
        </thead>
        <tbody id="article-pictures-body">
        @include('Admin::article.show.article_pictures_body', ['article' => !empty($article) ? $article : []])
        </tbody>
    </table>
</div>