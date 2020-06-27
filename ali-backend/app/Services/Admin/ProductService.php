<?php


namespace App\Services\Admin;

use App\Repositories\ProductRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProductService
{
    protected $productRepo;

    public function __construct(ProductRepository $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    public function manageProduct()
    {
        $products = $this->productRepo->allBuilder()->paginate(10);
        return array('status' => true,'products' => $products);
    }

    public function manageNewProduct()
    {
        $newproducts = $this->productRepo->newProduct()->paginate(10);
        return array('status' => true,'newproducts' => $newproducts);
    }

    public function disableProduct(Request $request)
    {
        if($request['product_id']) {
            $product_id = $request['product_id'];
            $product = $this->productRepo->find($product_id);
            if($product->deleted_at == null) {
                $data = [
                    'deleted_at' => Carbon::now(),
                ];
            }
            else {
                $data = [
                    'deleted_at' => null,
                ];
            }
            $this->productRepo->update($data,$product->id);
            return array('status' => true,'product' => $product);
        }
    }
}
