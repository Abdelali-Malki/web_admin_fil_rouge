<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Color;

class ColorController extends Controller
{
    public $collectionFolder;

    public function __construct()
    {
        $this->collectionFolder = public_path('images/color');
        if(!file_exists($this->collectionFolder)){
            mkdir($this->collectionFolder);
        }
    }

    public function index()
    {
        return view('color.index');
    }

    public function new(Request $request)
    {
        if($request->isMethod('post')){

            $request->validate([
                'title' => 'required|max:255',
                'photo'=>'required|image|max:4096'
            ],[
                'photo.max'=>'Photo must be within 4 MB'
            ]);

            $model = new Color();
            $model->title = $request->title;

            if($request->photo){
                $imageName = time().'.'.$request->photo->extension();
                $model->photo = $imageName;
            }

            if($model->save()){

                if($request->photo)
                    $request->photo->move($this->collectionFolder, $imageName);

                return redirect(route('color'))->with('success','Color created successfully');
            }

        }

        return view('color.new');
    }

    public function edit(Request $request, $id)
    {
        // dd($request);
        $model = Color::findOrFail($id);

        if($request->isMethod('post')){

            $request->validate([
                'title' => 'required|max:255',
                'photo'=>'image|max:4096'
            ],[
                'photo.max'=>'Photo must be within 4 MB'
            ]);

            $model->title = $request->title;
            $oldImage='';
            if($request->photo){
                $oldImage = $model->photo;
                $imageName = time().'.'.$request->photo->extension();
                $model->photo = $imageName;
            }

            if($model->save()){

                if($request->photo){
                    $request->photo->move($this->collectionFolder, $imageName);
                }

                if($oldImage!='' && file_exists($this->collectionFolder.'/'.$oldImage)){
                    unlink($this->collectionFolder.'/'.$oldImage);
                }

                return redirect(route('color'))->with('success','Color updated successfully');
            }

        }

        return view('color.edit', compact('model'));
    }

    public function data()
    {
        $data = Color::orderBy('created_at', 'desc');

        $this->return = [
            "recordsTotal" => $data->count(),
            "data" => $data->get(),
        ];

        return response()->json($this->return);
    }

    public function delete(Request $request)
    {
        $model = Color::find($request->id);
        if($model){
            if($model->photo!='' && file_exists(public_path('images/color/'.$model->photo))){
                unlink(public_path('images/color/'.$model->photo));
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
