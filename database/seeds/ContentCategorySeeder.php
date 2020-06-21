<?php

use App\ContentCategory;
use Illuminate\Database\Seeder;

class ContentCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect(['Video', 'Images', 'Documents', 'Audio', 'YouTube or Vimeo Link'])->map(function ($name) {

            factory(ContentCategory::class)->create([
                'name' => $name
            ]);
        });
    }
}
