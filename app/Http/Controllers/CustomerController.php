<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::latest()->get();
        return view('customer.index', compact('customers'));
    }

    public function show($id)
    {
        $customer = Customer::findOrFail($id);
        return response()->json(['status' => 'success', 'customer' => $customer]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'nullable',
            'address' => 'nullable',
        ]);

        $customer = Customer::create($data);

        return response()->json(['status' => 'success', 'customer' => $customer]);
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:customers,email,' . $id,
            'phone' => 'nullable',
            'address' => 'nullable',
        ]);

        $customer->update($data);

        return response()->json(['status' => 'success', 'customer' => $customer]);
    }

    public function destroy($id)
    {
        Customer::findOrFail($id)->delete();
        return response()->json(['status' => 'success']);
    }
}
