<div class="art-container">
    <div class="art-wrapper">
        @include('Content::template.img_social', ['picture' => $picture, 'activeLink' => true])
        @if (!empty(session('is_admin')))
            <span class="badge badge-secondary">
                {{ $picture->id }}
            </span>
        @endif
        <div class="stack-grid-footer">
            <div class="stack-grid-tags d-inline-block" style="width: 88%">
                @if ($picture->tags->count())
                    @include('Content::template.tag_list', ['tags' => $picture->tags])
                @endif
            </div>
            <div class="stack-grid-external-link d-inline-block text-right" style="width: 10%; vertical-align: top; padding-top: 5px">
                <a href="{{ route('art', ['id' => $picture->id]) }}" target="_blank" title="Открыть в новом окне">
                    <span class="fa fa-external-link" ></span>
                </a>
            </div>
        </div>
    </div>
</div>