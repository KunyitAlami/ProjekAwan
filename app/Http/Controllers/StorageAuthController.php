<?php

namespace App\Http\Controllers;

use App\Models\Credential;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StorageAuthController extends Controller
{
    public function show()
    {
        return view('storage.connect');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'access_key' => 'required',
            'secret_key' => 'required',
        ]);

        $credential = Credential::where(
            'user_id',
            Auth::id()
        )->first();

        if (
            $credential &&
            $credential->access_key === $request->access_key &&
            $credential->secret_key === $request->secret_key
        ) {

            session([
                'storage_authenticated' => true
            ]);

            return redirect()
                ->route('dashboard.storage')
                ->with('success',
                    'Storage authentication successful.');
        }

        return back()->withErrors([
            'credential' =>
                'Invalid access key or secret key.'
        ]);
    }
}