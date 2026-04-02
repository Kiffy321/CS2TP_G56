<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /** Return all wishlist items for the authenticated user. */
    public function data()
    {
        $items = Wishlist::where('user_id', auth()->id())
            ->with('product')
            ->get()
            ->map(fn($w) => [
                'product_id' => $w->product_id,
                'name'       => $w->product->name ?? 'Unknown',
                'price'      => '£' . number_format($w->product->price ?? 0, 2),
                'image'      => $w->product->image_url ?? '/images/default.jpg',
                'category'   => $w->product->category ?? '',
                'link'       => '/products/' . $w->product_id,
            ])->values();

        return response()->json(['items' => $items]);
    }

    /** Add or remove a product from the wishlist (toggle). */
    public function toggle(Request $request)
    {
        $request->validate(['product_id' => 'required|integer|exists:products,id']);

        $existing = Wishlist::where('user_id', auth()->id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($existing) {
            $existing->delete();
            return response()->json(['success' => true, 'in_wishlist' => false]);
        }

        Wishlist::create([
            'user_id'    => auth()->id(),
            'product_id' => $request->product_id,
        ]);

        return response()->json(['success' => true, 'in_wishlist' => true]);
    }

    /** Check if a specific product is in the user's wishlist. */
    public function check(Request $request)
    {
        $request->validate(['product_id' => 'required|integer']);

        $inWishlist = Wishlist::where('user_id', auth()->id())
            ->where('product_id', $request->product_id)
            ->exists();

        return response()->json(['in_wishlist' => $inWishlist]);
    }
}
