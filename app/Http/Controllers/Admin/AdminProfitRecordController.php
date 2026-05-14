<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfitRecord;
use App\Models\ProfitEvidence;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class AdminProfitRecordController extends Controller
{
    /**
     * Display a listing of the profit records.
     */
    public function index()
    {
        $records = ProfitRecord::with(['student', 'admin'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.profit-records.index', compact('records'));
    }

    /**
     * Show the form for creating a new profit record.
     */
    public function create()
    {
        $users = User::orderBy('name')->get();
        return view('admin.profit-records.create', compact('users'));
    }

    /**
     * Store a newly created profit record in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'nullable|exists:users,id',
            'student_name' => 'required_if:student_id,null|string|max:255',
            'profit_amount' => 'required|numeric|min:0',
            'commission_received' => 'required|numeric|min:0',
            'currency' => 'required|string|max:10',
            'reason' => 'required|string',
            'screenshots.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max per image
        ]);

        try {
            DB::beginTransaction();

            $record = ProfitRecord::create([
                'reference_id' => ProfitRecord::generateReferenceId(),
                'student_id' => $request->student_id,
                'student_name' => $request->student_name,
                'profit_amount' => $request->profit_amount,
                'commission_received' => $request->commission_received,
                'currency' => $request->currency,
                'reason' => $request->reason,
                'admin_id' => auth()->id(),
                'ip_address' => $request->ip(),
            ]);

            if ($request->hasFile('screenshots')) {
                foreach ($request->file('screenshots') as $file) {
                    $path = $file->store('profits', 'public');
                    ProfitEvidence::create([
                        'profit_record_id' => $record->id,
                        'file_path' => $path,
                        'file_name' => $file->getClientOriginalName(),
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.profit-records.index')
                ->with('success', 'Profit record created successfully with reference ID: ' . $record->reference_id);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Failed to create record: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified profit record.
     */
    public function show(ProfitRecord $profitRecord)
    {
        $profitRecord->load(['student', 'admin', 'evidences']);
        return view('admin.profit-records.show', compact('profitRecord'));
    }

    /**
     * Remove the specified profit record from storage.
     */
    public function destroy(ProfitRecord $profitRecord)
    {
        try {
            DB::beginTransaction();

            // Delete evidence files
            foreach ($profitRecord->evidences as $evidence) {
                Storage::disk('public')->delete($evidence->file_path);
                $evidence->delete();
            }

            $profitRecord->delete();

            DB::commit();

            return redirect()->route('admin.profit-records.index')
                ->with('success', 'Profit record and evidence deleted successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to delete record: ' . $e->getMessage());
        }
    }
}
