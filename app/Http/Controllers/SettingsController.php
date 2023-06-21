<?php

namespace App\Http\Controllers;

use App\Models\Collections;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use File;
use Auth;
use Illuminate\Support\Facades\Hash;
use Validator;

class SettingsController extends Controller
{

    public $return;
    public function __construct(){
        $this->return=["status"=>"error"];
    }

    public function appSettings()
    {
        return view('settings.app.index');
    }

    public function appSettingsUpdate(Request $request)
    {
        $path = base_path('.env');
        $file = File::get($path, 'w');
        $new_content = '';

        if($request->isMethod('post')){

            $request->validate([
                'admin_logo'=>'image|max:4096',
                'fav_icon'=>'image|max:1024',
                'recent'=>'image|max:4096',
                'most_popular'=>'image|max:4096',
            ],[
                'admin_logo.max'=>'Cover photo must be within 4 MB',
                'fav_icon.max'=>'Favicon must be within 1 MB',
                'recent.max'=>'Cover photo must be within 4 MB',
                'most_popular.max'=>'Cover photo must be within 4 MB',
            ]);


            if (count($request->settings_key) > 0):
                for ($i = 0; $i < count($request->settings_key); $i++) {

                    $file = File::get($path, 'w');
                    if($request->settings_key[$i]=='ABOUT_US_LINK' || $request->settings_key[$i]=='PRIVACY_POLICY_DATA'){
                        $new_content = str_replace($request->settings_key[$i] . '=' . '"' . env($request->settings_key[$i]) . '"', $request->settings_key[$i] . '=' . '"' . \urlencode($request->settings_val[$i]) . '"', $file);
                    }else{
                        $new_content = str_replace($request->settings_key[$i] . '=' . '"' . env($request->settings_key[$i]) . '"', $request->settings_key[$i] . '=' . '"' . $request->settings_val[$i] . '"', $file);
                    }

                    File::put($path, $new_content);
                }
            endif;

            if($request->hasFile('admin_logo')){
                $file = $request->file('admin_logo');
                $name = $file->getClientOriginalName();
                $file->move(public_path()."/"."upload", $name);
                $file = File::get($path, 'w');
                $new_img = str_replace('ADMIN_LOGO=' . '"' . env("ADMIN_LOGO") . '"', 'ADMIN_LOGO=' . '"' . "$name" . '"', $file);
                File::put($path, $new_img);
            }

            if($request->hasFile('fav_icon')){
                $file = $request->file('fav_icon');
                $name = $file->getClientOriginalName();
                $file->move(public_path()."/"."upload", $name);
                $file = File::get($path, 'w');
                $new_img = str_replace('FAV_ICON=' . '"' . env("FAV_ICON") . '"', 'FAV_ICON=' . '"' . "$name" . '"', $file);
                File::put($path, $new_img);
            }

            if($request->hasFile('recent')){
                $file = $request->file('recent');
                $name = $file->getClientOriginalName();
                $file->move(public_path()."/"."upload", $name);
                $file = File::get($path, 'w');
                $new_img = str_replace('RECENT=' . '"' . env("RECENT") . '"', 'RECENT=' . '"' . "$name" . '"', $file);
                File::put($path, $new_img);
            }

            if($request->hasFile('most_popular')){
                $file = $request->file('most_popular');
                $name = $file->getClientOriginalName();
                $file->move(public_path()."/"."upload", $name);
                $file = File::get($path, 'w');
                $new_img = str_replace('MOST_POPULAR=' . '"' . env("MOST_POPULAR") . '"', 'MOST_POPULAR=' . '"' . "$name" . '"', $file);
                File::put($path, $new_img);
            }


        }

        return redirect(route('app_settings'))->with('message','App settings updated successfully');
    }

    public function updateProfile()
    {
        $user = User::findOrFail(Auth::user()->id);
        return view('settings.profile.form', compact('user'));
    }

    public function updateProfileupdate(Request $request)
    {
        $validator = null;
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);
        if ($validator->fails()) {
            $this->return = [
                "status" => "error",
                "errors" => $validator->errors(),
            ];
        } else {
            $name = $request->name;
            $email = $request->email;

            $user = User::findOrFail(Auth::user()->id);
            $user->name = $name;
            $user->email = $email;
            if ($user->save()) {
                $this->return = [
                    "status" => "success",
                    "message" => "Profile changed successfully.",
                ];
            }else {
                $this->return = [
                    "status" => "error",
                    "message" => "Something is wrong, please contact with the support",
                ];
            }

        }

