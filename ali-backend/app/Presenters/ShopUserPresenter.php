<?php

namespace App\Presenters;

use App\Transformers\ShopUserTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ShopUserPresenter.
 *
 * @package namespace App\Presenters;
 */
class ShopUserPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ShopUserTransformer();
    }
}
