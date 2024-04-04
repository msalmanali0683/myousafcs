<?php

namespace App\Http\Controllers\Banks;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use Illuminate\Http\Request;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banks = Bank::all();
        return view('banks.bank', ['banks' => $banks]);
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
            'account' => 'required|string|max:255',
        ]);

        try {
            // Create a new Customer instance
            if ($request->id) {
                $bank =  Bank::find($request->id);

                // Assign values from the request
                $bank->name = $validatedData['name'];
                $bank->account = $validatedData['account'];

                // Save the bank record
                $bank->save();
            } else {
                $bank = new Bank();

                // Assign values from the request
                $bank->name = $validatedData['name'];
                $bank->account = $validatedData['account'];

                // Save the bank record
                $bank->save();
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
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
