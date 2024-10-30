<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplyController extends Controller
{
    public function manage() {
        $supply = Supplier::all();
        return view('admin.supply.manage', ['supply' => $supply]);
    }

    public function create() {
        $supply = Supplier::all();
        return view('admin.supply.create', ['supply' => $supply]);
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',

        ]);
        Supplier::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()->route('suppliers.manage')->with('success', 'Add supply successful!');
    }

    public function edit($id) {
        $supply = Supplier::findOrFail($id);
        return view('admin.supply.edit', compact('supply'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);

        $supply = Supplier::findOrFail($id);

        $supply->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()->route('suppliers.manage')->with('success', 'supply updated successfully!');
    }

    public function destroy($id) {
        $supply = Supplier::findOrFail($id);
        $supply->delete();
        return redirect()->route('suppliers.manage')->with('success', 'supply deleted successfully!');
    }

}
