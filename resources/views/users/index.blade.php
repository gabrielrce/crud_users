<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">

</head>
<body>
    <div class="container mt-5">
        <h1>Usuarios</h1>
        <button class="btn btn-success mb-1" data-toggle="modal" data-target="#userModal">Nuevo Cliente</button>

        <form action="{{ route('users.index') }}" method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Buscar usuarios" value="{{ request('search') }}">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">Buscar</button>
                </div>
            </div>
        </form>

        <table class="table table-bordered" id="user-list">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            @include('partials.user-list', ['users' => $users])
        </table>        

        <div id="pagination-links">
            {{ $users->links() }}
        </div>
    </div>

    <div class="modal fade" id="userModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('users.store') }}" method="POST" id="userForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Crear nuevo usuario</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Tipo de persona</label>
                            <select name="person_type" id="person_type" class="form-control" required>
                                <option value="fisica" selected>Física</option>
                                <option value="moral">Moral</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Apellido paterno</label>
                            <input type="text" name="lastname" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Apellido materno</label>
                            <input type="text" name="lastname2" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Razón Social</label>
                            <input type="text" name="business_name" class="form-control">
                        </div>
                        <div class="form-group" id="curpGroup">
                            <label>CURP</label>
                            <input type="text" name="curp" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
            
        </div>
    </div> 
    <script>
        var storeUrl = @json(route('users.store'));
    </script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>