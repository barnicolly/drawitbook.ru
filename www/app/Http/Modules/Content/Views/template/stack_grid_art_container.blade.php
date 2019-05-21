<div class="art-container">
    <div class="art-wrapper">
        @include('Content::template.img_social', ['picture' => $picture, 'activeLink' => true])
        @if (!empty(session('is_admin')))
            <div class="admin-panel" data-picture-id="{{ $picture->id }}">
                <i class="art-control d-inline-block">
                    <div class="dropdown d-inline-block art-control-dropdown">
                        <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown"></button>
                        <div class="dropdown-menu"></div>
                    </div>
                    <div class="d-inline-block art-control-icons">
                        @if ((int) $picture->in_vk_posting === ON_VK_POSTING)
                            <span class="vk-posting fa fa-vk " title="Учавствует в постинге VK"></span>
                        @endif
                    </div>
                </i>
                <div class="d-inline-block  pull-right">
                    <i class="badge badge-secondary">
                        {{ $picture->id }}
                    </i>
                </div>
            </div>
        @endif
        <div class="stack-grid-footer">
            <div class="stack-grid-tags d-inline-block" style="width: 88%">
                @if ($picture->tags->count())
                    @include('Content::template.tag_list', ['tags' => $picture->tags, 'showAllTags' => $showAllTags])
                @endif
            </div>
            <div class="stack-grid-external-link d-inline-block text-right"
                 style="width: 10%; vertical-align: top; padding-top: 5px">
                <a itemprop="url" href="{{ route('art', ['id' => $picture->id]) }}" rel="nofollow" target="_blank"
                   title="Открыть в новом окне">
                    <span class="fa fa-external-link"></span>
                </a>
            </div>
        </div>
    </div>
</div>