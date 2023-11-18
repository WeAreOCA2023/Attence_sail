<tr>
    <td><input type="text" value="{{ $department->department_name }}"></td>
    <td>{{ $department_info['boss_name'] }}</td>
    <td>{{ $department_info['email'] }}</td>
    <td>
        <div class="edit-delete d-flex">
        <button  wire:click="editable({{ $department->id }})" class="editBtn btn-primary">
            <img src="{{ asset('img/edit.svg') }}" alt="editing icon">
        </button>
            <button class="deleteBtn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $department->id }}">
                <img src="{{ asset('img/delete.svg') }}" alt="deleting icon">
            </button>
        </div>
    </td>
</tr>   