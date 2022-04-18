<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(file_exists(storage_path('\app\public/contacts.json'))){
            // Read File
            $jsonString = file_get_contents(storage_path('\app\public/contacts.json'));

            $data = json_decode($jsonString, true);
        }else{
            return "No file is available!";
        }

        return view('welcome', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'email' => 'required',

        ]);

        if(file_exists(storage_path('\app\public/contacts.json')))
        {
            $final_data= $this->fileWriteAppend();
            if(file_put_contents(storage_path('\app\public/contacts.json'), $final_data))
            {
                $message = "<label class='text-success'>Data added Success fully</p>";
            }
        }
        else
        {
            $final_data= $this->fileCreateWrite();
            if(file_put_contents(storage_path('\app\public/contacts.json'), $final_data))
            {
                $message = "<label class='text-success'>File created and  data added Successfully</p>";
            }

        }


        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(file_exists(storage_path('\app\public/contacts.json'))){
            // Read File
            $jsonString = file_get_contents(storage_path('\app\public/contacts.json'));

            $collection = collect(json_decode($jsonString, true));

            $data = $collection->get($id);



        }else{
            return "No file is available!";
        }



        return view('view-contact', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    /**
     * @return false|string
     */
    private function fileWriteAppend()
    {
        $current_data = file_get_contents(storage_path('\app\public/contacts.json'));
        $array_data = json_decode($current_data, true);
        $extra = array(
            'first_name'               =>     $_POST["first_name"],
            'last_name'          =>     $_POST["last_name"],
            'phone'          =>     $_POST["phone"],
            'email'     =>     $_POST["email"],

        );
        $array_data[] = $extra;
        $final_data = json_encode($array_data, JSON_PRETTY_PRINT);
        return $final_data;
    }

    private function fileCreateWrite()
    {
        $file=fopen((storage_path('\app\public/contacts.json')),"w");
        $array_data=array();
        $extra = array(
            'name'               =>     $_POST['name'],
            'gender'          =>     $_POST["gender"],
            'age'          =>     $_POST["age"],
            'education'     =>     $_POST["education"],
            'designation'     =>     $_POST["designation"],
            'dob'     =>     $_POST["dob"]

        );
        $array_data[] = $extra;
        $final_data = json_encode($array_data, JSON_PRETTY_PRINT);
        fclose($file);
        return $final_data;
    }
}
