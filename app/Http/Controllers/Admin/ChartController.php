<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Schema;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\Admin;
use App\Models\User;

use App\Models\order;
use App\Models\SmsAlert;
use App\Models\Emergency;
use App\Models\Vehicle;
use App\Models\Insurance_Enquiry;

use function DataTables;

class ChartController extends Controller
{
    //
    public function orderChart(Request $request)
    {
        $sdate = $request->input('sdate');
        $edate = $request->input('edate');

        $query = order::selectRaw('DATE(created_at) AS day, COUNT(id) as count')
                      ->groupByRaw('DATE(created_at)')
                      ->orderByRaw('DATE(created_at)');
        // dd($query);
        if (!empty($sdate)) {
            $query->whereBetween('created_at', [$sdate . ' 00:00:00', $edate . ' 23:59:59']);
        }

        $data = $query->get();

        return response()->json($data);
    }

    public function AlertChart(Request $request)
    {
        $sdate = $request->input('sdate');
        $edate = $request->input('edate');

        $query = SmsAlert::selectRaw('type, COUNT(id) as count')
                      ->groupByRaw('type');

        if (!empty($sdate)) {
            $query->whereBetween('created_at', [$sdate . ' 00:00:00', $edate . ' 23:59:59']);
        }

        $data = $query->get();

        return response()->json($data);
    }

    public function EmergencyChart(Request $request)
    {
        $sdate = $request->input('sdate');
        $edate = $request->input('edate');

        $query = Emergency::selectRaw('DATE(created_at) AS day, COUNT(id) as count')
                      ->groupByRaw('DATE(created_at)')
                      ->orderByRaw('DATE(created_at)');

        if (!empty($sdate)) {
            $query->whereBetween('created_at', [$sdate . ' 00:00:00', $edate . ' 23:59:59']);
        }

        $data = $query->get();

        return response()->json($data);
    }

    public function UserChart(Request $request)
    {
        $sdate = $request->input('sdate');
        $edate = $request->input('edate');

        $query = User::selectRaw('DATE(created_at) AS day, COUNT(id) as count')
                      ->groupByRaw('DATE(created_at)')
                      ->orderByRaw('DATE(created_at)');

        if (!empty($sdate)) {
            $query->whereBetween('created_at', [$sdate . ' 00:00:00', $edate . ' 23:59:59']);
        }

        $data = $query->get();

        return response()->json($data);
    }
    public function VehicleChart(Request $request)
    {
        $sdate = $request->input('sdate');
        $edate = $request->input('edate');

        $query = Vehicle::selectRaw('DATE(created_at) AS day, COUNT(id) as count')
                      ->groupByRaw('DATE(created_at)')
                      ->orderByRaw('DATE(created_at)');

        if (!empty($sdate)) {
            $query->whereBetween('created_at', [$sdate . ' 00:00:00', $edate . ' 23:59:59']);
        }

        $data = $query->get();

        return response()->json($data);
    }

    public function InsuranceChart(Request $request)
    {
        $sdate = $request->input('sdate');
        $edate = $request->input('edate');

        $query = Insurance_Enquiry::join('insurances', 'insurance__enquiries.insurance_alias', '=', 'insurances.alias')
                                ->selectRaw('insurances.name AS type, COUNT(*) as count')
                                ->groupByRaw('insurances.name');

        if (!empty($sdate)) {
            $query->whereBetween('insurance__enquiries.created_at', [$sdate . ' 00:00:00', $edate . ' 23:59:59']);
        }

        $data = $query->get();

        return response()->json($data);
    }
}
