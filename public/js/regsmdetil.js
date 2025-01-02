window.addEventListener('DOMContentLoaded', event => {
    console.log('ini reg sm')
  
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
            text: JSON.stringify(success),
            icon: "success"
          });        
    }

    function tes(params) {
        console.log(`halo ${params}`)
    }

   


});
