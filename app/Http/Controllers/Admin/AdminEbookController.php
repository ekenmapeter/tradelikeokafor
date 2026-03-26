<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ebook;
use App\Models\EbookOrder;
use App\Mail\EbookApproved;
use App\Mail\EbookDeclined;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminEbookController extends Controller
{
    // ===== EBOOK MANAGEMENT =====

    public function index()
    {
        $ebooks = Ebook::withCount('orders')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.ebooks.index', compact('ebooks'));
    }

    public function create()
    {
        return view('admin.ebooks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'required|string|max:1000',
            'price' => 'required|numeric|min:0',
            'price_naira' => 'nullable|numeric|min:0',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pdf_file' => 'required|mimes:pdf|max:51200', // max 50MB
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->only(['title', 'short_description', 'price', 'price_naira']);
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('ebooks/covers', 'public');
        }

        $data['pdf_file'] = $request->file('pdf_file')->store('ebooks/pdfs', 'public');

        Ebook::create($data);

        return redirect()->route('admin.ebooks.index')
            ->with('success', 'Ebook created successfully.');
    }

    public function edit(Ebook $ebook)
    {
        return view('admin.ebooks.edit', compact('ebook'));
    }

    public function update(Request $request, Ebook $ebook)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'required|string|max:1000',
            'price' => 'required|numeric|min:0',
            'price_naira' => 'nullable|numeric|min:0',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pdf_file' => 'nullable|mimes:pdf|max:51200',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->only(['title', 'short_description', 'price', 'price_naira']);
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('cover_image')) {
            if ($ebook->cover_image) {
                Storage::disk('public')->delete($ebook->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('ebooks/covers', 'public');
        }

        if ($request->hasFile('pdf_file')) {
            Storage::disk('public')->delete($ebook->pdf_file);
            $data['pdf_file'] = $request->file('pdf_file')->store('ebooks/pdfs', 'public');
        }

        $ebook->update($data);

        return redirect()->route('admin.ebooks.index')
            ->with('success', 'Ebook updated successfully.');
    }

    public function destroy(Ebook $ebook)
    {
        if ($ebook->cover_image) {
            Storage::disk('public')->delete($ebook->cover_image);
        }
        Storage::disk('public')->delete($ebook->pdf_file);
        $ebook->delete();

        return redirect()->route('admin.ebooks.index')
            ->with('success', 'Ebook deleted successfully.');
    }

    // ===== ORDER MANAGEMENT =====

    public function orders()
    {
        $orders = EbookOrder::with('ebook')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.ebooks.orders', compact('orders'));
    }

    public function approveOrder(EbookOrder $order)
    {
        $order->update([
            'status' => 'approved',
            'approved_at' => now(),
        ]);

        // Send ebook PDF to customer via email
        try {
            Mail::to($order->customer_email)->send(new EbookApproved($order));
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Order approved but email could not be sent: ' . $e->getMessage());
        }

        return redirect()->back()
            ->with('success', 'Order approved. Ebook has been sent to ' . $order->customer_email);
    }

    public function declineOrder(Request $request, EbookOrder $order)
    {
        $request->validate([
            'admin_note' => 'nullable|string|max:500',
        ]);

        $order->update([
            'status' => 'declined',
            'admin_note' => $request->admin_note,
        ]);

        // Notify customer about declined order
        try {
            Mail::to($order->customer_email)->send(new EbookDeclined($order));
        } catch (\Exception $e) {
            // fail silently
        }

        return redirect()->back()
            ->with('success', 'Order has been declined.');
    }
}
