<?php

namespace Modules\Category\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Category\Entities\Category;

class CategorySeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $category = new Category();
        $category->fill([
            'name' => 'Bất động sản',
            'code' => 'dbs-01',
            'slug' => 'bat-dong-san'
        ]);
        $category->save();

        $category = new Category();
        $category->fill([
            'name' => 'Xe cộ',
            'code' => 'xc-02',
            'slug' => 'xe-co'
        ]);
        $category->save();

        $category = new Category();
        $category->fill([
            'name' => 'Đồ điện tử',
            'code' => 'ddt-01',
            'slug' => 'do-dien-tu'
        ]);
        $category->save();

        $category = new Category();
        $category->fill([
            'name' => 'Đồ điện tử',
            'code' => 'ddt-01',
            'slug' => 'do-dien-tu'
        ]);
        $category->save();
    }
}
