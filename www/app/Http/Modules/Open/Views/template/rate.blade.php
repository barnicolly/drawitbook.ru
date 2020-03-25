<div class="rate-container" data-id="{{ $pictureId }}">
    <button type="button" class="btn btn-link rate-button like" title="Нравится">
        <svg role="img" xmlns="http://www.w3.org/2000/svg" width="23" height="32" viewBox="0 0 23 32">
            <use xlink:href="{{ buildUrl('sprite.svg') . '#like' }}"></use>
        </svg>
    </button>
    <button type="button" class="btn btn-link rate-button dislike" title="Не нравится">
        <svg role="img" xmlns="http://www.w3.org/2000/svg" width="23" height="32" viewBox="0 0 23 32">
            <use xlink:href="{{ buildUrl('sprite.svg') . '#dislike' }}"></use>
        </svg>
    </button>
</div>
