<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Gallery;

/**
 * Class GalleryTransformer.
 *
 * @package namespace App\Transformers;
 */
class GalleryTransformer extends TransformerAbstract
{
    /**
     * Transform the Gallery entity.
     *
     * @param \App\Entities\Gallery $model
     *
     * @return array
     */
    public function transform(Gallery $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
