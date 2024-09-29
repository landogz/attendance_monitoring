<?php
namespace Database\Seeders;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\SmsApi;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
         \App\Models\User::factory()->create([
             'name' => 'Test User',
             'email' => 'rolan.benavidez@gmail.com',
             'password' => Hash::make('adminadmin'),
         ]);

         \App\Models\User::factory()->create([
            'name' => 'Test Teacher',
            'email' => 'test.benavidez@gmail.com',
            'password' => Hash::make('adminadmin'),
            'Privilege' => 'Teacher',
            'Grade' => '10',
        ]);
         \App\Models\SmsApi::factory()->create([
            'api' => 'c1d909607695c49ac323271b916f864d',
            'account_id' => '37823',
            'account_name' => 'Landogz Web Solutions',
            'status' => 'Active',
            'credit_balance' => '957',
            'active' => 'Inactive',
        ]);
    }
}
