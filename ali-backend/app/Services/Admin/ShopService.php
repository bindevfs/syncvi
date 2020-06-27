<?php


namespace App\Services\Admin;

use App\Repositories\OrderRepository;
use App\Repositories\ShopRepository;
use App\Repositories\ShopUserRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ShopService
{
    protected $shopRepo;

    protected $shopUserRepo;

    protected $orderRepo;

    public function __construct(ShopRepository $shopRepo, ShopUserRepository $shopUserRepo, OrderRepository $orderRepo)
    {
        $this->shopRepo = $shopRepo;
        $this->shopUserRepo = $shopUserRepo;
        $this->orderRepo = $orderRepo;
    }

    public function manageShop()
    {
        $shops = $this->shopRepo->allBuilder()->paginate(10);
        foreach ($shops as $shop)
        {
            $shop->numberOrder = $this->orderRepo->countOrderForShop($shop->id);
            $shop->numberShopUser = $this->shopUserRepo->countShopUser($shop->id);
        }
        return array('status' => true, 'shops' => $shops);
    }

    public function manageNewShop()
    {
        $newshops = $this->shopRepo->newShop()->paginate(10);
        foreach ($newshops as $newshop)
        {
            $newshop->numberOrder = $this->orderRepo->countOrderForShop($newshop->id);
            $newshop->numberShopUser = $this->shopUserRepo->countShopUser($newshop->id);
        }
        return array('status' => true, 'newshops' => $newshops);
    }

    public function disableShop(Request $request)
    {
        if($request['shop_id']) {
            $shop_id = $request['shop_id'];
            $shop = $this->shopRepo->find($shop_id);
            $shopUsers = $this->shopUserRepo->findByField('shop_id',$shop_id);
            if($shop->deleted_at == null) {
                foreach($shopUsers as $shopUser) {
                    $dataShopUser = [
                        'deleted_at' => Carbon::now(),
                    ];
                    $this->shopUserRepo->update($dataShopUser,$shopUser->id);
                }
                $data = [
                    'deleted_at' => Carbon::now(),
                ];
            }
            else {
                foreach ($shopUsers as $shopUser) {
                    $dataShopUser = [
                        'deleted_at' => null,
                    ];
                    $this->shopUserRepo->update($dataShopUser,$shopUser->id);
                }
                $data = [
                    'deleted_at' => null,
                ];
            }
            $this->shopRepo->update($data,$shop->id);
            return array('status' => true, 'shop' => $shop);
        }
    }

    public function filterShop(Request $request)
    {
        $role = $request['role'];
        $search = $request['search'];
        $sort = $request['sort'];
        $option = $request['option'];
        $perpage = $request['perpage'];
        $page = $request['page'];
        $data = $this->shopRepo->searchShop($role,$search,$sort,$option,$perpage,$page);
        while ($data->count() == 0 && $page > 1) {
            $page--;
            $data = $this->shopRepo->searchShop($role,$search,$sort,$option,$perpage,$page);
        }
        $total_row = $data->count();
        if($total_row > 0) {
            foreach ($data as $shop)
            {
                $shop->numberOrder = $this->orderRepo->countOrderForShop($shop->id);
                $shop->numberShopUser = $this->shopUserRepo->countShopUser($shop->id);
            }
            $output = view('admin.shops.render')->with('shops', $data)->render();
        } else {
            $output = '<h2>Not found</h2>';
        }
        $data = array(
            'page_current' => $page,
            'table_data' => $output,
            'total_data' => $total_row
        );
        return array('status' => true, 'data' => $data);
    }
}
