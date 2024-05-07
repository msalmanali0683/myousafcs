<?php

namespace App\Http\Controllers\logistics;

use App\Http\Controllers\Controller;
use App\Models\CustomerBalance;
use App\Models\Logistic;
use App\Models\ProductTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LogisticsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $logistics = Logistic::all();
        return view('logistics.logistics', ['logistics' => $logistics]);
    }

    public function dashboard()
    {
        return view('logistics.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'details' => 'string|max:255',
        ]);

        try {
            // Create a new Customer instance
            if ($request->id) {
                $logistic =  Logistic::find($request->id);

                // Assign values from the request
                $logistic->name = $validatedData['name'];
                $logistic->details = $validatedData['details'];

                // Save the logistic record
                $logistic->save();
            } else {
                $logistic = new Logistic();

                // Assign values from the request
                $logistic->name = $validatedData['name'];
                $logistic->details = $validatedData['details'];

                // Save the logistic record
                $logistic->save();
            }


            // Return a success response
            return response()->json(['message' => 'Customer added successfully'], 201);
        } catch (\Exception $e) {
            // Return an error response if something goes wrong
            return response()->json(['message' => 'Failed to add customer', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $logisticBalance = CustomerBalance::where('category_id', $id)
            ->where('category', 'logistics')
            ->orderBy('id', 'desc') // Order by ID from high to low
            ->get();

        // Retrieve product transactions where logistic_id is $id
        $productTransactions = ProductTransaction::where('logistic_id', $id)
            ->orderBy('id', 'desc') // Order by ID from high to low
            ->get();

        $logistics = [];

        // Add logistic balance items to the logistics array
        foreach ($logisticBalance as $item) {
            $item->invoice_type = 'logistic';
            $logistics[] = $item;
        }

        // Add product transactions to the logistics array
        foreach ($productTransactions as $item) {
            $item->amount = $item->logistic_amount ?? 0;
            $item->type = ($item->invoice_type == 'purchase') ? 'credit' : 'debit';
            $logistics[] = $item;
        }



        // Retrieve customer details
        $logistic = Logistic::findOrFail($id);

        // Pass the data to the view
        return view('logistics.view', compact('logistic', 'logistics'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'transactionId' => 'required|exists:product_transactions,id',
            'amount' => 'required|numeric|min:0',
        ]);

        // If validation fails, return error response
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ]);
        }

        // Retrieve the transaction ID and amount from the request
        $transactionId = $request->input('transactionId');
        $amount = $request->input('amount');

        // Update the logistic amount
        try {
            $transaction = ProductTransaction::findOrFail($transactionId);
            $transaction->logistic_amount = $amount;

            $oldBlance = Logistic::find($transaction->logistic_id);
            $oldBlance->balance = $oldBlance->balance + $amount;

            $transaction->save();
            $oldBlance->save();

            return response()->json([
                'success' => true,
                'message' => 'Amount updated successfully',
            ]);
        } catch (\Exception $e) {
            // Return error response if an exception occurs
            return response()->json([
                'success' => false,
                'message' => 'Failed to update amount',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
