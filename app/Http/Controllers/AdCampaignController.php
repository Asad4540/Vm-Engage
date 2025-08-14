<?php

namespace App\Http\Controllers;
use App\Models\Client;
use App\Models\Campaign;
use App\Models\TechProperty;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;


class AdCampaignController extends Controller
{
    public function index(Request $request)
    {
        $clients = Client::all();
        $query = Campaign::query();

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
            return view('partials.campaign_tbody', compact('campaigns'))->render();
        }

        return view('ad-campaign', compact('clients', 'campaigns'));
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'ad_name' => 'required|string|max:255',
            'campaign_id' => 'required|string|max:255',
            'campaign_type' => 'required|string|max:255',
            'ad_preview' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        Campaign::create($data);

        return redirect()->route('ad-campaign')->with('success', 'Campaign added successfully!');
    }



    public function destroy($id)
    {
        $campaign = Campaign::findOrFail($id);

        if ($campaign->ad_preview) {
            $adPreviewPath = public_path('images/ad_preview/' . $campaign->ad_preview);
            if (file_exists($adPreviewPath)) {
                unlink($adPreviewPath); // delete the image file
            }
        }

        $campaign->delete();

        return redirect()->route('ad-campaign')->with('success', 'Client deleted successfully.');
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

        return view('campaigns.edit', compact('campaign', 'clients', 'tech_properties'));
    }


    public function update(Request $request, Campaign $campaign)
    {
        $data = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'ad_name' => 'required|string|max:255',
            'campaign_id' => 'required|string|max:255',
            'campaign_type' => 'required|string|max:255',
            'status' => 'required|in:active,pending,paused,completed',
            'ad_preview' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',

            'single_adpreview.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'single_size.*' => 'nullable|string|max:50',
            'single_clicks.*' => 'nullable|integer|min:0',
            'single_impressions.*' => 'nullable|integer|min:0',

            'clicks' => 'nullable|string|max:255',
            'impressions' => 'nullable|string|max:255',
            'delivered' => 'nullable|numeric',
            'remaining' => 'nullable|numeric',
            'mobile' => 'nullable|numeric',
            'desktop' => 'nullable|numeric',
            'country' => 'nullable|array',
            'percentage' => 'nullable|array',
            'date' => 'nullable|array',

            'top_sites' => 'nullable|array',
            'top_sites.*' => 'nullable'
        ]);

        $uploadedFiles = $request->file('single_adpreview', []);
        $existingImages = $request->input('existing_single_adpreview', []);

        $multipleAds = [];
        $singleAdPreviews = [];

        if ($request->has('single_size')) {
            foreach ($request->single_size as $index => $size) {

                $imagePath = $existingImages[$index] ?? null; // Default to existing image if present

                if (isset($uploadedFiles[$index])) {
                    $file = $uploadedFiles[$index];
                    $filename = uniqid('ad_') . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('images/single_adpreview'), $filename);
                    $imagePath = 'images/single_adpreview/' . $filename;
                }

                if ($size || ($request->single_clicks[$index] ?? false) || ($request->single_impressions[$index] ?? false) || $imagePath) {
                    $singleAdPreviews[] = $imagePath;

                    $multipleAds[] = [
                        'single_size' => $size ?? '',
                        'single_clicks' => $request->single_clicks[$index] ?? 0,
                        'single_impressions' => $request->single_impressions[$index] ?? 0,
                    ];
                }
            }
        }

        $data['top_sites'] = $request->filled('top_sites') ? array_filter($request->top_sites) : null;


        // Update other fields
        $campaign->client_id = $data['client_id'];
        $campaign->ad_name = $data['ad_name'];
        $campaign->campaign_id = $data['campaign_id'];
        $campaign->campaign_type = $data['campaign_type'];
        $campaign->status = $data['status'];
        // $campaign->top_sites = $data['top_sites'];
        $campaign->top_sites = $request->filled('top_sites') ? array_filter($request->top_sites) : null;

        // Optional fields
        $campaign->clicks = $data['clicks'] ?? $campaign->clicks;
        $campaign->impressions = $data['impressions'] ?? $campaign->impressions;
        $campaign->delivered = $data['delivered'] ?? $campaign->delivered;
        $campaign->remaining = $data['remaining'] ?? $campaign->remaining;
        $campaign->mobile = $data['mobile'] ?? $campaign->mobile;
        $campaign->desktop = $data['desktop'] ?? $campaign->desktop;
        $campaign->country = isset($data['country']) ? json_encode($data['country']) : $campaign->country;
        $campaign->percentage = isset($data['percentage']) ? json_encode($data['percentage']) : $campaign->percentage;
        $campaign->date = isset($data['date']) ? json_encode($data['date']) : $campaign->date;
        // $campaign->multiple_ads = !empty($multipleAds) ? json_encode($multipleAds, JSON_UNESCAPED_SLASHES) : null;
        $campaign->single_adpreview = !empty($singleAdPreviews) ? json_encode($singleAdPreviews, JSON_UNESCAPED_SLASHES) : null;

        $campaign->save();

        return redirect()->route('ad-campaign')->with('success', 'Campaign updated successfully.');
    }


    public function save(Request $request, Campaign $campaign = null)
    {
        $rules = [
            'tech_prop_id' => 'nullable|array',
            'tech_prop_id.*' => 'exists:tech_properties,id',
            'url' => 'nullable|array',
            'url.*' => 'nullable|string|url',
            'delivered' => 'nullable|numeric',
            'remaining' => 'nullable|numeric',
            'clicks' => 'nullable|string|max:255',
            'impressions' => 'nullable|string|max:255',
            'mobile' => 'nullable|numeric',
            'desktop' => 'nullable|numeric',
            'country' => 'nullable|array',
            'percentage' => 'nullable|array',
            'date' => 'nullable|array',

            'single_size.*' => 'nullable|string|max:50',
            'single_clicks.*' => 'nullable|integer|min:0',
            'single_impressions.*' => 'nullable|integer|min:0',
            'single_adpreview.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

            'top_sites' => 'nullable|array',
            'top_sites.*' => 'nullable|string',

        ];

        $data = $request->validate($rules);

        $singleAdPreviews = [];
        $multipleAds = [];

        $uploadedFiles = $request->file('single_adpreview', []);

        if ($request->has('single_size')) {
            foreach ($request->single_size as $index => $size) {
                $hasMeaningfulData = $size || ($request->single_clicks[$index] ?? false) || ($request->single_impressions[$index] ?? false) || isset($uploadedFiles[$index]);

                if (!$hasMeaningfulData) {
                    continue;
                }
                $imagePath = null;
                if (isset($uploadedFiles[$index])) {
                    $file = $uploadedFiles[$index];
                    $filename = uniqid('ad_') . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('images/single_adpreview'), $filename);
                    $imagePath = 'images/single_adpreview/' . $filename;
                }

                $singleAdPreviews[] = $imagePath;

                $multipleAds[] = [
                    'single_size' => $size ?? '',
                    'single_clicks' => $request->single_clicks[$index] ?? 0,
                    'single_impressions' => $request->single_impressions[$index] ?? 0,
                ];
            }
        }

        // Store in database
        // $data['multiple_ads'] = !empty($multipleAds) ? json_encode($multipleAds) : null;

        $filteredAdPreviews = array_filter($singleAdPreviews, fn($v) => !is_null($v));
        $data['single_adpreview'] = !empty($filteredAdPreviews) ? json_encode($filteredAdPreviews) : null;

        if ($request->has('top_sites')) {
            $topSites = array_filter($request->top_sites, fn($site) => !empty($site));
            $data['top_sites'] = !empty($topSites) ? array_values($topSites) : null;
        }

        if ($request->has('url_data')) {
            $urlData = $request->input('url_data', []);
            $urlMap = [];

            foreach ($urlData as $item) {
                if (!empty($item['tech_prop_id']) && !empty($item['url'])) {
                    $urlMap[] = [
                        'tech_prop_id' => $item['tech_prop_id'],
                        'url' => $item['url'],
                    ];
                }
            }

            $data['url'] = json_encode($urlMap);
        }

        if ($request->has('region_data')) {
            $regionData = $request->input('region_data', []);
            $countries = [];
            $percentages = [];

            foreach ($regionData as $item) {
                if (!empty($item['country']) && !empty($item['percentage'])) {
                    $countries[] = $item['country'];
                    $percentages[] = $item['percentage'];
                }
            }

            $data['country'] = json_encode($countries);
            $data['percentage'] = json_encode($percentages);

        }

        if ($request->has('metrics_data')) {
            $metricsData = $request->input('metrics_data', []);
            $date = [];
            $clicks = [];
            $impressions = [];

            foreach ($metricsData as $item) {
                // Skip completely empty rows
                if (empty($item['date']) && empty($item['clicks']) && empty($item['impressions'])) {
                    continue;
                }

                // Use null for empty individual fields
                $date[] = $item['date'] ?? null;
                $clicks[] = $item['clicks'] ?? null;
                $impressions[] = $item['impressions'] ?? null;
            }

            // Only update if we have at least one valid row
            if (!empty($date) || !empty($clicks) || !empty($impressions)) {
                $campaign->date = !empty($date) ? json_encode($date) : null;
                $campaign->clicks = !empty($clicks) ? json_encode($clicks) : null;
                $campaign->impressions = !empty($impressions) ? json_encode($impressions) : null;
            }
        }

        if ($request->has('delivered') && ('remaining')) {
            $data['delivered'] = $request->input('delivered');
            $data['remaining'] = $request->input('remaining');
        }

        if ($request->has('clicks') && ('impressions')) {
            $data['clicks'] = $request->input('clicks');
            $data['impressions'] = $request->input('impressions');
        }

        if ($request->has('mobile') && ('desktop')) {
            $data['mobile'] = $request->input('mobile');
            $data['desktop'] = $request->input('desktop');
        }

        if ($campaign) {
            $campaign->update($data);
            $message = 'Campaign updated successfully.';
        } else {
            Campaign::create($data);
            $message = 'Campaign created successfully.';
        }


        return redirect()->back()->with('success', $message);
    }
}