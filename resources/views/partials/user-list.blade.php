@foreach ($users as $user)
    <tr>
        <td>{{ $user->id }}</td>
        <td>{{ $user->name }}</td>
        <td>{{ $user->lastname }}</td>
        <td>
            <button class="btn btn-sm btn-primary">Editar</button>
            <button class="btn btn-sm btn-danger">Eliminar</button>
        </td>
    </tr>
@endforeach