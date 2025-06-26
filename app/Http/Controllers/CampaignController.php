<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CampaignExport;
use Carbon\Carbon;

class CampaignController extends Controller
{
    public function export()
    {
        $clientId = Auth::user()->client_id; // Get logged-in user's client_id
        $date = Carbon::now()->format('d-m-Y');
        $filename = 'campaign-' . $date . '.xlsx';

        return Excel::download(new CampaignExport($clientId), $filename);
    }
}
