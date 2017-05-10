<?php

use Illuminate\Database\Seeder;

class LinksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data =[
            [
            'link_name' => 'wangwei',
            'link_title' => 'wangwei',
            'link_url' => 'wangwei.com',
            'link_order' => '1',
             ],
            [
                'link_name' => 'wangwei1',
                'link_title' => 'wangwei1',
                'link_url' => 'wangwei1.com',
                'link_order' => '2',
            ],
        ];
        DB::table('links')->insert($data);

    }
}
