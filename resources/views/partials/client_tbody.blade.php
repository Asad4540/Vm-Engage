@foreach($clients as $client)
    <tr>
        <td class="px-5 py-4">
            <div class="tbody-row">
                @if($client->logo)
                    <img src="{{ asset('images/client_logos/' . $client->logo) }}" alt="Client Logo" class="client-logo">
                @endif
                <p class="mb-0">{{ $client->name }}</p>
            </div>
        </td>
        <td class="py-4">
            <div>
                <p>{{ $client->details }}</p>
            </div>
        </td>
        <td class="py-4">
            <div class="tbody-row">
                @if($client->status == 'active')
                    <img src="images/green-circle.png" alt="" class="client-icon">
                    <p class="mb-0">Active</p>
                @elseif($client->status == "pending")
                    <img src="images/yellow-circle.png" alt="" class="client-icon">
                    <p class="mb-0">{{ ucfirst($client->status) }}</p>
                @elseif($client->status == 'paused')
                    <img src="images/red-circle.png" alt="" class="client-icon">
                    <p class="mb-0">{{ ucfirst($client->status) }}</p>
                @elseif($client->status == 'completed')
                    <img src="images/blue-circle.png" alt="" class="client-icon">
                    <p class="mb-0">{{ ucfirst($client->status) }}</p>
                @endif
            </div>
        </td>
        <td class="py-4">
            {{ \Carbon\Carbon::parse($client->updated_at)->timezone('Asia/Kolkata')->format('d/m/Y h:i A') }}
        </td>
        @auth
            @if (auth()->user()->role_id == 1||3)
                <td class="py-4">
                    <div class="d-flex gap-2">
                        <a href="{{ route('clients.edit', ['hashid' => $client->hashid]) }}">
                            <img src="images/edit.png" alt="Edit" class="client-icon">
                        </a>
                        <form action="{{ route('clients.destroy',['hashid' => $client->hashid]) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this client?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="border: none; background: none; padding: 0;">
                                <img src="images/delete.png" alt="Delete" class="client-icon">
                            </button>
                        </form>
                    </div>
                </td>
            @endif
        @endauth
    </tr>
@endforeach
