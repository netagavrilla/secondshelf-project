<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'payment_method' => 'required',
            'total_price' => 'required|numeric',
            'items' => 'required|array',
        ]);

        $externalId = 'ORDER-' . time();

        $order = Order::create([
            'customer_name' => $request->customer_name,
            'phone' => $request->phone,
            'address' => $request->address,
            'payment_method' => $request->payment_method,
            'note' => $request->note,
            'total_price' => $request->total_price,
            'status' => 'pending',
            'payment_status' => 'PENDING',
            'external_id' => $externalId,
        ]);

        foreach ($request->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'book_id' => $item['book_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'subtotal' => $item['subtotal'],
            ]);
        }

        $response = Http::withBasicAuth(config('services.xendit.secret_key'), '')
            ->post('https://api.xendit.co/v2/invoices', [
                'external_id' => $externalId,
                'amount' => $request->total_price,
                'description' => 'Pembayaran pesanan SecondShelf',
                'customer' => [
                    'given_names' => $request->customer_name,
                    'mobile_number' => $request->phone,
                ],
                'success_redirect_url' => 'http://localhost:5173/payment-success',
                'failure_redirect_url' => 'http://localhost:5173/payment-failed',
            ]);

        if ($response->failed()) {
            return response()->json([
                'message' => 'Gagal membuat invoice Xendit',
                'error' => $response->json(),
            ], 500);
        }

        $invoice = $response->json();

        $order->update([
            'xendit_invoice_id' => $invoice['id'],
            'xendit_invoice_url' => $invoice['invoice_url'],
        ]);

        return response()->json([
            'message' => 'Order berhasil dibuat',
            'data' => $order,
            'invoice_url' => $invoice['invoice_url'],
        ]);
    }

    public function webhook(Request $request)
    {
        $callbackToken = $request->header('x-callback-token');

        if ($callbackToken !== config('services.xendit.webhook_token')) {
            return response()->json([
                'message' => 'Invalid callback token',
            ], 403);
        }

        $order = Order::where('external_id', $request->external_id)->first();

        if (!$order) {
            return response()->json([
                'message' => 'Order not found',
            ], 404);
        }

        $order->update([
            'payment_status' => $request->status,
            'status' => $request->status === 'PAID' ? 'paid' : 'pending',
        ]);

        return response()->json([
            'message' => 'Webhook received',
        ]);
    }
    public function index()
    {
        $orders = Order::with('items.book')
            ->latest()
            ->get();

        return response()->json($orders);
    }
}