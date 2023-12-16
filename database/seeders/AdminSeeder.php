<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        #測試管理員帳號
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => 'password',
            'sex' => '男',
            'birthday' => '2023/11/27',
            'phone' => '0987654321',
            'address' => 'Taiwan',
        ])->each(function ($user) {
            // 創建相對應的管理員資料
            Admin::create([
                'user_id' => $user->id,
                'position' => 1, // 預設管理員的等級為1
            ]);
        });
    }
}
