<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Throwable;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit', [
            'user' => auth()->user(),
        ]);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'profile_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        unset($validated['profile_photo']);

        if ($request->hasFile('profile_photo')) {
            $validated['profile_photo_path'] = $this->storeProfilePhoto($request);

            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }
        }

        $user->update($validated);

        return back()->with('success', 'Profile updated successfully!');
    }

    public function updateDetails(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:1000'],
        ]);

        $request->user()->update($validated);

        return back()->with('success', 'Profile details updated successfully!');
    }

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'profile_photo' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $user = $request->user();
        $path = $this->storeProfilePhoto($request);

        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }

        $user->update([
            'profile_photo_path' => $path,
        ]);

        return back()->with('success', 'Profile picture updated successfully!');
    }

    private function storeProfilePhoto(Request $request): string
    {
        $file = $request->file('profile_photo');

        if (!$file || !$file->isValid()) {
            throw ValidationException::withMessages([
                'profile_photo' => 'Please choose a valid image file before uploading.',
            ]);
        }

        $sourcePath = $file->getPathname();

        if (!$sourcePath || !is_readable($sourcePath)) {
            throw ValidationException::withMessages([
                'profile_photo' => 'The selected image could not be read. Please choose the file again and try once more.',
            ]);
        }

        $extension = $file->extension() ?: $file->getClientOriginalExtension() ?: 'jpg';
        $path = 'profile-photos/' . Str::uuid() . '.' . $extension;

        try {
            $stream = fopen($sourcePath, 'r');
            $stored = Storage::disk('public')->put($path, $stream);

            if (is_resource($stream)) {
                fclose($stream);
            }
        } catch (Throwable) {
            if (isset($stream) && is_resource($stream)) {
                fclose($stream);
            }

            throw ValidationException::withMessages([
                'profile_photo' => 'The selected image could not be uploaded. Please choose the file again and try once more.',
            ]);
        }

        if (!$stored) {
            throw ValidationException::withMessages([
                'profile_photo' => 'The profile picture could not be uploaded. Please try again.',
            ]);
        }

        return $path;
    }

    public function updateEmail(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        ]);

        $user->update($validated);

        return back()->with('success', 'Email updated successfully!');
    }

    public function updatePhone(Request $request)
    {
        $validated = $request->validate([
            'phone' => ['nullable', 'string', 'max:30'],
        ]);

        $request->user()->update($validated);

        return back()->with('success', 'Contact number updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', 'Password changed successfully!');
    }
}
