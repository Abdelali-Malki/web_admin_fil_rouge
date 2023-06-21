<?php

namespace App\Modules\Install\Controller;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use File;
use Symfony\Component\HttpFoundation\Session\Session;
use Illuminate\Support\Facades\Redirect;

class InstallController extends Controller
{
    public function __construct()
    {
       //
    }

    public function index()
    {
        return view('views.check-connection');
    }

    public function check(Request $request)
    {
        $request->validate([
            'host_name' => 'required',
            'database' => 'required',
            'user_name' => 'required',
        ]);

        $hostname_db = $request->host_name;
        $database = $request->database;
        $username = $request->user_name;
        $password = $request->password;

        try{
            if (mysqli_connect($hostname_db, $username, $password,$database))
            {
                $conn = mysqli_connect($hostname_db, $username, $password,$database);

                $db = public_path()."/db/"."db.sql";

                $lines = file($db);
                $no_of_lines = count(file($db));
                $tempLine = '';
                $path = base_path('.env');
                $i = 0;
                foreach ($lines as $line) {
                    $t[] =$i;
                    // Skip it if it's a comment
                    if (substr($line, 0, 2) == '--' || $line == '')
                        continue;
                    // Add this line to the current segment
                    $tempLine .= $line;
                    // If its semicolon at the end, so that is the end of one query
                    if (substr(trim($line), -1, 1) == ';')  {
                        // Perform the query
                        mysqli_query($conn, $tempLine) or print("Error in ");
                        // Reset temp variable to empty
                        $tempLine = '';
                    }
                    $i++;
                }


                if(count($t) == $no_of_lines){

                    if($database){
                        $file = File::get($path, 'w');
                        $new_db = str_replace('DB_DATABASE=' . '"' . env("DB_DATABASE") . '"', 'DB_DATABASE=' . '"' . "$database" . '"', $file);
                        File::put($path, $new_db);
                    }
                    if($hostname_db){
                        $file = File::get($path, 'w');
                        $new_db = str_replace('DB_HOST=' . '"' . env("DB_HOST") . '"', 'DB_HOST=' . '"' . "$hostname_db" . '"', $file);
                        File::put($path, $new_db);
                    }
                    if($username){
                        $file = File::get($path, 'w');
                        $new_db = str_replace('DB_USERNAME=' . '"' . env("DB_USERNAME") . '"', 'DB_USERNAME=' . '"' . "$username" . '"', $file);
                        File::put($path, $new_db);
                    }

                    if($password){
                        $file = File::get($path, 'w');
                        $new_db = str_replace('DB_PASSWORD=' . '"' . env("DB_PASSWORD") . '"', 'DB_PASSWORD=' . '"' . "$password" . '"', $file);
                        File::put($path, $new_db);
                    }
                }

                return redirect()->route("register",['register'=>true])->with("message",'Your database configuration system updated successfully');
            }
            else
            {
                throw new Exception('Unable to connect');
            }
        }
        catch(Exception $e)
        {
            return redirect()->route('install',["step"=>"2","host"=>$hostname_db,"database"=>$database,"username"=>$username,"password"=>$password])->with('message',"Something went wrong please check your database connection information");
        }
    }
}
