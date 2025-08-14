@foreach($campaigns as $campaign)
    <tr>
        <!-- <td class="px-5">
            @if($campaign->ad_preview)
                <img src="{{ asset('images/ad_preview/' . $campaign->ad_preview) }}" width="100" height="100"
                    style="object-fit: cover;" alt="Ad Preview">
            @else
                N/A
            @endif
        </td> -->
        <!-- <td class="py-4">{{ $campaign->client->name ?? 'No Client' }}</td> -->
        <td class="py-4">{{ $campaign->ad_name }}</td>
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
        <td class="py-4">{{ $campaign->campaign_id }}</td>
        <td class="py-4">{{ $campaign->campaign_type }}</td>
        <td class="py-4">{{ $campaign->created_at->timezone('Asia/Kolkata')->format('M d, Y h:i A') }}</td>

        <td>
            <div class="d-flex align-items-center" style="height: 60px;">
                <a href="{{ route('campaigns.client_edit', $campaign->hashid) }}">
                    <button class="btn-secondary-db">more details</button>
                </a>
            </div>
        </td>
    </tr>
@endforeach