<div class="art-container">
    <div class="art-wrapper">
        @include('Open::template.img_social', ['picture' => $picture, 'activeLink' => true, 'tagged' => $tagged ?? false])
        @if (!empty(session('is_admin')))
            <div class="admin-panel" data-picture-id="{{ $picture->id }}">
                <i class="art-control d-inline">
                    <div class="dropdown d-inline art-control-dropdown">
                        <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown"></button>
                        <div class="dropdown-menu"></div>
                    </div>
                    <div class="d-inline">
                        <button class="btn btn-link picture-settings" data-picture-id="{{ $picture->id }}">
                            <span class="fa fa-cog"></span>
                        </button>
                    </div>
                    <div class="d-inline art-control-icons">
                        @if ((int) $picture->in_vk_posting === ON_VK_POSTING)
                            <span class="vk-posting fa fa-vk " title="Учавствует в постинге VK"></span>
                        @endif
                    </div>
                </i>
                <div class="d-inline  pull-right">
                    <i class="badge badge-secondary">
                        {{ $picture->id }}
                    </i>
                </div>
            </div>
        @endif
        <div class="stack-grid-footer">
            <div class="stack-grid-tags d-inline" style="width: 88%">
                @if ($picture->tags->count())
                    @include('Open::template.tag_list', ['tags' => $picture->tags, 'showAllTags' => $showAllTags])
                @endif
            </div>
            <div class="stack-grid-external-link d-inline text-right"
                 style="width: 10%; vertical-align: top; padding-top: 5px">
                <a itemprop="url" href="{{ route('art', ['id' => $picture->id]) }}" rel="nofollow" target="_blank"
                   title="Открыть в новом окне">
                    <svg role="img" width="20" height="20" viewBox="0 0 20 20">
                        <use xlink:href="{{ buildUrl('sprite.svg') . '#external-link' }}"></use>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>
