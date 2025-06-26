<?php

namespace App\Http\Controllers;
use App\Models\Client;
use App\Models\Campaign;
use App\Models\TechProperty;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Support\Facades\DB;


class ClientCampaignController extends Controller
{
    public function index(Request $request)
    {
        $clients = Client::all();
        $user = auth()->user(); // get the logged-in user
        $query = Campaign::query();

        // ✅ Apply client-based filter for client users (e.g., role_id = 2)
        if ($user->role_id == 2 && $user->client_id) {
            $query->where('client_id', $user->client_id);
        }

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->whereHas('client', function ($clientQuery) use ($request) {
                    $clientQuery->where('name', 'like', '%' . $request->search . '%');
                })
                    ->orWhere('ad_name', 'like', '%' . $request->search . '%')
                    ->orWhere('campaign_id', 'like', '%' . $request->search . '%')
                    ->orWhere('campaign_type', 'like', '%' . $request->search . '%')
                    ->orWhere('status', 'like', '%' . $request->search . '%')
                    ->orWhere('created_at', 'like', '%' . $request->search . '%');
            });
        }

        $campaigns = $query->orderBy('created_at', 'desc')->paginate(6);

        if ($request->ajax()) {
            return view('partials.client_campaign_tbody', compact('campaigns'))->render();
        }

        return view('client-campaign', compact('clients', 'campaigns'));
    }


    public function edit($hashid)
    {
        $decoded = Hashids::decode($hashid);

        if (empty($decoded)) {
            abort(404); // Invalid hashid
        }

        $campaignId = $decoded[0];
        $campaign = Campaign::findOrFail($campaignId);

        $clients = Client::all();
        $tech_properties = TechProperty::all();

        $deviceData = DB::table('campaigns')
            ->select('mobile', 'desktop')
            ->where('id', $campaignId)
            ->first();

        $campaignData = DB::table('campaigns')
            ->select('clicks', 'impressions', 'created_at', 'updated_at')
            ->where('id', $campaignId)
            ->get()
            ->map(function ($item) {
                return [
                    'clicks' => $item->clicks,
                    'impressions' => $item->impressions,
                    'timestamp' => $item->updated_at ?? $item->created_at, // Prefer updated_at if available
                ];
            });

        $countryData = DB::table('campaigns')
            ->select('country', 'percentage')
            ->where('id', $campaignId)
            ->first();

        $topCountries = [];

        if ($countryData) {
            $country = json_decode($countryData->country, true);
            $percentage = json_decode($countryData->percentage, true);

            if (is_array($country) && is_array($percentage)) {
                foreach ($country as $index => $country) {
                    $topCountries[] = [
                        'country' => $country,
                        'percentage' => $percentage[$index] ?? 0,
                    ];
                }
                usort($topCountries, function ($a, $b) {
                    return $b['percentage'] <=> $a['percentage'];
                });
            }
        }


        return view('campaigns.client_edit', compact('campaign', 'clients', 'tech_properties', 'deviceData', 'campaignData', 'topCountries'));
    }
}
