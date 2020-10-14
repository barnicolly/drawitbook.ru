<div class="rate-control" data-id="{{ $pictureId }}">
    <button type="button" class="btn btn-link rate-control__btn like" title="Нравится">
        <svg class="rate-control__svg" role="img" width="23" height="32" viewBox="0 0 23 32">
            <use xlink:href="{{ getUrlFromManifest('icons/sprite.svg') . '#like' }}"></use>
        </svg>
    </button>
    <button type="button" class="btn btn-link rate-control__btn dislike" title="Не нравится">
        <svg class="rate-control__svg" role="img" width="23" height="32" viewBox="0 0 23 32">
            <use xlink:href="{{ getUrlFromManifest('icons/sprite.svg') . '#dislike' }}"></use>
        </svg>
    </button>
</div>
