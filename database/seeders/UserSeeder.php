<?php

//user seeder
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $users =
        [
            [
                'name' => 'Jane Doe',
                'email' => 'admin@gmail.com',
                'cnic' => '1214'
            ],

        ];

        foreach ($users as $user) {
            $model = new User();
            $model->name = $user['name'];
            $model->email = $user['email'];
            $model->cnic = $user['cnic'];
            $model->password = Hash::make('admin1');
            $model->save();
        }
    }
}
