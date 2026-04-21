<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    /**
     * Display a listing of the loans.
     */
    public function index(Request $request)
    {
        // For testing, just return all active loans
        $loans = Loan::where('status', 'active')->get();
        
        return response()->json([
            'success' => true,
            'message' => 'Active loans retrieved successfully.',
            'data' => $loans
        ]);
    }

    /**
     * Display a specific loan.
     */
    public function show(Request $request, Loan $loan)
    {
        // Ensure the user owns this loan before returning it
        if ($loan->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access to this loan.'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'data' => $loan
        ]);
    }
}
