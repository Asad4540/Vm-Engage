<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CampaignExport;
use Carbon\Carbon;

class CampaignController extends Controller
{

    public function export()
    {
        $date = Carbon::now()->format('d-m-Y');
        $filename = 'campaign-' . $date . '.xlsx';
        return Excel::download(new CampaignExport, $filename);
    }
}
