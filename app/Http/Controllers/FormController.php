<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Http\Request;

class FormController extends Controller
{
    public function update_user_profile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:50',
            'middle_name' => 'nullable|string|max:50',
            'last_name' => 'required|string|max:50',
            'suffix' => 'nullable|string|max:10',
            'birth_date' => 'required|date',
            'gender' => 'required|in:male,female',
            'phone' => 'required|string|max:20',
            'street' => 'nullable|string|max:50',
            'province' => 'nullable|string|max:50',
            'municipality' => 'nullable|string|max:50',
            'barangay' => 'nullable|string|max:50',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = auth()->user(); // get current user

        // Use the instance to update
        $user->update([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'suffix' => $request->suffix, // <-- corrected here
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
            'phone' => $request->phone,
            'street' => $request->street,
            'province' => $request->province,
            'municipality' => $request->municipality,
            'barangay' => $request->barangay,
        ]);

        return redirect()->back()->with('success', 'User updated successfully!');
    }
}
