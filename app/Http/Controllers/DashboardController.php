<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use App\Models\Campaign;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;




class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $role_id = Auth::user()->role_id;

        if (!in_array($role_id, [1, 3])) {
            // Initialize totals
            $totalClicks = 0;
            $totalImpressions = 0;

            // Get ALL campaigns (not just latest)
            $campaigns = Campaign::all();
            $totalAds = $campaigns->count();

            // Calculate totals across ALL campaigns
            foreach ($campaigns as $campaign) {
                $clicksArray = json_decode($campaign->clicks ?? '[]', true);
                $impressionsArray = json_decode($campaign->impressions ?? '[]', true);

                $totalClicks += is_array($clicksArray) ? array_sum($clicksArray) : 0;
                $totalImpressions += is_array($impressionsArray) ? array_sum($impressionsArray) : 0;
            }

            $campaignData = [];
            $flatData = [];

            foreach ($campaigns as $campaign) {
                $clicksArray = json_decode($campaign->clicks ?? '[]', true);
                $impressionsArray = json_decode($campaign->impressions ?? '[]', true);
                $datesArray = json_decode($campaign->date ?? '[]', true);

                if (!is_array($datesArray) || empty($datesArray)) {
                    $datesArray = array_fill(0, count($clicksArray), now()->format('Y-m-d'));
                }

                foreach ($clicksArray as $i => $click) {
                    $date = $datesArray[$i] ?? now()->format('Y-m-d');

                    try {
                        $month = Carbon::parse($date)->format('F');
                    } catch (\Exception $e) {
                        $month = 'Unknown';
                    }

                    if (!isset($flatData[$month])) {
                        $flatData[$month] = ['clicks' => 0, 'impressions' => 0];
                    }

                    $flatData[$month]['clicks'] += $click;
                    $flatData[$month]['impressions'] += $impressionsArray[$i] ?? 0;
                }
            }

            $monthOrder = [
                'January',
                'February',
                'March',
                'April',
                'May',
                'June',
                'July',
                'August',
                'September',
                'October',
                'November',
                'December'
            ];

            // Sort $flatData based on defined month order
            uksort($flatData, function ($a, $b) use ($monthOrder) {
                return array_search($a, $monthOrder) <=> array_search($b, $monthOrder);
            });

            // Format for frontend chart
            $campaignData = collect($flatData)->map(function ($data, $month) {
                return [
                    'month' => $month,
                    'clicks' => $data['clicks'],
                    'impressions' => $data['impressions'],
                ];
            })->values();



            $campaigns = DB::table('campaigns')->select('country', 'percentage')->get();

            $countryTotals = [];

            foreach ($campaigns as $campaign) {
                $countries = json_decode($campaign->country, true);
                $percentages = json_decode($campaign->percentage, true);

                if (is_array($countries) && is_array($percentages)) {
                    foreach ($countries as $index => $country) {
                        $country = strtolower(trim($country)); // Normalize casing/spaces
                        $percentage = $percentages[$index] ?? 0;

                        if (!isset($countryTotals[$country])) {
                            $countryTotals[$country] = 0;
                        }
                        $countryTotals[$country] += $percentage;
                    }
                }
            }

            // Normalize to 100%
            $grandTotal = array_sum($countryTotals);
            if ($grandTotal > 0) {
                foreach ($countryTotals as $country => &$value) {
                    $value = round(($value / $grandTotal) * 100, 2); // Scale to 100%
                }
                unset($value);
            }

            // Sort descending by percentage
            arsort($countryTotals);

            // Limit to top 10 countries
            $top10Countries = array_slice($countryTotals, 0, 9, true);
            $others = array_slice($countryTotals, 10, null, true);

            $othersTotal = array_sum($others);

            // Format for frontend
            $topCountries = [];
            foreach ($top10Countries as $country => $percentage) {
                $topCountries[] = [
                    'country' => ucfirst($country),
                    'percentage' => $percentage,
                ];
            }


            if ($othersTotal > 0) {
                $topCountries[] = [
                    'country' => 'Others',
                    'percentage' => round($othersTotal, 2),
                ];
            }


            return view('home', [
                'campaignData' => $campaignData,
                'campaign' => null, // or you can pass Campaign::first() if you want a sample
                'topCountries' => $topCountries,
                'totalClicks' => $totalClicks,
                'totalImpressions' => $totalImpressions,
                'totalAds' => $totalAds
            ]);
        }

        // Rest of your admin role logic...
        $query = Client::query();

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('details', 'like', '%' . $request->search . '%')
                ->orWhere('status', 'like', '%' . $request->search . '%');
        }

        $clients = $query->orderBy('created_at', 'desc')->paginate(6);

        if ($request->ajax()) {
            return view('partials.client_tbody', compact('clients'))->render();
        }

        return view('welcome', compact('clients'));
    }


}
