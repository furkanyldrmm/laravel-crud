<?php

namespace App\Transformers;

use App\Models\Product;
use Illuminate\Support\Carbon;
use League\Fractal\TransformerAbstract;

class ProductTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected array $defaultIncludes = [
        //
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected array $availableIncludes = [
        //
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Product $product)
    {
        return [
            'id'=>$product->id,
            'picture'=>$product->picture,
            'created_at'=>Carbon::parse($product->created_at)->format('d-m-Y'),
            'updated_at'=>Carbon::parse($product->updated_at)->format('d-m-Y')
        ];
    }
}
