<?php

namespace App\Exports;

use App\Models\Campaign;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CampaignExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Campaign::all()->map(function ($campaign) {
            return [
                'Ad Name' => $campaign->ad_name,
                'Status' => ucfirst($campaign->status),
                'Campaign ID' => $campaign->campaign_id,
                'Campaign Type' => $campaign->campaign_type,
                'Created At' => $campaign->created_at->timezone('Asia/Kolkata')->format('M d, Y h:i A'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Ad Name',
            'Status',
            'Campaign ID',
            'Campaign Type',
            'Created At',
        ];
    }
}
