<div class="art-container">
    <div class="art-wrapper">
        @include('Content::template.img_social', ['picture' => $picture, 'activeLink' => true])
        @if (!empty(session('is_admin')))
            <span class="badge badge-secondary">
                        {{ $picture->id }}
                    </span>
        @endif
        @if ($picture->tags->count())
            @include('Content::template.tag_list', ['tags' => $picture->tags])
        @endif
    </div>
</div>