<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerBalance;
use App\Models\Invoice;
use App\Models\ProductTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::all();
        return view('customer.index', ['customers' => $customers]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'contact_number' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'opening_balance' => 'integer',
        ]);

        try {
            // Create a new Customer instance
            $customer = new Customer();

            // Assign values from the request
            $customer->name = $validatedData['name'];
            $customer->contact = $validatedData['contact_number'];
            $customer->balance = $validatedData['opening_balance'] ?? 0;
            $customer->address = $validatedData['address'];

            // Save the customer record
            $customer->save();

            // Return a success response
            return response()->json(['message' => 'Customer added successfully'], 201);
        } catch (\Exception $e) {
            // Return an error response if something goes wrong
            return response()->json(['message' => 'Failed to add customer', 'error' => $e->getMessage()], 500);
        }
    }

    public function fetchcustomer()
    {
        $customers = Customer::all();
        return $customers;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Retrieve customer balance records for the specified category ID
        $customerBalance = CustomerBalance::where('category_id', $id)
            ->where(function ($query) use ($id) {
                $query->where('category', 'purchase_product')
                    ->orWhere('category', 'sale_product')
                    ->orWhere(function ($query) use ($id) {
                        $query->where('category', 'customer')
                            ->where('category_id', $id);
                    });
            })
            ->latest()->get();
        foreach ($customerBalance as $transaction) {
            if ($transaction->category == 'purchase_product' || $transaction->category == 'sale_product') {
                $product_details = Invoice::where('id', $transaction->account)->with('product_transactions', 'product_transactions.product')->first();


                $transaction->product_details = $product_details;
            } else {

                $transaction->product_details = [];
            }
        }
        // dd($customerBalance);
        $totalDebit = CustomerBalance::where('category_id', $id)
            ->where(function ($query) use ($id) {
                $query->where('category', 'purchase_product')
                    ->orWhere('category', 'sale_product')
                    ->orWhere(function ($query) use ($id) {
                        $query->where('category', 'customer')
                            ->where('category_id', $id);
                    });
            })
            ->where('type', 'debit')
            ->sum('amount');
        $totalCredit = CustomerBalance::where('category_id', $id)
            ->where(function ($query) use ($id) {
                $query->where('category', 'purchase_product')
                    ->orWhere('category', 'sale_product')
                    ->orWhere(function ($query) use ($id) {
                        $query->where('category', 'customer')
                            ->where('category_id', $id);
                    });
            })
            ->where('type', 'credit')
            ->sum('amount');


        // Retrieve customer details
        $customer = Customer::findOrFail($id);

        // Pass the data to the view

        return view('customer.view', compact('customer', 'customerBalance', 'totalDebit', 'totalCredit'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $customer = Customer::findOrFail($id);
        return view('customer.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'contact_number' => 'required|string|max:15',
            'address' => 'required|string|max:255',
        ]);

        try {

            $customer = Customer::find($id);
            // Assign values from the request
            $customer->name = $validatedData['name'];
            $customer->contact = $validatedData['contact_number'];
            $customer->address = $validatedData['address'];

            // Save the customer record
            $customer->save();

            // Return a success response
            return response()->json(['message' => 'Customer Updated successfully'], 201);
        } catch (\Exception $e) {
            // Return an error response if something goes wrong
            return response()->json(['message' => 'Failed to add customer', 'error' => $e->getMessage()], 500);
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
