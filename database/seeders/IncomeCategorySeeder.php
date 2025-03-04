<?php

namespace Database\Seeders;

use App\Constants\TypeConst;
use App\Models\Category;
use Illuminate\Database\Seeder;

class IncomeCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $type = TypeConst::INCOME;
        $incomeCategories = [
            [
                'name' => 'Maaş',
                'slug' => 'maash',
                'type' => $type,
                'icon_code' => "fa-solid fa-money-check"
            ],
            [
                'name' => 'İnvestisialar',
                'slug' => 'investisialar',
                'type' => $type,
                'icon_code' => "fa-solid fa-sack-dollar"
            ],
            [
                'name' => 'Yarımştat',
                'slug' => 'yarimstat',
                'type' => $type,
                'icon_code' => "fa-solid fa-business-time"
            ],
            [
                'name' => 'Mükafatlar',
                'slug' => 'mukafatlar',
                'type' => $type,
                'icon_code' => "fa-solid fa-gift"
            ],
            [
                'name' => 'Digərləri',
                'slug' => 'digerleri',
                'type' => $type,
                'icon_code' => "fa-solid fa-arrows-to-dot"
            ],
        ];

        foreach ($incomeCategories as $incomeCategory) {
            Category::updateOrCreate(['slug' => $incomeCategory['slug']], $incomeCategory);
        }
    }
}
