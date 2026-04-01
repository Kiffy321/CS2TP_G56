<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /**
     * Display the checkout page.
     * Requires the user to be logged in and have items in the session cart.
     */
    public function index()
    {
        if (!auth()->check()) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json(['error' => 'Please log in to proceed with checkout'], 401);
            }
            return redirect()->route('login')->with('message', 'Please log in to proceed with checkout');
        }

        $cart = session('cart', []);
        $dbCart = auth()->check()
            ? Cart::where('user_id', auth()->id())->with('product')->get()
            : collect();

        if (empty($cart) && $dbCart->isEmpty()) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json(['error' => 'Your cart is empty'], 400);
            }
            return redirect()->route('cart.index')->with('message', 'Your cart is empty');
        }

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json(['success' => true]);
        }
        return view('checkout');
    }

    /**
     * Process the checkout: create order + order items from the session cart.
     */
    public function store(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Please log in first'], 401);
        }

        $request->validate([
            'shipping_address' => 'required|string|min:5',
            'payment_method'   => 'required|string|in:credit_card,debit_card,paypal',
            'notes'            => 'nullable|string|max:500',
        ]);

        // Load cart: DB for authenticated users, session for guests
        $dbCart = Cart::where('user_id', auth()->id())->with('product')->get();
        $useDbCart = $dbCart->isNotEmpty();

        if (!$useDbCart) {
            $cart = session('cart', []);
            if (empty($cart)) {
                return response()->json(['error' => 'Your cart is empty'], 400);
            }
        }

        // Calculate total
        if ($useDbCart) {
            $total = $dbCart->sum(fn($c) => ($c->product->price ?? 0) * $c->quantity);
        } else {
            $total = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));
        }

        try {
            // Create order
            $order = Order::create([
                'user_id'          => auth()->id(),
                'order_number'     => 'ORD-' . strtoupper(uniqid()),
                'total_amount'     => $total,
                'status'           => 'pending',
                'payment_method'   => $request->payment_method,
                'shipping_address' => $request->shipping_address,
                'notes'            => $request->notes,
            ]);

            // Create order items and reduce product stock
            if ($useDbCart) {
                foreach ($dbCart as $cartItem) {
                    $product = $cartItem->product;
                    if ($product) {
                        OrderItem::create([
                            'order_id'   => $order->id,
                            'product_id' => $product->id,
                            'quantity'   => $cartItem->quantity,
                            'unit_price' => $product->price,
                        ]);
                        $product->stock_quantity = max(0, $product->stock_quantity - $cartItem->quantity);
                        $product->save();
                    }
                }
                Cart::where('user_id', auth()->id())->delete();
            } else {
                foreach ($cart as $item) {
                    $productId = $item['product_id'] ?? null;
                    $product = null;
                    if (!$productId) {
                        $product = Product::where('name', $item['name'])->first();
                        $productId = $product?->id;
                    } else {
                        $product = Product::find($productId);
                    }

                    if ($productId && $product) {
                        OrderItem::create([
                            'order_id'   => $order->id,
                            'product_id' => $productId,
                            'quantity'   => $item['quantity'],
                            'unit_price' => $item['price'],
                        ]);
                        $product->stock_quantity = max(0, $product->stock_quantity - $item['quantity']);
                        $product->save();
                    }
                }
                session()->forget('cart');
            }

            return response()->json([
                'success'  => true,
                'message'  => 'Order created successfully',
                'order_id' => $order->id,
            ]);
        } catch (\Exception $e) {
            \Log::error('Order creation failed: ' . $e->getMessage());
            return response()->json(['error' => 'Order creation failed'], 500);
        }
    }
}