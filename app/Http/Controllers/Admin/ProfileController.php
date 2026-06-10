<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function profile()
    {
        $user = auth()->user()->load('role');

        return response()->json([
            'success' => true,
            'data' => $this->formatProfile($user),
            'user' => $this->formatUser($user),
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user()->load('role');

        if (!$this->canEditProfile($user)) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have permission to edit your profile.',
            ], 403);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
        ]);

        $user->update($validated);
        $user->load('role');

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully.',
            'data' => $this->formatProfile($user),
            'user' => $this->formatUser($user),
        ]);
    }

    public function uploadAvatar(Request $request)
    {
        $user = auth()->user()->load('role');

        if (!$this->canEditProfile($user)) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have permission to update your profile photo.',
            ], 403);
        }

        $request->validate([
            'avatar' => ['required', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
        ]);

        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $path = $request->file('avatar')->store('profile-avatars', 'public');
        $user->update(['avatar' => $path]);
        $user->load('role');

        return response()->json([
            'success' => true,
            'message' => 'Profile photo updated successfully.',
            'data' => $this->formatProfile($user),
            'user' => $this->formatUser($user),
        ]);
    }

    public function removeAvatar()
    {
        $user = auth()->user()->load('role');

        if (!$this->canEditProfile($user)) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have permission to remove your profile photo.',
            ], 403);
        }

        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->update(['avatar' => null]);
        $user->load('role');

        return response()->json([
            'success' => true,
            'message' => 'Profile photo removed successfully.',
            'data' => $this->formatProfile($user),
            'user' => $this->formatUser($user),
        ]);
    }

    public function changePassword(Request $request)
    {
        $user = auth()->user()->load('role');

        if (!$this->canChangePassword($user)) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have permission to change your password.',
            ], 403);
        }

        $validated = $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (!Hash::check($validated['current_password'], $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'The current password is incorrect.',
                'errors' => [
                    'current_password' => ['The current password is incorrect.'],
                ],
            ], 422);
        }

        $user->update([
            'password' => $validated['password'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password changed successfully.',
        ]);
    }

    private function canEditProfile($user): bool
    {
        return in_array($user->role?->slug, ['super-admin', 'admin'], true);
    }

    private function canChangePassword($user): bool
    {
        return in_array($user->role?->slug, ['super-admin', 'admin'], true);
    }

    private function avatarUrl(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return asset('storage/' . $path);
    }

    private function formatProfile($user): array
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'avatar' => $user->avatar,
            'avatar_url' => $this->avatarUrl($user->avatar),
            'role' => $user->role?->slug,
            'role_name' => $user->role?->name,
        ];
    }

    private function formatUser($user): array
    {
        $data = $user->toArray();
        $data['avatar_url'] = $this->avatarUrl($user->avatar);

        return $data;
    }
}
