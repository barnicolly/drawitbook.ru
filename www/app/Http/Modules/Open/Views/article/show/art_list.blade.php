@foreach($article->pictures as $key => $picture)
    @if (in_array($key, [2,7,12]))
        <div class="form-group">
            {!! loadAd('integrate_article_' . $key) !!}
        </div>
    @endif
    <div class="form-group article-art-container">
        <span class="numeric badge badge-dark">
        <?= ++$key ?>
        </span>
        @include('Open::template.img_social', ['picture' => $picture, 'isArticle' => true])
    </div>
@endforeach