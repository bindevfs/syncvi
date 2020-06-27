<?php


namespace App\Services\Admin;

use App\Repositories\ShopRepository;
use App\Repositories\ShopUserRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ShopUserService
{
    protected $shopUserRepo;

    protected $shopRepo;

    public function __construct(ShopUserRepository $shopUserRepo, ShopRepository $shopRepo)
    {
        $this->shopUserRepo = $shopUserRepo;
        $this->shopRepo = $shopRepo;
    }

    public function manageShopUser(Request $request)
    {
        if($request['shop_id']) {
            $shop_id = $request['shop_id'];
            $shop = $this->shopRepo->find($shop_id);
            $newShopUsers = $this->shopUserRepo->newShopUser($shop_id)->paginate(10);
            $shopUsers = $this->shopUserRepo->allBuilder($shop_id)->paginate(10);
            if($shopUsers->count() > 0) {
                return array('status' => true, 'newShopUsers' => $newShopUsers, 'shopUsers' => $shopUsers, 'shop' => $shop,);
            } else return array('status' => false);
        }
    }

    public function disableShopUser(Request $request)
    {
        $shopuser_id = $request['shopuser_id'];
        $shopuser = $this->shopUserRepo->find($shopuser_id);
        if($shopuser->deleted_at == null) {
            $data = [
                'deleted_at' => Carbon::now(),
            ];
        }
        else {
            $data = [
                'deleted_at' => null,
            ];
        }
        $this->shopUserRepo->update($data,$shopuser->id);
        return array('status' => true, 'shopuser' => $shopuser);
    }
}
