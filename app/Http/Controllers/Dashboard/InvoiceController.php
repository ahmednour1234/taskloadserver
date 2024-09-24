<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use App\Mail\InvoiceUpdated;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin')->only(['store', 'update', 'destroy']);
        $this->middleware('role:employee')->only('update');
    }

    public function showLogs()
    {
        $logs = Log::with('user')->paginate(10);
        return view('logs.index', compact('logs'));
    }
public function index(Request $request)
{
    $query = Invoice::with('customer'); // Eager loading the customer relationship

    if ($request->filled('customer_name')) {
        $query->whereHas('customer', function($q) use ($request) {
            $q->where('name', 'like', '%' . $request->customer_name . '%');
        });
    }

    if ($request->filled('phone')) {
        $query->whereHas('customer', function($q) use ($request) {
            $q->where('phone', 'like', '%' . $request->phone . '%');
        });
    }

    if ($request->filled('invoice_date')) {
        $query->whereDate('date', $request->invoice_date);
    }

    $invoices = $query->paginate(10);
$customers=Customer::all();
    return view('invoices.index', compact('invoices','customers'));
}

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $invoice = Invoice::create($request->all());

        $this->logAction('create', $invoice->id);

        // Toastr Success Message
        toastr()->success('Invoice created successfully!');

        return redirect()->route('invoices.index');
    }

    public function show($id)
    {
        $invoice = Invoice::find($id);

        if (!$invoice) {
            // Toastr Error Message
            toastr()->error('Invoice not found');
            return redirect()->route('invoices.index');
        }

        return view('invoices.show', compact('invoice'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'amount' => 'nullable|numeric',
            'date' => 'nullable|date',
            'description' => 'nullable|string'
        ]);

        $invoice = Invoice::find($id);

        if (!$invoice) {
            toastr()->error('Invoice not found');
            return redirect()->route('invoices.index');
        }

        $invoice->amount = $request->input('amount', $invoice->amount);
        $invoice->date = $request->input('date', $invoice->date);
        $invoice->description = $request->input('description', $invoice->description);

        if (!$invoice->save()) {
            toastr()->error('Update failed');
            return redirect()->back();
        }

        $this->logAction('update', $invoice->id);

        $customer = Customer::find($invoice->customer_id);

        if ($customer && $customer->email) {
            Mail::to($customer->email)->send(new InvoiceUpdated($invoice));
        }

        toastr()->success('Invoice updated successfully!');
        return redirect()->route('invoices.index');
    }

    public function destroy($id)
    {
        $invoice = Invoice::find($id);

        if (!$invoice) {
            toastr()->error('Invoice not found');
            return redirect()->route('invoices.index');
        }

        $invoice->delete();

        toastr()->success('Invoice deleted successfully!');
        return redirect()->route('invoices.index');
    }

    protected function logAction($action, $invoiceId = null)
    {
        if ($invoiceId !== null) {
            Log::create([
                'user_id' => Auth::id(),
                'action' => $action,
                'invoice_id' => $invoiceId,
                'role' => Auth::user()->isAdmin() ? 'Admin' : 'Employee',
            ]);
        }
    }
}
