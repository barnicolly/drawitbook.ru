<div class="stack-grid">
    @foreach($pictures as $index => $picture)
        @if(in_array($index, [5, 12, 18], true))
            <div class="art-container">
                <div class="art-wrapper clearfix">
                    {!! loadAd('integrated-' . $index) !!}
                    <div>
                        <span class="ad-label float-right">Реклама</span>
                    </div>
                </div>
            </div>
        @endif
        @include('Content::template.stack_grid_art_container', ['picture' => $picture])
    @endforeach
</div>
<div class="form-group">
    {!! loadAd('after_first_stack') !!}
</div>