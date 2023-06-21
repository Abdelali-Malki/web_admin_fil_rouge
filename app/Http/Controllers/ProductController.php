<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Collections;
use App\Models\Color;
use App\Models\Products;
use Illuminate\Support\Str;
use App\Models\TagSuggestions;

class ProductController extends Controller
{
    public $tempFolder, $productFolder, $webpFolder;

    public function __construct()
    {
        $this->tempFolder = public_path('images/temp');
        if(!file_exists($this->tempFolder)){
            mkdir($this->tempFolder);
        }

        $this->productFolder = public_path('images/products');
        if(!file_exists($this->productFolder)){
            mkdir($this->productFolder);
        }

        $this->webpFolder = public_path('images/products/webp');
        if(!file_exists($this->webpFolder)){
            mkdir($this->webpFolder);
        }

    }

    public function index()
    {
        return view('product.index');
    }

    public function new(Request $request)
    {
        $data['collections'] = Collections::pluck('name','id');
        $data['colors'] = Color::pluck('title','id');

        if($request->isMethod('post')){

            $request->validate([
                'name' => 'required|max:255',
                'photo' => 'required',
                'collections'=>'required',
                'colors'=>'required'
            ]);

            $model = new Products();
            $model->name = $request->name;
            $model->description = $request->description;
            $model->photo = $request->photo;
            if(is_array(@$request->collections) && count($request->collections)>0){
                $model->collections = implode(',',$request->collections);
                $model->collections_name = Products::genCollectionName($model->collections);
            }

            if(is_array(@$request->colors) && count($request->colors)>0){
                $model->colors = implode(',',$request->colors);
                $model->colors_name = Products::genColorName($model->colors);
            }

            if($request->tags!=''){
                $tags = json_decode($request->tags, true);
                $ftag=[];

                if(is_array($tags) && count($tags)>0){
                    foreach($tags as $k=>$tag):
                        $ftag[] = Str::slug($tag['value']);
                    endforeach;
                }

                if(count($ftag)>0){
                    $model->tags = implode(",",$ftag);
                }

            }

            $model->status = intval($request->status);

            if($model->save()){

                if($model->tags!=NULL){
                    TagSuggestions::generate($ftag);
                }

                $this->return = [
                    "status" => 'success'
                ];

                if(file_exists($this->tempFolder).'/'.$model->photo){
                    if(rename($this->tempFolder.'/'.$model->photo, $this->productFolder.'/'.$model->photo)){
                        $imagine = new \Imagine\Gd\Imagine();
                        $image = $imagine->open($this->productFolder.'/'.$model->photo);

                        $img1 = $image->resize(new \Imagine\Image\Box(600, 1334));
                        $img1->save($this->webpFolder.'/'.$model->photo.'.webp');

                        $img2 = $image->resize(new \Imagine\Image\Box(1200, 2667));
                        $img2->save($this->webpFolder.'/'.$model->photo.'2.webp');

                        $img2 = $image->resize(new \Imagine\Image\Box(25, 56));
                        $img2->save($this->webpFolder.'/'.$model->photo.'0.webp');
                    }
                }

                $request->session()->flash('success', 'Wallpaper insert successfully.');

            }else{
                $this->return = [
                    "status" => 'error'
                ];
            }

            return response()->json($this->return);

        }

        return view('product.new', compact('data'));
    }

    public function edit(Request $request, $id)
    {
        $model = Products::findOrFail($id);
        $data['collections'] = Collections::pluck('name','id');
        $data['colors'] = Color::pluck('title','id');

        if($request->isMethod('post')){

            $request->validate([
                'name' => 'required|max:255',
                'photo' => 'required',
                'collections'=>'required',
                'colors'=>'required'
            ]);

            $model->name = $request->name;
            $model->description = $request->description;

            if(is_array(@$request->collections) && count($request->collections)>0){
                $model->collections = implode(',',$request->collections);
                $model->collections_name = Products::genCollectionName($model->collections);
            }

            if(is_array(@$request->colors) && count($request->colors)>0){
                $model->colors = implode(',',$request->colors);
                $model->colors_name = Products::genColorName($model->colors);
            }

            if($request->tags!=''){
                $tags = json_decode($request->tags, true);
                $ftag=[];

                if(is_array($tags) && count($tags)>0){
                    foreach($tags as $k=>$tag):
                        $ftag[] = Str::slug($tag['value']);
                    endforeach;
                }

                if(count($ftag)>0){
                    $model->tags = implode(",",$ftag);
                }

            }

            $model->status = intval($request->status);

            $oldImage='';
            if($request->photo){
                $oldImage = $model->photo;
                $model->photo = $request->photo;
            }

            if($model->save()){

                if($model->tags!=NULL){
                    TagSuggestions::generate($ftag);
                }

                if($request->photo!='' && $oldImage!='' && ($request->photo!=$oldImage)  && file_exists($this->productFolder.'/'.$oldImage)){
                    unlink($this->productFolder.'/'.$oldImage);

                    if(file_exists($this->webpFolder.'/'.$oldImage.'.webp')){
                        unlink($this->webpFolder.'/'.$oldImage.'.webp');
                    }
                    if(file_exists($this->webpFolder.'/'.$oldImage.'2.webp')){
                        unlink($this->webpFolder.'/'.$oldImage.'2.webp');
                    }
                    if(file_exists($this->webpFolder.'/'.$oldImage.'0.webp')){
                        unlink($this->webpFolder.'/'.$oldImage.'0.webp');
                    }
                }

                if(($request->photo!=$oldImage) && file_exists($this->tempFolder).'/'.$model->photo){
                    if(rename($this->tempFolder.'/'.$model->photo, $this->productFolder.'/'.$model->photo)){
                        $imagine = new \Imagine\Gd\Imagine();
                        $image = $imagine->open($this->productFolder.'/'.$model->photo);

                        //$img1 = $image->resize(new \Imagine\Image\Box(220, 489));
                        $img1 = $image->resize(new \Imagine\Image\Box(600, 1334));
                        $img1->save($this->webpFolder.'/'.$model->photo.'.webp');

                        $img2 = $image->resize(new \Imagine\Image\Box(1200, 2667));
                        $img2->save($this->webpFolder.'/'.$model->photo.'2.webp');

                        $img2 = $image->resize(new \Imagine\Image\Box(25, 56));
                        $img2->save($this->webpFolder.'/'.$model->photo.'0.webp');
                    }
                }

                $this->return = [
                    "status" => 'success'
                ];

                $request->session()->flash('success', 'Wallpaper updated successfully.');

            }else{
                $this->return = [
                    "status" => 'error'
                ];
            }

            return response()->json($this->return);

        }

        return view('product.edit', compact('model', 'data'));
    }

