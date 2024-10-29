<?php
namespace App\Actions\Web;

use Illuminate\Support\Facades\Auth;

class AccountActions {

    public static function settingsUpdate($request) {

        $current_password = $request->current_password;
        $new_password = $request->new_password;
        $new_password_confirmation = $request->new_password_confirmation;

        // Validate
        /*$request->validate([
            'current_password' => 'current_password',
            'new_password' => 'required|min:8|confirmed',
        ]);*/

        // Check current password
        if( !Auth::attempt(['email' => Auth::user()->email, 'password' => $current_password]) ) {
            return redirect()->back()->with('error', 'Current password is incorrect');
        }

        // Update user password
        Auth::user()->$new_password = bcrypt($new_password);

    }

}