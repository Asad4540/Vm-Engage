@foreach($campaigns as $campaign)
    <tr>
        <td class="px-5">
            @if($campaign->client->logo)
                <img src="{{ asset('images/client_logos/' . $campaign->client->logo) }}" width="80" height="80"
                    style="object-fit: cover;" alt="Ad Preview">
            @else
                N/A
            @endif
        </td>
        <td class="py-4">{{ $campaign->client->name ?? 'No Client' }}</td>
        <td class="py-4">{{ $campaign->ad_name }}</td>
        <td class="py-4">{{ $campaign->campaign_id }}</td>
        <td class="py-4">{{ $campaign->campaign_type }}</td>
        <td class="py-4">{{ $campaign->created_at->timezone('Asia/Kolkata')->format('d/m/Y h:i A') }}</td>
        <td class="py-4">
            <div class="tbody-row">
                @if($campaign->status == 'active')
                    <img src="images/green-circle.png" alt="" class="client-icon">
                    <p class="mb-0">Active</p>
                @elseif($campaign->status == "pending")
                    <img src="images/yellow-circle.png" alt="" class="client-icon">
                    <p class="mb-0">{{ ucfirst($campaign->status) }}</p>
                @elseif($campaign->status == 'paused')
                    <img src="images/red-circle.png" alt="" class="client-icon">
                    <p class="mb-0">{{ ucfirst($campaign->status) }}</p>
                @elseif($campaign->status == 'completed')
                    <img src="images/blue-circle.png" alt="" class="client-icon">
                    <p class="mb-0">{{ ucfirst($campaign->status) }}</p>
                @endif
            </div>
        </td>
        <td>
            <div class="d-flex gap-2">
                <a href="{{ route('campaigns.client_edit', $campaign->hashid) }}">
                    <img src="images/views.png" alt="Edit" class="client-icon">
                </a>

                <a href="{{ route('campaigns.edit', $campaign->hashid) }}">
                    <img src="images/edit.png" alt="Edit" class="client-icon">
                </a>

                <form action="{{ route('campaign.destroy', $campaign->id) }}" method="POST"
                    onsubmit="return confirm('Are you sure you want to delete this ad-campaign?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="border: none; background: none; padding: 0;">
                        <img src="images/delete.png" alt="Delete" class="client-icon">
                    </button>
                </form>
            </div>
        </td>
    </tr>
@endforeach