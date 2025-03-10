<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolerSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Role::firstOrCreate(['name' => 'admin']);
    Role::firstOrCreate(['name' => 'viewer']);
  }
}
