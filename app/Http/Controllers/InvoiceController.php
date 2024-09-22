<?php

namespace App\Http\Controllers;

use App\Http\Resources\InvoiceResource;
use App\Http\Resources\LogResource;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Log;
use Illuminate\Support\Facades\Validator;
use App\Mail\InvoiceUpdated;
use Illuminate\Support\Facades\Mail;

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
        return LogResource::collection($logs);
    }

    public function index()
    {
        $invoices = Invoice::with('customer')->paginate(10);
        return InvoiceResource::collection($invoices);
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
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $invoice = Invoice::create($request->all());

        $this->logAction('create', $invoice->id);

        return new InvoiceResource($invoice);
    }
    public function searchInvoices(Request $request)
    {
        $query = Invoice::with('customer');

        if ($request->has('customer_name')) {
            $query->whereHas('customer', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->input('customer_name') . '%');
            });
        }

        if ($request->has('phone')) {
            $query->whereHas('customer', function($q) use ($request) {
                $q->where('phone', 'like', '%' . $request->input('phone') . '%');
            });
        }

        if ($request->has('invoice_date')) {
            $query->whereDate('date', $request->input('invoice_date'));
        }

        $invoices = $query->paginate(10);

        return InvoiceResource::collection($invoices);
    }


    public function show($id)
    {
        $invoice = Invoice::find($id);

        if (!$invoice) {
            return response()->json(['error' => 'Invoice not found'], 404);
        }

        return new InvoiceResource($invoice);
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
            return response()->json(['error' => 'Invoice not found'], 404);
        }


        $invoice->amount = $request->input('amount', $invoice->amount);
        $invoice->date = $request->input('date', $invoice->date);
        $invoice->description = $request->input('description', $invoice->description);

        if (!$invoice->save()) {
            return response()->json(['error' => 'Update failed'], 500);
        }

        $this->logAction('update', $invoice->id);

        $customer = \App\Models\Customer::find($invoice->customer_id);

        if ($customer && $customer->email) {

            Mail::to($customer->email)->send(new InvoiceUpdated($invoice));
        }

        return new InvoiceResource($invoice);
    }



    public function destroy($id)
    {
        $invoice = Invoice::find($id);

        if (!$invoice) {
            return response()->json(['error' => 'Invoice not found'], 404);
        }

        $invoice->delete();

        return response()->json(['success' => 'Invoice Deleted Successfull'], 200);
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
