<?php

namespace Database\Seeders;

use App\Models\Inventory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Inventory::create([
            'name' => 'Laptop Dell XPS 13',
            'category' => 'Elektronik',
            'tersedia' => 10,
            'dipinjam' => 2,
            'hilang' => 1,
        ]);
    }
}
