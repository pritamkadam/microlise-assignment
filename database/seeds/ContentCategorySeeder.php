<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContentCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dateTime = Carbon::now();

        DB::table('content_category')->insert([
            [
                'name' => 'Video',
                'created_at' => $dateTime,
                'updated_at' => $dateTime
            ],
            [
                'name' =>
                'Images',
                'created_at' => $dateTime,
                'updated_at' => $dateTime
            ],
            [
                'name' =>
                'Documents',
                'created_at' => $dateTime,
                'updated_at' => $dateTime
            ],
            [
                'name' =>
                'Audio',
                'created_at' => $dateTime,
                'updated_at' => $dateTime
            ],
            [
                'name' =>
                'YouTube or Vimeo Link',
                'created_at' => $dateTime,
                'updated_at' => $dateTime
            ]
        ]);
    }
}
