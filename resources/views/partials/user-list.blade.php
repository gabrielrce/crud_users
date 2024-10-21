@foreach ($users as $user)
    <tr>
        <td>{{ $user->id }}</td>
        <td>{{ $user->name }}</td>
        <td>{{ $user->lastname }}</td>
        <td>
            <button class="btn btn-sm btn-primary"
                onclick="openEditModal({
                    id: {{ $user->id }},
                    name: '{{ $user->name }}',
                    lastname: '{{ $user->lastname }}',
                    lastname2: '{{ $user->lastname2 }}',
                    business_name: '{{ $user->business_name }}',
                    person_type: '{{ $user->person_type }}',
                    curp: '{{ $user->curp }}'
                })">Editar
            </button>
            <button class="btn btn-sm btn-danger" onclick="openDeleteModal({{ $user->id }})">Eliminar</button>
        </td>
    </tr>
@endforeach