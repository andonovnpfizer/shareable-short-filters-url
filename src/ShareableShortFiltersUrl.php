<?php

namespace Andonovnpfizer\ShareableShortFiltersUrl;

use Laravel\Nova\Card;

class ShareableShortFiltersUrl extends Card
{
    /**
     * The width of the card (1/3, 1/2, or full).
     *
     * @var string
     */
    public $width = 'full';

    /**
     * The height strategy of the card (fixed or dynamic).
     *
     * @var string
     */
    public $height = 'dynamic';

    /**
     * Get the component name for the element.
     *
     * @return string
     */
    public function component()
    {
        return 'shareable-short-filters-url';
    }
}
