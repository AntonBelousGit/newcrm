<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\AddressesListImport;
use App\Models\AddressesList;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;

class AddressesListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::check('Client')) {
            $addresses = AddressesList::where('user_id', Auth::id())->get();
            return view('backend.addresses_list.index', compact('addresses'));
        }
        if (Gate::check('Administration')) {
            $addresses = AddressesList::with('user')->get();
            return view('backend.addresses_list.index', compact('addresses'));
        }
        return abort(403);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::any(['Administration', 'Client'], Auth::user())) {
            return view('backend.addresses_list.create');
        }
        return abort(403);
    }

    public function search(Request $request)
    {
        if (Gate::any(['Administration', 'Client'], Auth::user()) && $request->ajax()) {

            $output = "";
            $addresses = AddressesList::where('address', 'like', '%' . $request->search . '%')->get(['address']);
//            dd($addresses);
            if (!$addresses->isEmpty()) {
                $output .= '<ul>';
                foreach ($addresses as $address) {
                    $output .= '<li onclick="clickItem(this)">' . $address->address . '</li>';
                }
                $output .= '</ul>';
            } else {
                $output = "<ul><li>Nothing found</li></ul>";
            }

            return Response($output);
        }
        return abort(403);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Gate::check('Administration') || Gate::check('Client')) {

            $validated_data = $this->validate($request, [
                'address' => 'required|string|unique:addresses_lists',
            ],
                ['unique' => 'The address has already exists.']);

            $address = new AddressesList;
            $address->fill($validated_data);
            $address->user_id = Auth::id();
            $address->save();

            return redirect()->route('admin.addresses-list.index');
        }
        return abort(403);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     */
    public function edit($id)
    {
        $addresses = AddressesList::with('user')->findOrFail($id);

//        dd($addresses);
        if (Gate::check('Client') && Gate::check('manage-client-address', $addresses)) {
            return view('backend.addresses_list.edit', compact('addresses'));
        }
        if (Gate::check('Administration')) {
            return view('backend.addresses_list.edit', compact('addresses'));
        }
        return abort(403);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $addresses = AddressesList::findOrFail($id);
        if (Gate::check('Administration') || (Gate::check('Client') && Gate::check('manage-client-address', $addresses))) {

            $addresses->address = $request->address;
            $addresses->update();

            return redirect()->route('admin.addresses-list.index');
        }
        return abort(403);
    }

    public function viewImport()
    {
        if (Gate::check('Administration') || Gate::check('Client')) {
            return view('backend.addresses_list.import');
        }
        return abort(403);
    }

    public function import(Request $request)
    {

        if ($request->isMethod('post') && $_FILES['file']) {

            if ($_FILES['file']['error'] == 0) {
                //> Получаем имя загружаемого файла (удобно судить, нужен ли для загрузки файл суффикса)
                $name = $_FILES['file']['name'];
                //> Получить суффикс загруженного файла, например (xls exe xlsx и т. Д.)
                $ext = strtolower(trim(substr($name, (strpos($name, '.') + 1))));
                //> Определить, является ли файл указанным суффиксом загружаемого файла
                if (!in_array($ext, array('xls', 'xlsx'))) {
                    //> Вернуться в последнее запрошенное место с сообщением об ошибке
                    return redirect()->back()->withErrors('Пожалуйста, введите файл суффикса xls или xlsx')->withInput();
                }
                Excel::import(new AddressesListImport, request()->file('file'));
            }
        }
        return redirect()->route('admin.addresses-list.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
