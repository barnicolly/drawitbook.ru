export function initArtControls($artControls) {
    if ($artControls.length) {
        $artControls.each(function () {
            $(this).customArtControl('init');
        });
    }
}
