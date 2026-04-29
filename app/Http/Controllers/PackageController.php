<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;

class PackageController extends Controller
{

    public function index()
    {
        $packages = Package::latest()->get();

        return view(
            'admin.packages.index',
            compact('packages')
        );
    }


    public function create()
    {
        return view(
            'admin.packages.create'
        );
    }


    public function store(Request $request)
    {

        $imageName = null;

        if($request->hasFile('image')){

            $imageName =
            time().'.'.
            $request->image->extension();

            $request->image->move(
                public_path('packages'),
                $imageName
            );

        }

        Package::create([

            'name' => $request->name,

            'category' => $request->category,

            'price' => $request->price,

            'description' => $request->description,

            'discount' => $request->discount,

            'image' => $imageName,

            'is_active' => true

        ]);

        return redirect('/admin/packages');

    }


    public function edit($id)
    {
        $package =
        Package::findOrFail($id);

        return view(
            'admin.packages.edit',
            compact('package')
        );
    }


    public function update(Request $request, $id)
    {

        $package =
        Package::findOrFail($id);

        $imageName =
        $package->image;

        if($request->hasFile('image')){

            $imageName =
            time().'.'.
            $request->image->extension();

            $request->image->move(
                public_path('packages'),
                $imageName
            );

        }

        $package->update([

            'name' => $request->name,

            'category' => $request->category,

            'price' => $request->price,

            'description' => $request->description,

            'discount' => $request->discount,

            'image' => $imageName

        ]);

        return redirect('/admin/packages');

    }


    public function destroy($id)
    {

        $package =
        Package::findOrFail($id);

        $package->delete();

        return redirect('/admin/packages');

    }

}