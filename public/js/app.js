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

    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        let pageUrl = $(this).attr('href');
        updateUserList(pageUrl);
    });
});