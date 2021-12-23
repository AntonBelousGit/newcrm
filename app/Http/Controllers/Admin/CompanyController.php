<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CargoLocation;
use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::with('location')->get();
        return view('backend.company.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $locations = CargoLocation::all();
        $without_agent_company = User::doesnthave('companyAgent')->agent()->get(['id', 'fullname']);
        $without_driver_company = User::doesnthave('companyDriver')->driver()->get(['id', 'fullname']);

        return view('backend.company.create', compact('locations', 'without_agent_company', 'without_driver_company'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        $validated_data = $this->validate($request, [
            'name' => 'required|string|unique:companies,name',
            'phone' => 'nullable|string',
            'location_id' => 'required',
            'agent_id' => 'required|array',
            'driver_id' => 'required|array',
        ]);

        $company = new Company;
        $company->name = $validated_data['name'];
        $company->phone = $validated_data['phone'];
        $company->location_id = $validated_data['location_id'];
        $company->save();

        $company->user()->sync([]);

        foreach ($validated_data['agent_id'] as $item) {
            $company->user()->attach($item, ['type' => 'agent']);
        }
        foreach ($validated_data['driver_id'] as $item) {
            $company->user()->attach($item, ['type' => 'driver']);
        }
        return redirect()->route('admin.company.index')->with('success', 'Successfully created');
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
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $company = Company::with('userAgent', 'userDriver', 'location')->find($id);
        $locations = CargoLocation::all();
        $without_agent_company = User::doesnthave('companyAgent')->agent()->get(['id', 'fullname']);
        $without_driver_company = User::doesnthave('companyDriver')->driver()->get(['id', 'fullname']);

        $company_agent = $company->userAgent->pluck('id')->toArray();
        $company_driver = $company->userDriver->pluck('id')->toArray();

        if (count($company->userAgent) > 0) {
            foreach ($company->userAgent as $item) {
                $without_agent_company->push($item);
            }
        }
        if (count($company->userDriver) > 0) {
            foreach ($company->userDriver as $item) {
                $without_driver_company->push($item);
            }
        }

        return view('backend.company.edit', compact('company', 'locations', 'without_agent_company', 'without_driver_company', 'company_agent', 'company_driver'));
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
        $company = Company::find($id);

        $validated_data = $this->validate($request, [
            'name' => 'required|unique:companies,name,'.$company->id,
            'phone' => 'nullable|string',
            'location_id' => 'required',
            'agent_id' => 'required|array',
            'driver_id' => 'required|array',
        ]);

        $company->name = $validated_data['name'];
        $company->phone = $validated_data['phone'];
        $company->location_id = $validated_data['location_id'];
        $company->save();

        $company->user()->sync([]);

        foreach ($validated_data['agent_id'] as $item) {
            $company->user()->attach($item, ['type' => 'agent']);
        }
        foreach ($validated_data['driver_id'] as $item) {
            $company->user()->attach($item, ['type' => 'driver']);
        }
        return redirect()->route('admin.company.index')->with('success', 'Successfully updated');
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
