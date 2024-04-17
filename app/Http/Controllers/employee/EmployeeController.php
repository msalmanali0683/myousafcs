<?php

namespace App\Http\Controllers\employee;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerBalance;
use App\Models\Employee;
use App\Models\Labour;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $employes = Employee::all();
        return view('employee.index', ['employes' => $employes]);
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
            'name' => 'required|string|max:255|unique:products',
        ]);

        try {
            if ($request->id) {
                // Update Customer instance
                $expense =  Employee::find($request->id);

                // Assign values from the request
                $expense->name = $validatedData['name'];

                // Save the expense record
                $expense->save();
            } else {
                // Create a new Customer instance
                $expense = new Employee();

                // Assign values from the request
                $expense->name = $validatedData['name'];

                // Save the expense record
                $expense->save();
            }

            // Return a success response
            return response()->json(['message' => 'Employee added successfully'], 201);
        } catch (\Exception $e) {
            // Return an error response if something goes wrong
            return response()->json(['message' => 'Failed to add Employee', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $customerBalance = CustomerBalance::where('category_id', $id)
            ->where('category', 'employee')
            ->get();
        $totalDebit = CustomerBalance::where('category_id', $id)
            ->where('category', 'employee')
            ->where('type', 'debit')
            ->sum('amount');
        $totalCredit = CustomerBalance::where('category_id', $id)
            ->where('category', 'employee')
            ->where('type', 'credit')
            ->sum('amount');


        // Retrieve customer details
        $customer = Employee::findOrFail($id);

        // Pass the data to the view
        return view('employee.view', compact('customer', 'customerBalance', 'totalDebit', 'totalCredit'));
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
