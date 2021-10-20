<?php

namespace App\Http\Controllers\Admin;

use App\Exports\OrderExport;
use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::any(['SuperUser', 'Manager', 'OPS'], Auth::user())) {

            $reports = Report::all();
            $title = 'All Shipments';
            return view('backend.reports.index', compact('reports'));
        } elseif (Gate::any(['Client'], Auth::user())) {
            $reports = Report::where('user_id', Auth::id())->get();
            return view('backend.reports.index', compact('reports'));
        }

        return abort(403);
    }

    public function export(Request $request)
    {
        $file = Excel::download(new OrderExport($request), 'reports.xlsx');
        if (isset($file)) {
            $arr = [
                0 => 'All shipments',
                6 => 'Delivered',
                9 => 'Invoiced',
            ];
            $reports = new Report;
            $reports->start = $request->start;
            $reports->end = $request->end;
            $reports->user_id = Auth::id();
            $reports->status = $request->status;
            $reports->status_name =$arr[$request->status];
            $reports->save();
        }

        return $file;
    }

    public function exportExist($id)
    {
        $request = Report::find($id);
        $file = Excel::download(new OrderExport($request), 'reports.xlsx');

        return $file;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
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
