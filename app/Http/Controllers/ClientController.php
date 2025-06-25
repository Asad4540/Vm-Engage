<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Vinkla\Hashids\Facades\Hashids;


class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::all();
        foreach ($clients as $client) {
            $client->hashid = Hashids::encode($client->id);
        }
        return view('welcome', compact('clients'));
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
    {
        // 1. Validate input
        $request->validate([
            'name' => 'required|string|max:255',
            'details' => 'nullable|string|max:255',
            'status' => 'required|in:active,pending,paused,completed',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // 2. Initialize logo path
        $logoPath = null;

        // 3. Handle logo upload if exists
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoName = time() . '_' . preg_replace('/\s+/', '_', $logo->getClientOriginalName()); // Remove spaces
            $logo->move(public_path('images/client_logos'), $logoName);
            $logoPath = $logoName; // <-- this was missing in your code
        }

        // 4. Create client
        Client::create([
            'name' => $request->name,
            'details' => $request->details,
            'status' => $request->status,
            'logo' => $logoPath, // now correctly saving
        ]);

        // 5. Redirect with success message
        return redirect()->route('dashboard')->with('success', 'Client created successfully.');
    }


    public function edit($hashid)
    {
        $client = $this->findClientByHashid($hashid);
        return view('clients.edit', compact('client'));
    }
    public function update(Request $request, $hashid)
    {
        $client = $this->findClientByHashid($hashid);

        $request->validate([
            'name' => 'required|string|max:255',
            'details' => 'nullable|string|max:255',
            'status' => 'required|in:active,pending,paused,completed',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            if ($client->logo && file_exists(public_path('images/client_logos/' . $client->logo))) {
                unlink(public_path('images/client_logos/' . $client->logo));
            }

            $logo = $request->file('logo');
            $logoName = time() . '_' . preg_replace('/\s+/', '_', $logo->getClientOriginalName());
            $logo->move(public_path('images/client_logos'), $logoName);
            $client->logo = $logoName;
        }

        $client->name = $request->name;
        $client->details = $request->details;
        $client->status = $request->status;
        $client->save();

        return redirect()->route('dashboard')->with('success', 'Client updated successfully.');
    }

    public function destroy($hashid)
    {
        $client = $this->findClientByHashid($hashid);

        if ($client->logo && file_exists(public_path('images/client_logos/' . $client->logo))) {
            unlink(public_path('images/client_logos/' . $client->logo));
        }

        $client->delete();

        return redirect()->route('dashboard')->with('success', 'Client deleted successfully.');
    }

    private function findClientByHashid($hashid)
    {
        $id = Hashids::decode($hashid);
        if (empty($id)) {
            abort(404, 'Invalid hashid');
        }

        return Client::findOrFail($id[0]);
    }
}

