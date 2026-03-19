<?php

namespace App\Http\Controllers;

use App\Models\Ebook;
use App\Models\EbookOrder;
use App\Mail\EbookOrderReceived;
use App\Mail\Admin\NewEbookOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class EbookController extends Controller
{
    public function index()
    {
        $ebooks = Ebook::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('ebooks.index', compact('ebooks'));
    }

    public function show($slug)
    {
        $ebook = Ebook::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $settings = \App\Models\Setting::pluck('value', 'key')->toArray();

        return view('ebooks.show', compact('ebook', 'settings'));
    }

    public function purchase(Request $request, $slug)
    {
        $ebook = Ebook::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'nullable|string|max:50',
            'payment_method' => 'required|in:paypal,bank_transfer',
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $proofPath = $request->file('payment_proof')->store('ebook-proofs', 'public');

        $order = EbookOrder::create([
            'order_number' => EbookOrder::generateOrderNumber(),
            'ebook_id' => $ebook->id,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'payment_method' => $request->payment_method,
            'payment_proof' => $proofPath,
            'amount' => $ebook->price,
            'status' => 'pending',
        ]);

        // Send email notification to customer
        try {
            Mail::to($order->customer_email)->send(new EbookOrderReceived($order));
        } catch (\Exception $e) {
            // fail silently
        }

        // Send email notification to admin
        try {
            $adminEmail = config('mail.from.address', 'support@tradelikeokafor.com');
            Mail::to($adminEmail)->send(new NewEbookOrder($order));
        } catch (\Exception $e) {
            // fail silently
        }

        return redirect()->route('ebooks.thankyou', $order->order_number);
    }

    public function thankyou($orderNumber)
    {
        $order = EbookOrder::where('order_number', $orderNumber)->with('ebook')->firstOrFail();
        return view('ebooks.thankyou', compact('order'));
    }
}
