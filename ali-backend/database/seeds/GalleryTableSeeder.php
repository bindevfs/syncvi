<?php

use Illuminate\Database\Seeder;
use App\Entities\Gallery;

class GalleryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 1000000; $i++)
            Gallery::create([
                'image' => serialize(array("https://img.alicdn.com/imgextra/i3/263726286/TB2wgeTaSrqK1RjSZK9XXXyypXa_!!263726286.jpg_430x430q90.jpg")),
                'video' => serialize(array("https://www.youtube.com/watch?v=vgbrIy08e2w")),
                'product_id' => random_int(1,1000000),
            ]);
    }
}
