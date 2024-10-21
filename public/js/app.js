$(document).ready(function() {
    if ($('#person_type').val() !== 'fisica') {
        $('#curpGroup').hide();
    }

    $('#person_type').change(function() {
        if ($(this).val() === 'fisica') {
            $('#curpGroup').show();
        } else {
            $('#curpGroup').hide();
        }
    });

    $('#userForm').on('submit', function(e) {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: storeUrl,
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#userModal').modal('hide');
                swal(response.success, "", "success");
                updateUserList();
            },
            error: function(xhr) {
                console.log(xhr.responseText);
                swal("Hubo un error al cargar sus datos", "", "error");
            }
        });
    });  

    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        let pageUrl = $(this).attr('href');
        updateUserList(pageUrl);
    });

    $('#userEditForm').submit(function(e) {
        e.preventDefault();
    
        let form = $(this);
        let actionUrl = form.attr('action');
        let formData = form.serialize();
    
        $.ajax({
            url: actionUrl,
            method: 'POST',
            data: formData,
            success: function(response) {
                $('#userModalEdit').modal('hide');
                swal(response.success, "", "success");
                updateUserList();
            },
            error: function(xhr) {
                console.log(xhr.responseText);
                swal("Hubo un error al actualizar los datos del usuario", "", "error");
            }
        });
    });
});

function updateUserList(pageUrl = "/users?page=1") {
    $.ajax({
        url: pageUrl,
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            $('#user-list tbody').html(data.users);
            $('#pagination-links').html(data.links);
        },
        error: function(xhr) {
            console.log(xhr.responseText);
        }
    });
}  

function openEditModal(user) {
    $('#userModalEdit input[name="name"]').val(user.name);
    $('#userModalEdit input[name="lastname"]').val(user.lastname);
    $('#userModalEdit input[name="lastname2"]').val(user.lastname2);
    $('#userModalEdit input[name="business_name"]').val(user.business_name);
    $('#userModalEdit select[name="person_type"]').val(user.person_type);

    $('#userEditForm').attr('action', '/users/' + user.id);

    if (user.person_type === 'fisica') {
        $('#userModalEdit input[name="curp"]').val(user.curp);
        $('#edit_curpGroup').show();
    } else {
        $('#edit_curpGroup').hide();
    }

    $('#userModalEdit').modal('show');
}