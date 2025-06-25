
@foreach ($users as $user)
    <tr>
        <td class="px-4 py-4">{{ $user->name }}</td>
        <td class="py-4">{{ $user->email }}</td>
        <td class="py-4">{{ $user->role->name ?? 'N/A' }}</td>
        <td class="py-4">
            <div class="d-flex gap-2">
                <img src="images/edit.png" alt="" class="client-icon edit-user" data-id="{{ $user->id }}">
                <img src="images/delete.png" alt="Delete" class="client-icon delete-user" data-id="{{ $user->id }}">
            </div>
        </td>
    </tr>
@endforeach

