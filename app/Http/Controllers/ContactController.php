<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\Product;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Show the contact page with featured products.
     */
    public function show()
    {
        $products = Product::limit(6)->get();
        return view('contact', ['products' => $products]);
    }

    /**
     * Handle contact form submission.
     */
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'nullable|string|max:30',
            'message' => 'required|string|min:10|max:2000',
        ]);

        ContactMessage::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Thank you for your message! We will get back to you soon.',
        ]);
    }
}
