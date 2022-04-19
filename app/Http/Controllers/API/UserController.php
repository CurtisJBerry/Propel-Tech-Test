<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Session;
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
        if(file_exists(storage_path('\app\public\contacts.json'))){
            // Read File
            $jsonString = file_get_contents(storage_path('\app\public\contacts.json'));

            $data = json_decode($jsonString, true);

            $data = collect($data);


            return view('welcome', compact('data'));
        }else{
            Session::flash('error','No file found!');
            return view('welcome');
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
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

        if(file_exists(storage_path('\app\public\contacts.json')))
        {
            $final_data= $this->fileWriteAppend();
            if(file_put_contents(storage_path('\app\public\contacts.json'), $final_data))
            {
                $message = "Contact added successfully";
            }
        }
        else
        {
            $final_data= $this->fileCreateWrite();
            if(file_put_contents(storage_path('\app\public\contacts.json'), $final_data))
            {
                $message = "File created and contact added successfully";
            }

        }


        return redirect()->route('users.index')->with('message', $message);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(file_exists(storage_path('\app\public\contacts.json'))){
            // Read File
            $jsonString = file_get_contents(storage_path('\app\public\contacts.json'));

            $collection = collect(json_decode($jsonString, true));

            $data = $collection->get($id);

            return view('view-contact', compact('data'));

        }else{
            return back()->with('error', 'Record could not be shown.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'email' => 'required',

        ]);

        if(file_exists(storage_path('\app\public\contacts.json')))
        {
            //decode json to array
            $json = json_decode(file_get_contents(storage_path('\app\public\contacts.json')),true);

            foreach ($json as $key => $value) {
                if ($key == $id) {
                    $json[$key]['first_name'] = $request->first_name;

                    // encode array to json and save to file
                    file_put_contents(storage_path('\app\public\contacts.json'), json_encode($json, JSON_PRETTY_PRINT));

                    return redirect()->route('users.index')->with('message', 'Contact Updated');
                }
            }

        }
        else
        {
            return back()->with('error', 'Record could not be updated!');
        }



    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(file_exists(storage_path('\app\public\contacts.json')))
        {
            //decode json to array
            $json = json_decode(file_get_contents(storage_path('\app\public\contacts.json')),true);

            // get array index to delete
            $arr_index = array();
            foreach ($json as $key => $value) {
                if ($key == $id) {
                    $arr_index[] = $key;
                }
            }

            // delete data
            foreach ($arr_index as $i)
            {
                unset($json[$i]);
            }

            // rebase array
            $json = array_values($json);

            // encode array to json and save to file
            file_put_contents(storage_path('\app\public\contacts.json'), json_encode($json, JSON_PRETTY_PRINT));

            return redirect()->route('users.index')->with('message', 'Contact Deleted');

        }
        else
        {
            return back()->with('error', 'Record could not be updated!');
        }

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
        return json_encode($array_data, JSON_PRETTY_PRINT);
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
