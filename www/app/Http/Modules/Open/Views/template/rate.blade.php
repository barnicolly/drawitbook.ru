<div class="rate-container" data-id="{{ $pictureId }}">
    <button type="button" class="btn btn-link rate-button like" title="Нравится">
        <svg role="img" width="23" height="32" viewBox="0 0 23 32">
            <use xlink:href="{{ getUrlFromManifest('icons/sprite.svg') . '#like' }}"></use>
        </svg>
    </button>
    <button type="button" class="btn btn-link rate-button dislike" title="Не нравится">
        <svg role="img" width="23" height="32" viewBox="0 0 23 32">
            <use xlink:href="{{ getUrlFromManifest('icons/sprite.svg') . '#dislike' }}"></use>
        </svg>
    </button>
</div>
