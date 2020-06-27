<?php

namespace App\Presenters;

use App\Transformers\ShopTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ShopPresenter.
 *
 * @package namespace App\Presenters;
 */
class ShopPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ShopTransformer();
    }
}
