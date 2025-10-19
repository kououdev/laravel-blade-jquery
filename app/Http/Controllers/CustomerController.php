<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10); // Default 10 items per page
        $search = $request->get('search');
        $searchEmail = $request->get('search_email');

        $query = Customer::latest();

        // Filter by name if search parameter exists
        if ($search) {
            $query->where('name', 'LIKE', '%' . $search . '%');
        }

        // Filter by email if search_email parameter exists
        if ($searchEmail) {
            $query->where('email', 'LIKE', '%' . $searchEmail . '%');
        }

        $customers = $query->paginate($perPage);

        // Keep pagination and search parameters in the URL
        $customers->appends($request->query());

        return view('customer.index', compact('customers', 'search', 'searchEmail'));
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
