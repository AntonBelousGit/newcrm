<?php

namespace App\Http\Controllers\Admin;

use App\Exports\OrderExport;
use App\Exports\OrderFindExport;
use App\Exports\SelectedOrderExport;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Report;
use App\Models\User;
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

            $reports = Report::with('user.roles')->get();
            $drivers = User::whereHas('roles', function ($q) {
                $q->where('name', 'Driver');
            })->get();
            $agents = User::whereHas('roles', function ($q) {
                $q->where('name', 'Agent');
            })->get();
            return view('backend.reports.index', compact('reports', 'agents', 'drivers'));
        }

        if (Gate::any(['Client'], Auth::user())) {
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
                1 => 'New Order',
                2 => 'Accepted in work',
                6 => 'Delivered',
                9 => 'Invoiced',
                11 => 'Driver',
                12 => 'Agent',
                13 => 'Driver && Agent'
            ];

            $reports = new Report;
            $reports->comment = $request->comment;
            $reports->start = $request->start;
            $reports->end = $request->end;
            $reports->user_id = Auth::id();
            $reports->status = ($request->status == 'null') ? null : $request->status;
            $reports->driver_id = ($request->driver != 'null') ? $request->driver : null;
            $reports->agent_id = ($request->agent != 'null') ? $request->agent : null;

            if ($reports->agent_id != null && $reports->driver_id != null) {
                $request->status = 13;
            } elseif ($reports->agent_id != null) {
                $request->status = 12;
            } elseif ($reports->driver_id != null) {
                $request->status = 11;
            }

            $reports->status_name = $arr[$request->status] ?? "ANY";

            $reports->save();
        }

        return $file;
    }

    public function exportExist($id)
    {
        $request = Report::find($id);
        return Excel::download(new OrderFindExport($request), 'reports.xlsx');
    }

    public function exportSelected(Request $request)
    {
        if ($request['option'] == 1 ) {
            $request = $request['order_id'];
            return Excel::download(new SelectedOrderExport($request), 'orders.xlsx');
        }
        return response()->json(['msg'=>'Fail'],404);
    }

    public function destroy($id)
    {
        if (Gate::any(['SuperUser', 'Manager', 'OPS','Client'], Auth::user())) {
            $report = Report::find($id);
            $report->delete();
            return redirect()->route('admin.report.index');
        }
        return abort(403);
    }
}
