<?php

namespace Alilor\FacebookPixel;

use Illuminate\View\View;

/**
 * Class ScriptViewCreator
 * @package Alilor\FacebookPixel
 */
class ScriptViewCreator
{
    /**
     * @var FacebookPixel
     */
    protected $FacebookPixel;

    /**
     * ScriptViewCreator constructor.
     * @param FacebookPixel $FacebookPixel
     */
    public function __construct(FacebookPixel $FacebookPixel)
    {
        $this->FacebookPixel = $FacebookPixel;
    }

    /**
     * @param View $view
     */
    public function create(View $view)
    {
        $view->with('enabled', $this->FacebookPixel->isEnabled())
            ->with('nonce', $this->FacebookPixel->getCspNonceCallback())
            ->with('pixel_ids', $this->FacebookPixel->pixel_ids());
    }
}
