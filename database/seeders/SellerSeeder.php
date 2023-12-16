<?php

namespace Database\Seeders;

use App\Models\Seller;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SellerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        #測試賣家帳號
        User::factory()->create([
            'name' => 'seller',
            'email' => 'seller@gmail.com',
            'password' => 'password',
            'sex' => '男',
            'birthday' => '2023/11/11',
            'phone' => '0987654321',
            'address' => 'Taoyuan',
        ])->each(function ($user) {
            // 創建相對應的管理員資料
            Seller::create([
                'user_id' => $user->id,
                'status' => 3, // 預設賣家為尚未審核
            ]);
        });
    }
}
