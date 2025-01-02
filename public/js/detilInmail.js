$(document).ready(function () {

    if (error) {
        Swal.fire({
            title: "Error",
            text: JSON.stringify(error),
            icon: "error"
          });
    }

    if (success) {
        Swal.fire({
            title: "Success",
            text: success,
            icon: "success"
          });        
    }


    $('.sawdetil').on('click', function (e) {
            e.preventDefault()
            let file = $(this).attr('data-file')
            let kodesurat = $(this).attr('data-kodesurat')
            let id = $(this).attr('data-id')
            let modaldetilmail = new bootstrap.Modal($('#detilsuratModal'))

            let value = `${path}uploads/inmailAttach/2024/${kodesurat}/${file}`

            $('#iframesurat').attr('src', value);
            modaldetilmail.show()

    });


});