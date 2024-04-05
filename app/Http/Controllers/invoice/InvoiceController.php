<?php

namespace App\Http\Controllers\invoice;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerBalance;
use App\Models\Invoice;
use App\Models\InvoiceAdjustment;
use App\Models\InvoiceLabour;
use App\Models\InvoiceLogistics;
use App\Models\Labour;
use App\Models\Logistic;
use App\Models\Product;
use App\Models\ProductTransaction;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    public function list()
    {
        $invoice = Invoice::all();
        return view('Invoice.invoice-list');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $logisticData = $request->input('logistic');
            $labourData = $request->input('labour');
            $invocie_details = $request->input('user');
            $adjustmentDetailsData = $request->input('adjustmentDetailsFormData');
            $productDetailsData = $request->input('productDetailsFormData');
            // Store data in respective models

            $invoice = Invoice::create([
                'total_amount' => $invocie_details['grand_amount'],
                'invoice_type' => $request['invoice_type'],
                'date' => $invocie_details['date'],
                'customer_id' => $invocie_details['customer_id'],
                'user_id' => 1,

            ]);

            // Store adjustment details
            if ($adjustmentDetailsData) {

                foreach ($adjustmentDetailsData as $adjustmentDetail) {
                    InvoiceAdjustment::create([
                        'details' => $adjustmentDetail['description'],
                        'amount' => $adjustmentDetail['amount'],
                        'type' => $adjustmentDetail['type'],
                        'invoice_id' => $invoice->id,

                    ]);
                }
            }

            // Store product transactions
            foreach ($productDetailsData as $productDetail) {
                // Create ProductTransaction
                ProductTransaction::create([
                    'bags' => $productDetail['bags'],
                    'weight' => $productDetail['weight'],
                    'rate' => $productDetail['rate'],
                    'invoice_type' => $request['invoice_type'],
                    'product_id' => $productDetail['product'],
                    'invoice_id' => $invoice->id,
                ]);

                // Update Product quantity
                $product = Product::find($productDetail['product']);
                $newQty = $product->qty + floatval($productDetail['weight']);
                $product->qty = $newQty;
                $product->save();
            }
            if ($logisticData['logistic_type'] == 'own') {
                $logistic = InvoiceLogistics::create([
                    'invoice_id' => $invoice->id,
                    'logistic_id' => $logisticData['logistic_account'],
                    'amount' => $logisticData['logistic_amount'],
                    'driver_name' => $logisticData['logistic_driver'],
                ]);

                $logistic = Logistic::find($logisticData['logistic_account']);
                $newQty = $logistic->balance + floatval($logisticData['logistic_amount']);
                $logistic->balance = $newQty;
                $logistic->save();
            }
            if ($labourData['labour_type'] == 'own') {
                $labour = InvoiceLabour::create([
                    'invoice_id' => $invoice->id,
                    'labour_id' => $labourData['labour_account'],
                    'amount' => $labourData['labour_amount'],

                ]);

                $labour = Labour::find($labourData['labour_account']);
                $newQty = $labour->balance + floatval($labourData['labour_amount']);
                $labour->balance = $newQty;
                $labour->save();
            }
            if ($request['invoice_type'] == 'purchase') {
                CustomerBalance::create([
                    'type' => 'debit',
                    'category' => 'purchase_product',
                    'amount' =>  $invocie_details['grand_amount'],
                    'details' => 'Purchase product',
                    'category_id' => $invocie_details['customer_id'],
                    'user_id' => 1,

                ]);
            } else {
                CustomerBalance::create([
                    'type' => 'credit',
                    'category' => 'sale_product',
                    'amount' =>  $invocie_details['grand_amount'],
                    'details' => 'Sale product',
                    'category_id' => $invocie_details['customer_id'],
                    'user_id' => 1,

                ]);
            }
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
        return view('Invoice.invoice-print');
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

    public function purchase()
    {
        $customers = Customer::all();
        $logistics = Logistic::all();
        $labours = Labour::all();
        $products = Product::all();
        $invoice = Invoice::latest()->first();
        return view('Invoice.purchase', ['customers' => $customers, 'logistics' => $logistics, 'labours' => $labours, 'products' => $products, 'invoice' => $invoice]);
    }

    public function sale()
    {
        $customers = Customer::all();
        $logistics = Logistic::all();
        $labours = Labour::all();
        $products = Product::all();
        $invoice = Invoice::latest()->first();
        return view('Invoice.sale', ['customers' => $customers, 'logistics' => $logistics, 'labours' => $labours, 'products' => $products, 'invoice' => $invoice]);
    }
}
