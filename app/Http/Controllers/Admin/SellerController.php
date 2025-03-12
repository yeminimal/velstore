<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class SellerController extends Controller
{
    public function index()
    {
        $sellers = Seller::latest()->paginate(10);
        return view('admin.sellers.index', compact('sellers'));
    }

    public function create()
    {
        return view('admin.sellers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:sellers,email',
            'phone' => 'nullable|string|max:20',
            'store_name' => 'required|string|max:255|unique:sellers,store_name',
            'address' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $seller = new Seller();
        $seller->name = $request->name;
        $seller->email = $request->email;
        $seller->phone = $request->phone;
        $seller->store_name = $request->store_name;
        $seller->store_slug = Str::slug($request->store_name);
        $seller->address = $request->address;
        $seller->status = 'pending'; 

        if ($request->hasFile('logo')) {
            $seller->logo = $request->file('logo')->store('seller_logos', 'public');
        }

        $seller->save();

        return redirect()->route('admin.sellers.index')->with('success', 'Seller added successfully!');
    }

    public function edit(Seller $seller)
    {
        return view('admin.sellers.edit', compact('seller'));
    }

    public function update(Request $request, Seller $seller)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:sellers,email,' . $seller->id,
            'phone' => 'nullable|string|max:20',
            'store_name' => 'required|string|max:255|unique:sellers,store_name,' . $seller->id,
            'address' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $seller->update($request->except('logo'));

        if ($request->hasFile('logo')) {
            $seller->logo = $request->file('logo')->store('seller_logos', 'public');
            $seller->save();
        }

        return redirect()->route('admin.sellers.index')->with('success', 'Seller updated successfully!');
    }

   

    public function destroy($id)
    {
       
    $seller = Seller::findOrFail($id);

    if ($seller->logo) {
        Storage::delete('public/seller_logos/' . basename($seller->logo));
    }

    $seller->delete(); 

    return redirect()->route('admin.sellers.index')->with('success', 'Seller deleted successfully!');
    }
    
}
