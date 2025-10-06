<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ItemController extends Controller
{
    public function create()
    {
        return view('freelancer.item.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $item = new Item();
        $item->user_id = Auth::user()->id;
        $item->type = $request->item_type;
        $item->name = $request->name;
        $item->unit = $request->unit;
        $item->selling_price = $request->price;
        $item->description = $request->description;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('images', $filename, 'public');
            $item->image = $filename;
        }

        $item->save();

        return redirect()->route('freelancer.items')->with('success','Item Saved Successfully');
    }

    public function show($id)
    {
        $item = Item::with('invoice.invoice')->find($id);
        $items = Item::where('user_id',Auth::user()->id)->get();
        return view('freelancer.item.show', compact('item','items','id'));
    }

    public function edit($id)
    {
        $item = Item::find($id);
        return view('freelancer.item.edit', compact('item'));
    }

    public function render(Request $request)
    {
        $item = Item::with('invoice.invoice')->where('id',$request->id)->first();
        $html =  view('freelancer.item.render', compact('item'))->render();

        return response()->json([
            'status' => true,
            'html'   => $html
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Find the item by ID
        $item = Item::findOrFail($request->id);

        // Update fields
        $item->type = $request->item_type;
        $item->name = $request->name;
        $item->unit = $request->unit;
        $item->selling_price = $request->price;
        $item->description = $request->description;

        // Update the image if a new one is uploaded
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($item->image && Storage::disk('public')->exists('images/' . $item->image)) {
                Storage::disk('public')->delete('images/' . $item->image);
            }

            // Store the new image
            $file = $request->file('image');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('images', $filename, 'public');
            $item->image = $filename;
        }

        // Save updated item
        $item->save();

        return redirect()->route('freelancer.items')->with('success', 'Item Updated Successfully');
    }


    public function getItemData(Request $request){
        $item = Item::find($request->item_id);
        return response($item);
    }
}
