<?php

namespace App\Http\Controllers\labour;

use App\Http\Controllers\Controller;
use App\Models\Labour;
use Illuminate\Http\Request;

class LabourController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $labours = Labour::all();
        return view('labour.index', ['labours' => $labours]);
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
                $labour =  Labour::find($request->id);

                // Assign values from the request
                $labour->name = $validatedData['name'];

                // Save the labour record
                $labour->save();
            } else {
                // Create a new Customer instance
                $labour = new Labour();

                // Assign values from the request
                $labour->name = $validatedData['name'];

                // Save the labour record
                $labour->save();
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