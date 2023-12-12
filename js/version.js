"use strict";

document.addEventListener('DOMContentLoaded', function () {
    const $versionButton = $('#version-info');
    if ($versionButton) {
        const options = {
            html: true,
            placement: 'bottom',
            trigger: 'hover',
            container: 'body'
        };
        $versionButton.popover(options);
    }
}, false);
