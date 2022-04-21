<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Session;
use function PHPUnit\Framework\isEmpty;

class UserController extends Controller
{
    /**
     * Get the json data from the given filepath
     * @return string
     */
    public function getData(): string
    {
        return storage_path('\app\public\contacts.json');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (file_exists($this->getData())) {
            // Read File
            $jsonString = file_get_contents($this->getData());

            $data = json_decode($jsonString, true);

            $data = collect($data);

            $data = $data->paginate(10);

        } else {
            Session::flash('error', 'No file found!');

            $data = collect();
        }
        return view('welcome', compact('data'));

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
            'first_name' => 'required|max:20',
            'last_name' => 'required|max:20',
            'phone' => 'required|max:12',
            'email' => 'required|max:30',

        ]);

        if (file_exists($this->getData())) {
            $final_data = $this->fileWriteAppend();
            if (file_put_contents($this->getData(), $final_data)) {
                $message = "Contact added successfully";
            }
        } else {
            $final_data = $this->fileCreateWrite();
            if (file_put_contents($this->getData(), $final_data)) {
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
        if (file_exists($this->getData())) {
            // Read File
            $jsonString = file_get_contents($this->getData());

            $collection = collect(json_decode($jsonString, true));

            $data = $collection->get($id);

            if(!empty($data)){

                return view('view-contact', compact('data'));

            }else{
                return back()->with('error', 'The given id could not be found');
            }

        } else {
            return back()->with('error', 'Record could not be shown.');
        }
    }

    /**
     * Display the record to be updated.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function updateRecord($id)
    {
        if (file_exists($this->getData())) {
            // Read File
            $jsonString = file_get_contents($this->getData());

            $collection = collect(json_decode($jsonString, true));

            $data = $collection->get($id);

            if(!empty($data)){

                return view('update-contact', compact('data', 'id'));

            }else{
                return back()->with('error', 'The given id could not be found');
            }

        } else {
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
            'last_name' => 'required|max:20',
            'phone' => 'required|max:12',
            'email' => 'required|max:30',
        ]);

        if (file_exists($this->getData())) {
            //decode json to array
            $json = json_decode(file_get_contents($this->getData()), true);

            foreach ($json as $key => $value) {
                if ($key == $id) {
                    $json[$key]['first_name'] = $request->first_name;
                    $json[$key]['last_name'] = $request->last_name;
                    $json[$key]['phone'] = $request->phone;
                    $json[$key]['email'] = $request->email;

                    // encode array to json and save to file
                    file_put_contents($this->getData(), json_encode($json, JSON_PRETTY_PRINT));

                    return redirect()->route('users.index')->with('message', 'Contact Updated');

                }elseif(!array_key_exists($id, $json)){

                    return back()->with('error', 'Record could not be updated!');
                }
            }

        } else {
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
        if (file_exists($this->getData())) {
            //decode json to array
            $json = json_decode(file_get_contents($this->getData()), true);

            // get array index to delete
            $arr_index = array();
            foreach ($json as $key => $value) {
                if ($key == $id) {
                    $arr_index[] = $key;
                }
            }

            if(empty($arr_index)){
                return back()->with('error', 'Record could not be deleted!');
            }

            // delete data
            foreach ($arr_index as $i) {
                unset($json[$i]);
            }

            // rebase array
            $json = array_values($json);

            // encode array to json and save to file
            file_put_contents($this->getData(), json_encode($json, JSON_PRETTY_PRINT));

            return redirect()->route('users.index')->with('message', 'Contact Deleted');

        } else {
            return back()->with('error', 'Record could not be deleted!');
        }

    }

    /**
     * @param Request $request
     * @return Application|Factory|View|RedirectResponse
     */
    public function search(Request $request)
    {
        $request->validate([
            'value' => 'required',
        ]);

        $searchValue = $request->value;

        if (file_exists($this->getData())) {
            // Read File
            $jsonString = file_get_contents($this->getData());

            $collection = collect(json_decode($jsonString, true));

            foreach ($collection as $key => $value) {
                foreach ($value as $keyval => $val) {
                    $data = $collection->reject(function ($element) use ($searchValue, $keyval) {
                        return (stripos(strtolower($element[$keyval]), strtolower($searchValue)) === false);
                    });
                }
            }

            if ($data->isEmpty()){
                return back()->with('error', 'No matching records could be found');
            }else{
                $data = $data->paginate(5);
                return view('search-contact', compact('data'));
            }

        } else {
            return back()->with('error', 'Record could not be found');
        }
    }

    /**
     * @return false|string
     */
    private function fileWriteAppend()
    {
        $current_data = file_get_contents($this->getData());
        $array_data = json_decode($current_data, true);
        $extra = array(
            'first_name' => $_POST["first_name"],
            'last_name' => $_POST["last_name"],
            'phone' => $_POST["phone"],
            'email' => $_POST["email"],

        );
        $array_data[] = $extra;
        return json_encode($array_data, JSON_PRETTY_PRINT);
    }

    /**
     * @return false|string
     */
    private function fileCreateWrite()
    {
        $file = fopen(($this->getData()), "w");
        $array_data = array();
        $extra = array(
            'first_name' => $_POST["first_name"],
            'last_name' => $_POST["last_name"],
            'phone' => $_POST["phone"],
            'email' => $_POST["email"],

        );
        $array_data[] = $extra;
        $final_data = json_encode($array_data, JSON_PRETTY_PRINT);
        fclose($file);
        return $final_data;
    }
}
