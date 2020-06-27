<?php

namespace App\Presenters;

use App\Transformers\GalleryTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class GalleryPresenter.
 *
 * @package namespace App\Presenters;
 */
class GalleryPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new GalleryTransformer();
    }
}
