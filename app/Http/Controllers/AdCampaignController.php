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
        $user = auth()->user(); // Logged-in user
        $clients = [];
        $query = Campaign::query();

        // If admin or similar, fetch all clients
        if (in_array($user->role_id, [1, 3])) {
            $clients = Client::all();
        }

        // If user is a client, filter by their assigned client_id
        if ($user->role_id == 2 && $user->client_id) {
            $query->where('client_id', $user->client_id);
        }

        // Apply search filter
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


    public function store(Request $request)
    {
        $data = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'ad_name' => 'required|string|max:255',
            'campaign_id' => 'required|string|max:255',
            'campaign_type' => 'required|string|max:255',
            'ad_preview' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        // Handle file upload
        if ($request->hasFile('ad_preview')) {
            $file = $request->file('ad_preview');
            $fileName = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());

            $uploadPath = public_path('images/ad_preview');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $file->move($uploadPath, $fileName);
            $data['ad_preview'] = $fileName;
        }

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

        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'ad_name' => 'required|string|max:255',
            'campaign_id' => 'required|string|max:255',
            'campaign_type' => 'required|string|max:255',
            'ad_preview' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'status' => 'required|in:active,pending,paused,completed',
            'clicks' => 'nullable|string|max:255',
            'impressions' => 'nullable|string|max:255',
            'delivered' => 'nullable|numeric',
            'remaining' => 'nullable|numeric',
            'mobile' => 'nullable|numeric',
            'desktop' => 'nullable|numeric',
            'country' => 'nullable|array',
            'percentage' => 'nullable|array',
            'date' => 'nullable|array',



        ]);

        if ($request->hasFile('ad_preview')) {
            // Delete old logo if exists
            if ($campaign->ad_preview && file_exists(public_path('images/ad_preview/' . $campaign->ad_preview))) {
                unlink(public_path('images/ad_preview/' . $campaign->ad_preview));
            }

            $ad_preview = $request->file('ad_preview');
            $ad_previewName = time() . '_' . $ad_preview->getClientOriginalName();

            // Move new ad_preview to public/images/ad_preview/
            $ad_preview->move(public_path('images/ad_preview'), $ad_previewName);

            $campaign->ad_preview = $ad_previewName;
        }

        $campaign->client_id = $request->client_id;
        $campaign->ad_name = $request->ad_name;
        $campaign->campaign_id = $request->campaign_id;
        $campaign->campaign_type = $request->campaign_type;
        $campaign->status = $request->status;


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

            $campaign->url = json_encode($urlMap);
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

            $campaign->country = json_encode($countries);
            $campaign->percentage = json_encode($percentages);
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
            $campaign->delivered = $request->input('delivered');
            $campaign->remaining = $request->input('remaining');
        }

        if ($request->has('clicks') && ('impressions')) {
            $campaign->clicks = $request->input('clicks');
            $campaign->impressions = $request->input('impressions');
        }

        if ($request->has('mobile') && ('desktop')) {
            $campaign->mobile = $request->input('mobile');
            $campaign->desktop = $request->input('desktop');
        }

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



        ];

        $data = $request->validate($rules);

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
