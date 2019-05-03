@foreach($article->pictures as $picture)
    <div class="form-group">
        @include('Content::template.img_social', ['picture' => $picture, 'isArticle' => true])
    </div>
@endforeach