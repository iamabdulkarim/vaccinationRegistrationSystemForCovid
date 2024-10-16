<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class SearchController extends Controller
{
   
    public function index(Request $request)
        {
            $user = null; 
        
            $request->validate([
                'user_nid' => 'nullable|string|max:255', 
            ]);

            try {
             
                if (!empty($request->user_nid)) {
                    $user = User::with('vaccineCenter')
                        ->where('nid', $request->user_nid)
                        ->first();
            
                    // If no user is found, pass a specific flag to the view
                    if (!$user) {
                        return view('covid.search', ['user' => null, 'message' => 'You are not registered.']);
                    }
                }

            } catch (\Exception $e) {
                // Log the error for further debugging
                \Log::error('Error fetching user by NID: ' . $e->getMessage(), [
                    'user_nid' => $request->user_nid,
                    'exception' => $e
                ]);

                // Redirect back with an error message
                return redirect()->back()->with('error', 'An error occurred while fetching the user details. Please try again later.');
            }

          
            return view('covid.search', compact('user'));
        }

    
}

