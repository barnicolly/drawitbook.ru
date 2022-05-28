<div class="art-container" data-page="{{ $page ?? 1 }}">
    <div class="art-wrapper">
        @include('picture::template.stack_grid.art.img_social', ['art' => $art])
        @if (!empty(session('is_admin')))
            {{--            //TODO-misha выделить отдельно;--}}
            <div class="admin-panel" data-picture-id="{{ $art['id'] }}">
                <i class="art-control d-inline">
                    <div class="dropdown d-inline art-control-dropdown">
                        <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown"></button>
                        <div class="dropdown-menu"></div>
                    </div>
                    <div class="d-inline">
                        <button class="btn btn-link picture-settings" data-picture-id="{{ $art['id'] }}">
                            <span class="fa fa-cog"></span>
                        </button>
                    </div>
                    <div class="d-inline art-control-icons">
                        @if ((int) $art['in_vk_posting'] === ON_VK_POSTING)
                            <span class="vk-posting fa fa-vk " title="Учавствует в постинге VK"></span>
                        @endif
                    </div>
                </i>
                <div class="d-inline  pull-right">
                    <i class="badge badge-secondary">
                        {{ $art['id'] }}
                    </i>
                </div>
            </div>
        @endif
        <div class="stack-grid__footer">
            <div class="stack-grid__tags">
                @if (!empty($art['tags']))
                    @include('picture::template.stack_grid.art.tag_list', ['tags' => $art['tags']])
                @endif
            </div>
            <div class="stack-grid__external-link">
                <a itemprop="url" href="{{ Router::route('art', ['id' => $art['id']]) }}" rel="nofollow"
                   title="{{ __('common.button.open_in_new_window') }}">
                    <svg role="img" width="26" height="26" viewBox="0 0 26 26">
                        <use xlink:href="{{ getUrlFromManifest('icons/sprite.svg') . '#external-link' }}"></use>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>
