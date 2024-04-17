<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Expense;
use App\Models\Labour;
use App\Models\Logistic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomePage extends Controller
{
  public function index()
  {
    $banks = Bank::all();
    $customers = Customer::all();
    $labours = Labour::all();
    $logistics = Logistic::all();
    $expenses = Expense::all();
    $employees = Employee::all();

    $customerBalances = DB::table('customer_balances')
      ->whereNotIn('category', ['purchase_product', 'sale_product'])
      ->leftJoin('customers', function ($join) {
        $join->on('customer_balances.category_id', '=', 'customers.id')
          ->where('customer_balances.category', '=', 'customer');
      })
      ->leftJoin('employees', function ($join) {
        $join->on('customer_balances.category_id', '=', 'employees.id')
          ->where('customer_balances.category', '=', 'employee');
      })
      ->leftJoin('expenses', function ($join) {
        $join->on('customer_balances.category_id', '=', 'expenses.id')
          ->where('customer_balances.category', '=', 'expense');
      })
      ->leftJoin('logistics', function ($join) {
        $join->on('customer_balances.category_id', '=', 'logistics.id')
          ->where('customer_balances.category', '=', 'logistics');
      })
      ->leftJoin('labours', function ($join) {
        $join->on('customer_balances.category_id', '=', 'labours.id')
          ->where('customer_balances.category', '=', 'labour');
      })
      ->leftJoin('banks', function ($join) {
        $join->on('customer_balances.account', '=', 'banks.id')
          ->where('customer_balances.category', '!=', 'purchase_product')
          ->where('customer_balances.category', '!=', 'sale_product');
      })
      ->select(
        'customer_balances.*',
        'customers.name as customer_name',
        'customers.id as customer_id',
        'logistics.name as logistics_name',
        'logistics.id as logistics_id',
        'labours.name as labour_name',
        'labours.id as labour_id',
        'employees.id as employee_id',
        'employees.name as employee_name',
        'expenses.id as expense_id',
        'expenses.name as expense_name',
        'banks.id as bank_id',
        'banks.name as bank_name'

      )
      ->get();

    return view('content.pages.pages-home', compact('banks', 'customers', 'employees', 'expenses', 'labours', 'logistics', 'customerBalances'));
  }
}