        return response()->json($this->return);
    }

    public function adsSettings()
    {
        return view('settings.ads.index');
    }

    public function adsSettingsUpdate(Request $request)
    {

        $path = base_path('.env');
        $file = File::get($path, 'w');
        $new_content = '';

        if (count($request->settings_key) > 0):
            for ($i = 0; $i < count($request->settings_key); $i++) {

                $file = File::get($path, 'w');

                $new_content = str_replace($request->settings_key[$i] . '=' . '"' . env($request->settings_key[$i]) . '"', $request->settings_key[$i] . '=' . '"' . $request->settings_val[$i] . '"', $file);

                File::put($path, $new_content);
            }
        endif;

        if($request->ADD_BANNER_ADD_STATUS){
            $file = File::get($path, 'w');
            $new_content = str_replace('ADD_BANNER_ADD_STATUS=' . '"' . env('ADD_BANNER_ADD_STATUS') . '"', 'ADD_BANNER_ADD_STATUS=' . '"' . $request->ADD_BANNER_ADD_STATUS . '"', $file);
            File::put($path, $new_content);
        }

        if($request->ADD_MOBILE_ADD_STATUS){
            $file = File::get($path, 'w');
            $new_content = str_replace('ADD_MOBILE_ADD_STATUS=' . '"' . env('ADD_MOBILE_ADD_STATUS') . '"', 'ADD_MOBILE_ADD_STATUS=' . '"' . $request->ADD_MOBILE_ADD_STATUS . '"', $file);
            File::put($path, $new_content);
        }

        return redirect(route('ads_settings'))->with('message','Ads settings updated successfully');
    }

    public function changePassword(Request $request)
    {

        $validator = null;
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|min:4',
            'confirm_password' => 'required|min:4',
            'new_password' => 'required|min:4',
        ]);
        if ($validator->fails()) {
            $this->return = [
                "status" => "error",
                "errors" => $validator->errors(),
            ];
        } else {
            $current_password = $request->current_password;
            $confirm_password = $request->confirm_password;
            $new_password = $request->new_password;
            if ($confirm_password == $new_password) {
                $user = User::findOrFail(Auth::user()->id);
                if (Hash::check($request->current_password, $user->password)) {
                    $user->password = bcrypt($new_password);
                    if ($user->save()) {
                        $this->return = [
                            "status" => "success",
                            "message" => "Password changed successfully.",
                        ];
                    }
                } else {
                    $this->return = [
                        "status" => "error",
                        "message" => "Current password doesn't match.",
                    ];
                }
            } else {
                $this->return = [
                    "status" => "error",
                    "message" => "New password and confirm password doesn't match.",
                ];
            }
        }

        return response()->json($this->return);
    }

    public function savePush(Request $r)
    {
        $validator = null;
        $validator = Validator::make($r->all(), [
            'title' => 'required',
            'description' => 'required',
            'collection' => 'required',
        ]);
        if ($validator->fails()) {
            $this->return = [
                "status" => "error",
                "errors" => $validator->errors(),
            ];
        } else {
            $title = $r->title;
            $description = $r->description;
            $collection = $r->collection;
            $cname = @Collections::find($collection)->name;
            if($cname==''){
                $cname='0';
                $cid = 0;
            }else{
                $cid=$collection;
            }

            $collection_name = $cname;
            $model = new Notification();
            $model->title = $title;
            $model->collection = $cid;
            $model->description = $description;

            if($model->save()){
                $curl = curl_init();
                curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://fcm.googleapis.com/fcm/send',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS =>'{
                    "to":"/topics/AllUser",
                    "data": {
                        "id": "'.$collection.'",
                        "name": "'.$collection_name.'"
                       },
                        "notification": {
                            "body": "'.$description.'",
                            "title": "'.$title.'",
                            "click_action":"'.$collection.'"
                        }
                    }',
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/json',
                        'Authorization:key='.env("NOTIFICATION_AUTHORIZATION_KEY")
                    ),
                ));


                $response = curl_exec($curl);

                curl_close($curl);
                // echo $response;

                $this->return =[
                    "status"=>"success",
                    "id"=>$response,
                    "message"=>"Push notification send successfully."
                ];

            }

        }
        return response()->json($this->return);
    }

    public function notificationHistory()
    {
       $collections = Collections::all();

       return view('notification.index',compact('collections'));
    }

    public function notificationData(Request $request)
    {
        $info = Notification::orderBy('created_at', 'desc');

        if ($request->search['value'] != '') {
            $info = $info->where('title', 'LIKE', '%' . $request->search['value'] . '%');
        }

        $count = $info->count();

        $data = $info->with("collection_name")->offset($request->start)->limit($request->length)->get();

        $this->return = [
            "recordsTotal" => $count,
            "recordsFiltered" =>  $count,
            "data" => $data,
        ];

        return response()->json($this->return);
    }
}
