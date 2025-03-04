<?php

namespace Database\Seeders;

use App\Constants\TypeConst;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ExpenseCategorySeeder extends Seeder
{
    public function run()
    {
        $type = TypeConst::EXPENSE;
        $expenseCategories = [
            ['name' => 'Alış-veriş', 'slug' => 'alis-veris', 'type' => $type, 'icon_code' => 'fa-solid fa-shopping-cart'],
            ['name' => 'Qida', 'slug' => 'qida', 'type' => $type, 'icon_code' => 'fa-solid fa-utensils'],
            ['name' => 'Telefon', 'slug' => 'telefon', 'type' => $type, 'icon_code' => 'fa-solid fa-mobile'],
            ['name' => 'Əyləncə', 'slug' => 'eylence', 'type' => $type, 'icon_code' => 'fa-solid fa-microphone'],
            ['name' => 'Təhsil', 'slug' => 'tehsil', 'type' => $type, 'icon_code' => 'fa-solid fa-book'],
            ['name' => 'Gözəllik', 'slug' => 'gozellik', 'type' => $type, 'icon_code' => 'fa-solid fa-spa'],
            ['name' => 'İdman', 'slug' => 'idman', 'type' => $type, 'icon_code' => 'fa-solid fa-dumbbell'],
            ['name' => 'Sosial', 'slug' => 'sosial', 'type' => $type, 'icon_code' => 'fa-solid fa-users'],
            ['name' => 'Nəqliyyat', 'slug' => 'neqliyyat', 'type' => $type, 'icon_code' => 'fa-solid fa-bus'],
            ['name' => 'Geyim', 'slug' => 'geyim', 'type' => $type, 'icon_code' => 'fa-solid fa-tshirt'],
            ['name' => 'Avtomobil', 'slug' => 'avtomobil', 'type' => $type, 'icon_code' => 'fa-solid fa-car'],
            ['name' => 'İçki', 'slug' => 'icki', 'type' => $type, 'icon_code' => 'fa-solid fa-glass-martini'],
            ['name' => 'Siqaret', 'slug' => 'siqaret', 'type' => $type, 'icon_code' => 'fa-solid fa-smoking'],
            ['name' => 'Elektronika', 'slug' => 'elektronika', 'type' => $type, 'icon_code' => 'fa-solid fa-plug'],
            ['name' => 'Səyahət', 'slug' => 'seyahat', 'type' => $type, 'icon_code' => 'fa-solid fa-plane'],
            ['name' => 'Sağlamlıq', 'slug' => 'saglamliq', 'type' => $type, 'icon_code' => 'fa-solid fa-heartbeat'],
            ['name' => 'Pet', 'slug' => 'pet', 'type' => $type, 'icon_code' => 'fa-solid fa-paw'],
            ['name' => 'Təmir', 'slug' => 'temir', 'type' => $type, 'icon_code' => 'fa-solid fa-tools'],
            ['name' => 'Mənzil', 'slug' => 'menzil', 'type' => $type, 'icon_code' => 'fa-solid fa-paint-roller'],
            ['name' => 'Mebel', 'slug' => 'mebel', 'type' => $type, 'icon_code' => 'fa-solid fa-couch'],
            ['name' => 'Hədiyyələr', 'slug' => 'hediyyeler', 'type' => $type, 'icon_code' => 'fa-solid fa-gift'],
            ['name' => 'Bağışlar', 'slug' => 'bagislar', 'type' => $type, 'icon_code' => 'fa-solid fa-heart'],
            ['name' => 'Lotereya', 'slug' => 'lotereya', 'type' => $type, 'icon_code' => 'fa-solid fa-ticket-alt'],
            ['name' => 'Qəlyanaltılar', 'slug' => 'qelyanaltilar', 'type' => $type, 'icon_code' => 'fa-solid fa-cookie'],
            ['name' => 'Uşaqlar', 'slug' => 'usaqlar', 'type' => $type, 'icon_code' => 'fa-solid fa-baby'],
            ['name' => 'Tərəvəzlər', 'slug' => 'terevezler', 'type' => $type, 'icon_code' => 'fa-solid fa-carrot'],
            ['name' => 'Meyvələr', 'slug' => 'meyveler', 'type' => $type, 'icon_code' => 'fa-solid fa-apple-alt'],
        ];

        foreach ($expenseCategories as $expenseCategory) {
            Category::updateOrCreate(['slug' => $expenseCategory['slug']], $expenseCategory);
        }
    }

}
