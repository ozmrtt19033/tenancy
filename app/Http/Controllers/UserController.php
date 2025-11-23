<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Kullanıcı düzenleme formu
     */
    public function edit(User $user)
    {
        // Sadece kendi hesabını veya admin düzenleyebilir (şimdilik herkes düzenleyebilir)
        return view('tenant.users.edit', compact('user'));
    }

    /**
     * Kullanıcı güncelleme
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        // Şifre değiştirilmek isteniyorsa
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('users.index')
            ->with('success', 'Kullanıcı başarıyla güncellendi!');
    }

    /**
     * Kullanıcı silme
     */
    public function destroy(User $user)
    {
        // Kendi hesabını silemez
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')
                ->with('error', 'Kendi hesabınızı silemezsiniz!');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Kullanıcı başarıyla silindi!');
    }
}

