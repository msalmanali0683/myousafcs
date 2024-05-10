<?php

namespace App\Http\Controllers\invoice;

use PDF;
use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\Customer;
use App\Models\CustomerBalance;
use App\Models\Employee;
use App\Models\Expense;
use App\Models\Invoice;
use App\Models\InvoiceAdjustment;
use App\Models\InvoiceLabour;
use App\Models\InvoiceLogistics;
use App\Models\Labour;
use App\Models\Logistic;
use App\Models\Product;
use App\Models\ProductTransaction;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

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
        $invoices = Invoice::with('customer', 'product_transactions.product')->latest()->get();
        // dd($invoices);
        return view('Invoice.invoice-list', ['invoices' => $invoices]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

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
                    'logistic_id' => $productDetail['logistic_id'],
                    'driver_name' => $productDetail['driver_name'],
                    'labour_id' => $productDetail['labour_id'],
                    'invoice_id' => $invoice->id,
                ]);

                // Update Product quantity
                $product = Product::find($productDetail['product']);
                $newQty = $product->qty + floatval($productDetail['weight']);
                $product->qty = $newQty;
                $product->save();
            }


            if ($request['invoice_type'] == 'purchase') {
                CustomerBalance::create([
                    'type' => 'credit',
                    'category' => 'purchase_product',
                    'amount' =>  $invocie_details['grand_amount'],
                    'details' => 'Purchase product',
                    'account' => $invoice->id,
                    'category_id' => $invocie_details['customer_id'],
                    'user_id' => 1,

                ]);
                $oldBlance = Customer::find($invocie_details['customer_id']);
                $balance = $oldBlance->balance + $invocie_details['grand_amount'];
                $oldBlance->balance = $balance;
                $oldBlance->save();
            } else {
                CustomerBalance::create([
                    'type' => 'debit',
                    'category' => 'sale_product',
                    'amount' =>  $invocie_details['grand_amount'],
                    'details' => 'Sale product',
                    'account' => $invoice->id,
                    'category_id' => $invocie_details['customer_id'],
                    'user_id' => 1,

                ]);
                $oldBlance = Customer::find($invocie_details['customer_id']);
                $balance = $oldBlance->balance + $invocie_details['grand_amount'];
                $oldBlance->balance = $balance;
                $oldBlance->save();
            }

            return response()->json(['message' => 'Invoice added successfully', 'invoice_id' => $invoice->id], 201);
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
        $invoice = Invoice::with('customer', 'product_transactions', 'adjustment')->where('id', $id)->first();

        return view('Invoice.invoice-print', ['invoice' => $invoice]);
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
    public function downloadPDF(string $id)
    {
        $invoice = Invoice::with('customer', 'product_transactions.product', 'adjustment')->where('id', $id)->first();
        $html = View::make('Invoice.invoice-print', compact('invoice'))->render();

        // Create a new Dompdf instance
        $dompdf = new Dompdf();

        // Load the HTML content into Dompdf
        $dompdf->loadHtml($html);

        // Render the PDF
        $dompdf->render();

        // Output the generated PDF (download or display)
        return $dompdf->stream('document.pdf');

        // Output the generated PDF (download or display)
        return $dompdf->stream('document.pdf');
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

    public function transaction(Request $request)
    {
        try {
            CustomerBalance::create([
                'type' => $request['type'],
                'category' => $request['category'],
                'category_id' =>  $request['category_id'],
                'details' =>  $request['details'],
                'account' =>  $request['account'],
                'amount' =>  $request['amount'],
                'user_id' => 1,

            ]);
            $bank = Bank::find($request['account']);
            if ($request['type'] == 'debit') {
                $bank->balance = $bank->balance -  $request['amount'];
            } else {
                $bank->balance = $bank->balance +  $request['amount'];
            }
            $bank->save();

            if ($request['category'] == 'customer') {
                $oldBlance = Customer::find($request['category_id']);
                if ($request['type'] == 'debit') {
                    $balance = $oldBlance->balance - $request['amount'];
                    $oldBlance->balance = $balance;
                } else {
                    $balance = $oldBlance->balance + $request['amount'];

                    $oldBlance->balance = $balance;
                }
                $oldBlance->save();
            } else if ($request['category'] == 'employee') {
                $oldBlance = Employee::find($request['category_id']);
                if ($request['type'] == 'debit') {
                    $balance = $oldBlance->balance - $request['amount'];
                    $oldBlance->balance = $balance;
                } else {
                    $balance = $oldBlance->balance + $request['amount'];

                    $oldBlance->balance = $balance;
                }
                $oldBlance->save();
            } else if ($request['category'] == 'expense') {
                $oldBlance = Expense::find($request['category_id']);
                if ($request['type'] == 'debit') {
                    $balance = $oldBlance->balance - $request['amount'];
                    $oldBlance->balance = $balance;
                } else {
                    $balance = $oldBlance->balance + $request['amount'];

                    $oldBlance->balance = $balance;
                }
                $oldBlance->save();
            } else if ($request['category'] == 'logistics') {
                $oldBlance = Logistic::find($request['category_id']);
                if ($request['type'] == 'debit') {
                    $balance = $oldBlance->balance - $request['amount'];
                    $oldBlance->balance = $balance;
                } else {
                    $balance = $oldBlance->balance + $request['amount'];

                    $oldBlance->balance = $balance;
                }
                $oldBlance->save();
            } else if ($request['category'] == 'labour') {
                $oldBlance = Labour::find($request['category_id']);
                if ($request['type'] == 'debit') {
                    $balance = $oldBlance->balance - $request['amount'];
                    $oldBlance->balance = $balance;
                } else {
                    $balance = $oldBlance->balance + $request['amount'];

                    $oldBlance->balance = $balance;
                }
                $oldBlance->save();
            }

            return response()->json(['message' => 'Transaction completed successfully'], 201);
        } catch (\Exception $e) {
            // Return an error response if something goes wrong
            return response()->json(['message' => 'Failed to add transaction', 'error' => $e->getMessage()], 500);
        }
    }
}
