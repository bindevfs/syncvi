<?php

namespace App\Services\Shop\Product;

use App\Entities\Product;
use App\Notifications\ProductNoti;
use App\Repositories\GalleryRepository;
use App\Repositories\OrderProductRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use App\Repositories\ShopRepository;
use App\Repositories\ShopUserRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class ProductService
{
    protected $userRepo;

    protected $productRepo;

    protected $orderProductRepo;

    protected $orderRepo;

    protected $shopRepo;

    protected $galleryRepo;

    protected $shopUserRepo;

    public function __construct(UserRepository $userRepo, ProductRepository $productRepo, OrderProductRepository $orderProductRepo,
                                OrderRepository $orderRepo, ShopRepository $shopRepo, GalleryRepository $galleryRepo, ShopUserRepository $shopUserRepo)
    {
        $this->userRepo = $userRepo;
        $this->productRepo = $productRepo;
        $this->orderProductRepo = $orderProductRepo;
        $this->orderRepo = $orderRepo;
        $this->shopRepo = $shopRepo;
        $this->galleryRepo = $galleryRepo;
        $this->shopUserRepo = $shopUserRepo;
    }

    public function requestedProduct(Request $request)
    {
        $user = auth('web_shop_users')->user();
        if(!$user) {
            $user = auth('shop_users')->user();
        }
        if(!$user) {
            return array('status' => false);
        }
        $shop_id = $user->shop_id;

        $orderProducts = $this->orderProductRepo->orderProductRequestingOfShop($shop_id)->get();
        $listIdProducts = array();
        //dd($orderProducts);
        foreach ($orderProducts as $orderProduct)
        {
            $isChecked[$orderProduct->product_id] = 1;
            $isGood[$orderProduct->product_id] = 0;
            $countProduct[$orderProduct->product_id] = 0;
            $priceProduct[$orderProduct->product_id] = 0;
            $listIdProducts[] = $orderProduct->product_id;
        }
        foreach ($orderProducts as $orderProduct)
        {
            if($orderProduct->status == 0) {
                $isChecked[$orderProduct->product_id] = 0;
            }
            if($orderProduct->status == 1) {
                $isGood[$orderProduct->product_id] += $orderProduct->quality;
            }
            $countProduct[$orderProduct->product_id] += $orderProduct->quality;
            $priceProduct[$orderProduct->product_id] = max($priceProduct[$orderProduct->product_id], $orderProduct->price);
        }
        //dd($listIdProducts);
        $products = $this->productRepo->whereIn('id', $listIdProducts)->paginate(10);
        foreach ($products as $product)
        {
            $product->quality = $countProduct[$product->id];
            $product->price = $priceProduct[$product->id];
            $product->isChecked = $isChecked[$product->id];
            $product->quali = $isGood[$product->id];
        }
        $shop = $this->shopRepo->findByField('id', $shop_id)->first();
        return array('status' => true, 'products' => $products, 'shop' => $shop);
    }

    public function detailRepo(Request $request)
    {
        $user = auth('web_shop_users')->user();
        if(!$user) {
            $user = auth('shop_users')->user();
        }
        if(!$user) {
            return array('status' => false);
        }
        $shop_id = $user->shop_id;

        $product_id = $request['product_id'];
        $product = $this->productRepo->findByField('id', $product_id)->first();
        if(!$product) {
            return array('status' => false);
        }
        $orderProducts = $this->orderProductRepo->findAllOrderOfProduct($product_id, $shop_id)->get();
        foreach ($orderProducts as $orderProduct)
        {
            $orderProduct->order = $this->orderRepo->find($orderProduct->order_id);
        }
        return array('status' => true, 'orderProducts' => $orderProducts, 'product' => $product);
    }

    public function updateStatusOrderProduct(Request $request)
    {
        $orp_id = $request['order_product_id'];
        $status = $request['status'];
        $orp = $this->orderProductRepo->findByField('id', $orp_id)->first();
        if( (!$orp) || ($status === '') ) return array('status' => false);
        $this->orderProductRepo->update(['status' => $status], $orp_id);
        return array('status' => true);
    }

    public function addProduct(Request $request)
    {
        $user = auth('web_shop_users')->user();
        if(!$user) {
            $user = auth('shop_users')->user();
        }
        if(!$user) {
            return array('status' => false);
        }
        $shop_id = $user->shop_id;
        $shop = $this->shopRepo->findByField('id', $shop_id)->first();

        $product_key = $request['product_key'];
        if($product_key == null) {
            $product_key = random_int(100000000000,999999999999);
        }
        $product_name = $request['product_name'];
        $thumbnails = $request['thumbnails'];
        $cost = $request['cost'];
        $sell_price = $request['sell_price'];
        $resource = $shop->name;
        $description = $request['description'];

        $product = $this->productRepo->create([
           'product_key' => $product_key,
           'thumbnails' => $thumbnails,
           'product_name' => $product_name,
           'cost' => $cost,
           'sell_price' => $sell_price,
           'resource' => $resource,
           'description' => $description,
           'shop_id' => $shop_id
        ]);

        $image = $request['image'];
        $video = $request['video'];
        if(!is_array($image)) {
            if($image !== null || $image == '') {
                $image = array();
            } else {
                $image = array($image);
            }
        }
        if(!is_array($video)) {
            if($video !== null || $video == '') {
                $video = array();
            } else {
                $video = array($video);
            }
        }
        $gallery = $this->galleryRepo->create([
            'image' => serialize($image),
            'video' => serialize($video),
            'product_id' => $product->id
        ]);
        $shopuser = $this->shopUserRepo->findByField('shop_id', $shop_id);
        Notification::send($shopuser, new ProductNoti($user, $product, 'create product'));
        return array('status' => true, 'product' => $product, 'gallery' => $gallery);
    }

    public function listProduct(Request $request)
    {
        $user = auth('web_shop_users')->user();
        if(!$user) {
            $user = auth('shop_users')->user();
        }
        if(!$user) {
            return array('status' => false);
        }
        $shop_id = $user->shop_id;
        $listProduct = $this->productRepo->allProduct($shop_id);
        return array('status' => true, 'listProduct' => $listProduct);
    }

    public function viewProduct(Request $request)
    {
        $user = auth('web_shop_users')->user();
        if(!$user) {
            $user = auth('shop_users')->user();
        }
        if(!$user) {
            return array('status' => false);
        }
        $shop_id = $user->shop_id;
        $product_id = $request['product_id'];
        $product = $this->productRepo->findByField('id', $product_id)->first();
        if($product == null) {
            return array('status' => false);
        }
        if($product->shop_id != $shop_id) {
            return array('status' => false);
        }
        $gallery = $this->galleryRepo->findByField('product_id',$product->id)->first();
        if($gallery !== null) {
            $product->image = unserialize($gallery->image);
            $product->video = unserialize($gallery->video);
        }
        return array('status' => true, 'product' => $product);
    }

    public function updateProduct(Request $request)
    {
        $user = auth('web_shop_users')->user();
        if(!$user) {
            $user = auth('shop_users')->user();
        }
        if(!$user) {
            return array('status' => false);
        }

        $shop_id = $user->shop_id;
        $product_id = $request['product_id'];
        $product = $this->productRepo->find($product_id);
        if($product === null) {
            return array('status' => false);
        }
        if($product->shop_id != $shop_id) {
            return array('status' => false);
        }

        $product_name = isset($request['product_name']) ? $request['product_name'] : $product->product_name;
        $cost = isset($request['cost']) ? $request['cost'] : $product->cost;
        $sell_price = isset($request['sell_price']) ? $request['sell_price'] : $product->sell_price;
        $description = isset($request['description']) ? $request['description'] : $product->description;
        $product = $this->productRepo->update([
            'product_name' => $product_name,
            'cost' => $cost,
            'sell_price' => $sell_price,
            'description' => $description,
        ], $product_id);

        $gallery = $this->galleryRepo->findByField('product_id', $product_id)->first();
        if ($gallery !== null) {
            $image = isset($request['image']) ? $request['image'] : $gallery->image;
            $video = isset($request['video']) ? $request['video'] : $gallery->video;
            if(!is_array($image)) {
                if($image !== null || $image == '') {
                    $image = array();
                } else {
                    $image = array($image);
                }
            }
            if(!is_array($video)) {
                if($video !== null || $video == '') {
                    $video = array();
                } else {
                    $video = array($video);
                }
            }
            $gallery = $this->galleryRepo->update([
                'image' => serialize($image),
                'video' => serialize($video),
            ], $gallery->id);
        }

        $shopuser = $this->shopUserRepo->findByField('shop_id', $shop_id);
        Notification::send($shopuser, new ProductNoti($user, $product, 'update product'));
        return array('status' => true, 'product' => $product, 'gallery' => $gallery);
    }

    public function filterProduct(Request $request)
    {
        $user = auth('web_shop_users')->user();
        if(!$user) {
            $user = auth('shop_users')->user();
        }
        if(!$user) {
            return array('status' => false);
        }
        $shop_id = $user->shop_id;
        $search = $request['search'];
        $price1 = $request['price1'];
        $price2 = $request['price2'];
        $date1 = $request['date1'];
        $date2 = $request['date2'];
        $perpage = isset($request['perpage']) ? $request['perpage'] : 10;
        $page = isset($request['page']) ? $request['page'] : 1;
        $data = $this->productRepo->searchProduct($shop_id, $search, $price1, $price2, $date1, $date2, $perpage, $page);
        if($data)
            foreach ($data as $product)
            {
                $gallery = $this->galleryRepo->findByField('product_id', $product->id)->first();
                if($gallery !== null) {
                    $product->image = unserialize($gallery->image);
                    $product->video = unserialize($gallery->video);
                }
            }
        while ($data->count() == 0 && $page > 1) {
            $page--;
            $data = $this->productRepo->searchProduct($shop_id, $search, $price1, $price2, $date1, $date2, $perpage, $page);
            if($data)
                foreach ($data as $product)
                {
                    $gallery = $this->galleryRepo->findByField('product_id', $product->id)->first();
                    if($gallery !== null) {
                        $product->image = unserialize($gallery->image);
                        $product->video = unserialize($gallery->video);
                    }
                }
        }
        $total_row = $data->count();
        return array('status' => true, 'page_current' => $page, 'products' => $data, 'total_data' => $total_row);
    }
}
