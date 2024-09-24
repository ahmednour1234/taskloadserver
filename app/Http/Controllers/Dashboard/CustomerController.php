<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Show all customers
    public function index()
    {
        $customers = Customer::paginate(10);
        return view('customer.index', compact('customers'));
    }

    // Store a new customer
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $customer = Customer::create($validator->validated());

        // Toastr Success Message
        toastr()->success('Customer created successfully!');

        return redirect()->route('customers.index');
    }

    // Show a specific customer
    public function show($id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            // Toastr Error Message
            toastr()->error('Customer not found');
            return redirect()->route('customers.index');
        }

        return view('customers.show', compact('customer'));
    }

    // Update a customer
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'nullable|string',
            'email' => 'nullable|email|unique:customers,email,' . $id,
            'phone' => 'nullable|string',
        ]);

        $customer = Customer::find($id);

        if (!$customer) {
            toastr()->error('Customer not found');
            return redirect()->route('customers.index');
        }

        $customer->update($request->only(['name', 'email', 'phone']));

        toastr()->success('Customer updated successfully!');

        return redirect()->route('customers.index');
    }

    // Delete a customer
    public function destroy($id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            toastr()->error('Customer not found');
            return redirect()->route('customers.index');
        }

        $customer->delete();

        toastr()->success('Customer deleted successfully!');

        return redirect()->route('customers.index');
    }
}
