@foreach($article->pictures as $key => $picture)
    <div class="form-group article-art-container">
        <span class="numeric badge badge-dark">
        <?= ++$key ?>
        </span>
        @include('Content::template.img_social', ['picture' => $picture, 'isArticle' => true])
    </div>
@endforeach