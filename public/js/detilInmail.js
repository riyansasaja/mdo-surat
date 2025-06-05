$(document).ready(function () {

    console.log('ini detil mail.js');


    $('#dispotampil').on('click', '.deldispo', function (e) {
        e.preventDefault();
        let delurl = $(this).attr('href');

        //swal
        Swal.fire({
            title: "Anda yakin?",
            text: "Data yang sudah dihapus tidak bisa kembali!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, Hapus!"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = delurl;
            }
        });       
    });



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

            let value = `${path}uploads/inmailAttach/${year}/${kodesurat}/${file}`

            $('#iframesurat').attr('src', value);
            modaldetilmail.show()

    });


});