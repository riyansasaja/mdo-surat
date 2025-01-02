window.addEventListener('DOMContentLoaded', event => {
    // Simple-DataTables
    // https://github.com/fiduswriter/Simple-DataTables/wiki

    const datatablesSimple = document.getElementById('tabelsuratmasuk');
    if (datatablesSimple) {
        new simpleDatatables.DataTable(datatablesSimple);
    }

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


});
