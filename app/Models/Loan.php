<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $fillable = [
        'peminjam',
        'status',
        'lama_pinjam',
        'jumlah_barang',
        'inventory_id',
    ];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
}
