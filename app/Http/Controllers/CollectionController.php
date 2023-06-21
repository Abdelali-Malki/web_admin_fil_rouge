<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Collections;

class CollectionController extends Controller
{
    public $collectionFolder;

    public function __construct()
    {
        $this->collectionFolder = public_path('images/collections');
        if(!file_exists($this->collectionFolder)){
            mkdir($this->collectionFolder);
        }
    }

    public function index()
    {
        return view('collection.index');
    }

    public function new(Request $request)
    {

        if($request->isMethod('post')){

            $request->validate([
                'name' => 'required|max:255',
                'cover_photo'=>'required|image|max:4096'
            ],[
                'cover_photo.max'=>'Cover photo must be within 4 MB'
            ]);

            $model = new Collections();
            $model->name = $request->name;
            $model->description = $request->description;

            if($request->cover_photo){
                $imageName = time().'.'.$request->cover_photo->extension();
                $model->cover_photo = $imageName;
            }

            if($model->save()){

                if($request->cover_photo)
                    $request->cover_photo->move($this->collectionFolder, $imageName);

                return redirect(route('collections'))->with('success','Categories created successfully');
            }

        }

        return view('collection.new');
    }

    public function edit(Request $request, $id)
    {
        $model = Collections::findOrFail($id);

        if($request->isMethod('post')){

            $request->validate([
                'name' => 'required|max:255',
                'cover_photo'=>'image|max:4096'
            ],[
                'cover_photo.max'=>'Cover photo must be within 4 MB'
            ]);

            $model->name = $request->name;
            $model->description = $request->description;

            $oldImage='';
            if($request->cover_photo){
                $oldImage = $model->cover_photo;
                $imageName = time().'.'.$request->cover_photo->extension();
                $model->cover_photo = $imageName;
            }

            if($model->save()){

                if($request->cover_photo){
                    $request->cover_photo->move($this->collectionFolder, $imageName);
                }

                if($oldImage!='' && file_exists($this->collectionFolder.'/'.$oldImage)){
                    unlink($this->collectionFolder.'/'.$oldImage);
                }

                return redirect(route('collections'))->with('success','Categories updated successfully');
            }

        }

        return view('collection.edit', compact('model'));
    }

    public function data()
    {
        $data = Collections::orderBy('created_at', 'desc');

        $this->return = [
            "recordsTotal" => $data->count(),
            "data" => $data->get(),
        ];

        return response()->json($this->return);
    }

    public function delete(Request $request)
    {
        $model = Collections::find($request->id);
        if($model){
            if($model->cover_photo!='' && file_exists(public_path('images/collections/'.$model->cover_photo))){
                unlink(public_path('images/collections/'.$model->cover_photo));
            }
            if($model->delete()){
                return response()->json([
                    'status'=>'success'
                ]);
            }
        }
        return response()->json([
            'status'=>'error'
        ]);
    }
}