    public function data(Request $request)
    {
        $info = Products::orderBy('created_at', 'desc');

        if ($request->search['value'] != '') {
            $info = $info->where('name', 'LIKE', '%' . $request->search['value'] . '%');
            $info = $info->orWhere('collections_name', 'LIKE', '%' . $request->search['value'] . '%');
            $info = $info->orWhere('tags', 'LIKE', '%' . $request->search['value'] . '%');
            $info = $info->orWhere('description', 'LIKE', '%' . $request->search['value'] . '%');
        }

        $count = $info->count();

        $data = $info->offset($request->start)->limit($request->length)->get();

        $this->return = [
            "recordsTotal" => $count,
            "recordsFiltered" =>  $count,
            "data" => $data,
        ];

        return response()->json($this->return);
    }

    public function getCollectionName(Request $request)
    {
        if($request->ids!='')
        {
            $ids = explode(',',$request->ids);
            $msg = [];
            foreach($ids as $id):
                if($f=Collections::find(trim($id)))
                    $msg[]=$f->name;
            endforeach;

            if(count($msg)>0){
                $msg = implode(', ',$msg);
            }else{
                $msg = "-";
            }

            return response()->json([
                'status'=>'success',
                'message'=>$msg
            ]);
        }

        return response()->json([
            'status'=>'error'
        ]);
    }

    public function delete(Request $request)
    {
        $model = Products::find($request->id);
        if($model){
            if($model->photo!='' && file_exists($this->productFolder.'/'.$model->photo)){
                unlink($this->productFolder.'/'.$model->photo);
            }

            if($model->photo!='' && file_exists($this->webpFolder.'/'.$model->photo.'.webp')){
                unlink($this->webpFolder.'/'.$model->photo.'.webp');
            }
            if($model->photo!='' && file_exists($this->webpFolder.'/'.$model->photo.'2.webp')){
                unlink($this->webpFolder.'/'.$model->photo.'2.webp');
            }
            if($model->photo!='' && file_exists($this->webpFolder.'/'.$model->photo.'0.webp')){
                unlink($this->webpFolder.'/'.$model->photo.'0.webp');
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

    public function tempImageUpload(Request $request)
    {
        $this->return = [
            "status" => 'error'
        ];

        if($request->croppedImage){

            $request->validate([
                'croppedImage' => 'required|image|max:5120',
            ], [
                'croppedImage.max'=>'Cropped image must be within 5 MB'
            ]);

            $imageName = time().'.'.$request->croppedImage->extension();
            $request->croppedImage->move($this->tempFolder, $imageName);
            $this->return = [
                "status" => 'success',
                "image" => $imageName
            ];
        }

        return response()->json($this->return);
    }

    public function generateWebp(Request $request, $id=NULL){

        if($id==NULL)
            $models = Products::all();
        else
            $models = Products::where('id',$id)->get();

        $i=0;
        foreach($models as $model):
            if($model->photo!='' && file_exists($this->productFolder.'/'.$model->photo)){
                $imagine = new \Imagine\Gd\Imagine();
                $image = $imagine->open($this->productFolder.'/'.$model->photo);

                $img1 = $image->resize(new \Imagine\Image\Box(600, 1334));
                $img1->save($this->webpFolder.'/'.$model->photo.'.webp');

                $img2 = $image->resize(new \Imagine\Image\Box(1200, 2667));
                $img2->save($this->webpFolder.'/'.$model->photo.'2.webp');

                $img2 = $image->resize(new \Imagine\Image\Box(25, 56));
                $img2->save($this->webpFolder.'/'.$model->photo.'0.webp');
                $i++;
            }
        endforeach;

        dd($i);
    }

    public function generateTagSuggestions(){
        $models = Products::all();
        $count=0;
        foreach($models as $model):
            if($model->tags!=NULL){
                $tag = explode(',',$model->tags);
                $rc = TagSuggestions::generate($tag);
                $count += $rc;
            }
        endforeach;
        dd($count.' Tag inserted on suggestions list');
    }
}
