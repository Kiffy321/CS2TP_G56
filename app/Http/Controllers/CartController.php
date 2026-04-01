<?php
namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        return view('cart');
    }

    public function data()
    {
        if (auth()->check()) {
            $cartItems = Cart::where('user_id', auth()->id())
                ->with('product')
                ->orderBy('id')
                ->get();

            $items = $cartItems->map(fn($c) => [
                'cart_id'    => $c->id,
                'product_id' => $c->product_id,
                'name'       => $c->product->name ?? 'Unknown',
                'price'      => (float) ($c->product->price ?? 0),
                'quantity'   => $c->quantity,
                'image'      => $c->product->image_url ?? '/images/default.jpg',
                'subtotal'   => (float) ($c->product->price ?? 0) * $c->quantity,
            ])->values()->toArray();

            $total = array_sum(array_column($items, 'subtotal'));
            return response()->json(['items' => $items, 'total' => $total]);
        }

        $cart  = session('cart', []);
        $items = array_values($cart);
        $total = array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], $items));
        return response()->json(['items' => $items, 'total' => $total]);
    }

    public function add(Request $request)
    {
        $request->validate([
            'productName' => 'required|string|max:255',
            'quantity'    => 'required|integer|min:1',
            'price'       => 'required|numeric|min:0',
        ]);

        $productId = $request->input('productId') ? (int) $request->productId : null;

        if (auth()->check() && $productId) {
            $existing = Cart::where('user_id', auth()->id())
                ->where('product_id', $productId)
                ->first();

            if ($existing) {
                $existing->increment('quantity', (int) $request->quantity);
            } else {
                Cart::create([
                    'user_id'    => auth()->id(),
                    'product_id' => $productId,
                    'quantity'   => (int) $request->quantity,
                ]);
            }

            $cartCount = Cart::where('user_id', auth()->id())->sum('quantity');
            return response()->json(['success' => true, 'cartCount' => $cartCount]);
        }

        // Session fallback (guest or no product_id)
        $cart = session('cart', []);
        $key  = $request->productName;

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += (int) $request->quantity;
        } else {
            $cart[$key] = [
                'cart_id'    => uniqid(),
                'product_id' => $productId,
                'name'       => $request->productName,
                'price'      => (float) $request->price,
                'quantity'   => (int) $request->quantity,
                'image'      => '/images/' . strtolower(str_replace(' ', '-', $request->productName)) . '.jpg',
                'subtotal'   => (float) $request->price * $request->quantity,
            ];
        }

        foreach ($cart as &$item) {
            $item['subtotal'] = $item['price'] * $item['quantity'];
        }

        session(['cart' => $cart]);
        $cartCount = array_sum(array_column($cart, 'quantity'));
        return response()->json(['success' => true, 'cartCount' => $cartCount]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'index'    => 'required|integer|min:0',
            'quantity' => 'required|integer|min:1',
        ]);

        if (auth()->check()) {
            $item = Cart::where('user_id', auth()->id())
                ->orderBy('id')
                ->get()
                ->get((int) $request->index);

            if (!$item) {
                return response()->json(['error' => 'Item not found'], 404);
            }

            $item->update(['quantity' => (int) $request->quantity]);
            return response()->json(['success' => true]);
        }

        $cart = session('cart', []);
        $keys = array_keys($cart);

        if (!isset($keys[$request->index])) {
            return response()->json(['error' => 'Item not found'], 404);
        }

        $key = $keys[$request->index];
        $cart[$key]['quantity'] = (int) $request->quantity;
        $cart[$key]['subtotal'] = $cart[$key]['price'] * $request->quantity;

        session(['cart' => $cart]);
        return response()->json(['success' => true]);
    }

    public function remove(Request $request)
    {
        if (auth()->check()) {
            $items = Cart::where('user_id', auth()->id())
                ->orderBy('id')
                ->get();

            $index  = $request->input('index');
            $cartId = $request->input('cartId');

            if ($index !== null) {
                $item = $items->get((int) $index);
                if ($item) {
                    $item->delete();
                } else {
                    return response()->json(['error' => 'Item not found'], 404);
                }
            } elseif ($cartId) {
                Cart::where('user_id', auth()->id())->where('id', $cartId)->delete();
            } else {
                return response()->json(['error' => 'Item not found'], 404);
            }

            return response()->json(['success' => true]);
        }

        $cart = session('cart', []);
        $keys = array_keys($cart);

        $index  = $request->input('index');
        $cartId = $request->input('cartId');

        if ($index !== null && isset($keys[(int)$index])) {
            unset($cart[$keys[(int)$index]]);
        } elseif ($cartId) {
            foreach ($cart as $key => $item) {
                if ($item['cart_id'] === $cartId) { unset($cart[$key]); break; }
            }
        } else {
            return response()->json(['error' => 'Item not found'], 404);
        }

        session(['cart' => $cart]);
        return response()->json(['success' => true]);
    }

    public function clear()
    {
        if (auth()->check()) {
            Cart::where('user_id', auth()->id())->delete();
        } else {
            session()->forget('cart');
        }
        return response()->json(['success' => true]);
    }

    public function placeOrder()
    {
        if (auth()->check()) {
            Cart::where('user_id', auth()->id())->delete();
        } else {
            session()->forget('cart');
        }
        return response()->json(['success' => true, 'order_id' => time()]);
    }
}
