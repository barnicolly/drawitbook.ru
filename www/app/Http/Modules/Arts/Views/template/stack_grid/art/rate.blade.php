<div class="rate-control" data-id="{{ $artId }}">
    <button type="button" class="btn btn-link rate-control__btn like" title="{{ __('common.button.like') }}">
        <svg class="rate-control__icon" role="img" width="23" height="32" viewBox="0 0 23 32">
            <use xlink:href="{{ getUrlFromManifest('icons/sprite.svg') . '#like' }}"></use>
        </svg>
    </button>
    <button type="button" class="btn btn-link rate-control__btn dislike" title="{{ __('common.button.dislike') }}">
        <svg class="rate-control__icon" role="img" width="23" height="32" viewBox="0 0 23 32">
            <use xlink:href="{{ getUrlFromManifest('icons/sprite.svg') . '#dislike' }}"></use>
        </svg>
    </button>
</div>
