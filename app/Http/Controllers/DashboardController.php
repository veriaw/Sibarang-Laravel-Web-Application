<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        $inventories = Inventory::all();
        $totalTersedia = $inventories->sum('tersedia');
        $totalDipinjam = $inventories->sum('dipinjam');
        $totalHilang = $inventories->sum('hilang');
        return view('dashboard', compact('inventories', 'totalTersedia', 'totalDipinjam', 'totalHilang'));
    }

    public function addBarang(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'category' => 'required|in:Elektronik,Furniture,Alat Tulis,Lainnya',
            'tersedia' => 'required|integer|min:0',
            'dipinjam' => 'required|integer|min:0',
            'hilang' => 'required|integer|min:0',
        ]);

        Inventory::create([
            'name' => $request->name,
            'category' => $request->category,
            'tersedia' => $request->tersedia,
            'dipinjam' => $request->dipinjam,
            'hilang' => $request->hilang,
        ]);

        return redirect()->back()->with('success', 'Barang berhasil ditambahkan!');
    }

    public function updateBarang(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'category' => 'required|in:Elektronik,Furniture,Alat Tulis,Lainnya',
            'tersedia' => 'required|integer|min:0',
            'dipinjam' => 'required|integer|min:0',
            'hilang' => 'required|integer|min:0',
        ]);

        $inventory = Inventory::findOrFail($id);
        $inventory->update([
            'name' => $request->name,
            'category' => $request->category,
            'tersedia' => $request->tersedia,
            'dipinjam' => $request->dipinjam,
            'hilang' => $request->hilang,
        ]);

        return redirect()->back()->with('success', 'Barang berhasil diupdate!');
    }

    public function deleteBarang($id)
    {
        $inventory = Inventory::findOrFail($id);
        $inventory->delete();

        return redirect()->back()->with('success', 'Barang berhasil dihapus!');
    }
}
