<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index() {
        return view('profile');
    }

    public function updateProfile(Request $request, $id) {

        // Validasi input
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
        ]);

        // Update data user
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        // Jika ada foto baru
        if ($request->cropped_photo) {
            $imageData = $request->cropped_photo;
            $image = str_replace('data:image/png;base64,', '', $imageData);
            $image = str_replace(' ', '+', $image);

            // Hapus foto lama (jika ada)
            if ($user->image && Storage::disk('public')->exists($user->image)) {
                Storage::disk('public')->delete($user->image);
            }

            // Gunakan nama file unik per user (misal pakai id user)
            $imageName = 'profile-' . $user->id . '.png';

            // Simpan foto baru
            Storage::disk('public')->put('profiles/' . $imageName, base64_decode($image));
            $user->image = 'profiles/' . $imageName;
        }
        $user->save();

        return redirect()->back()->with('success', 'Profile berhasil diperbarui.');
    }
}
