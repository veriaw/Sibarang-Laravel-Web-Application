<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Loan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function index() {
        $loans = Loan::with('inventory')->get();
        $inventories = Inventory::all();
        return view('loan', compact('loans', 'inventories'));
    }

    public function addLoan(Request $request)
    {
        $request->validate([
            'peminjam' => 'required|string',
            'status' => 'required|string',
            'lama_pinjam' => 'required|integer|min:1',
            'jumlah_barang' => 'required|integer|min:1',
            'inventory_id' => 'required|exists:inventories,id',
        ]);

        // Ambil inventory terkait
        $inventory = Inventory::findOrFail($request->inventory_id);

        // Update stok: tersedia berkurang, dipinjam bertambah
        $inventory->tersedia -= $request->jumlah_barang;
        $inventory->dipinjam += $request->jumlah_barang;
        $inventory->save();

        Loan::create([
            'peminjam' => $request->peminjam,
            'status' => $request->status,
            'lama_pinjam' => $request->lama_pinjam,
            'jumlah_barang' => $request->jumlah_barang,
            'inventory_id' => $request->inventory_id,
        ]);

        return redirect()->back()->with('success', 'Data peminjaman berhasil ditambahkan!');
    }

    public function updateLoan(Request $request, $id)
    {
        $request->validate([
            'peminjam' => 'required|string',
            'status' => 'required|string',
            'lama_pinjam' => 'required|integer|min:1',
            'jumlah_barang' => 'required|integer|min:1',
            'inventory_id' => 'required|exists:inventories,id',
        ]);

        $loan = Loan::findOrFail($id);
        $inventory = Inventory::findOrFail($request->inventory_id);

        // Jika status berubah menjadi Dikembalikan
        if ($request->status === 'Dikembalikan') {
            $inventory->tersedia += $request->jumlah_barang;
            $inventory->dipinjam -= $request->jumlah_barang;
        }
        // Jika status berubah menjadi Hilang/Rusak
        elseif ($request->status === 'Hilang/Rusak') {
            $inventory->hilang += $request->jumlah_barang;
            $inventory->dipinjam -= $request->jumlah_barang;
        }
        // Jika status tetap Dipinjam, tidak ada perubahan stok
        $inventory->save();

        $loan->update([
            'peminjam' => $request->peminjam,
            'status' => $request->status,
            'lama_pinjam' => $request->lama_pinjam,
            'jumlah_barang' => $request->jumlah_barang,
            'inventory_id' => $request->inventory_id,
        ]);

        return redirect()->back()->with('success', 'Data peminjaman berhasil diupdate!');
    }

    public function deleteLoan($id)
    {
        $loan = Loan::findOrFail($id);
        $inventory = Inventory::findOrFail($loan->inventory_id);

        // Jika status masih Dipinjam, kembalikan stok
        if ($loan->status === 'Dipinjam') {
            $inventory->tersedia += $loan->jumlah_barang;
            $inventory->dipinjam -= $loan->jumlah_barang;
            $inventory->save();
        }

        $loan->delete();

        return redirect()->back()->with('success', 'Data peminjaman berhasil dihapus!');
    }

    public function exportPDF($id)
    {
        $loan = Loan::with('inventory')->findOrFail($id);

        $data = [
            'nama_peminjam' => $loan->peminjam,
            'nama_barang' => $loan->inventory->name,
            'kategori_barang' => $loan->inventory->category,
            'jumlah_barang' => $loan->jumlah_barang,
            'lama_pinjam' => $loan->lama_pinjam,
            'status' => $loan->status,
            'tanggal_surat' => now()->format('d-m-Y'),
            'tanggal_pinjam' => $loan->created_at->format('d-m-Y'),
            'tempat' => 'Yogyakarta',
        ];

        $pdf = Pdf::loadView('pdf.export_doc', $data);
        return $pdf->download('Surat_Peminjaman_' . $loan->peminjam . '.pdf');
    }
}
