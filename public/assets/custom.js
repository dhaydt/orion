function alertMessage(status){
    if(status[0] == 1){
        icon = 'success';
        title = "Notification";
    }else{
        icon = 'error'
        title = 'Warning'
    }

    Swal.fire({
        title: title,
        text: status[1],
        icon: icon
    });
}

async function alertHapus(title = null, text = null){
    konfirmasi = await Swal.fire({
        title: title,
        text: text,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Delete this!'
    })
    return konfirmasi
}

async function alertConfirm(title = null, text = null){
    konfirmasi = await Swal.fire({
        title: title,
        text: text,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, change this!'
    })
    return konfirmasi
}

async function logout(){
    konfirmasi = await Swal.fire({
        title: 'Warning!!!',
        text: 'Are you sure want to logout???',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!'
    })

    if(konfirmasi.isConfirmed == true){
        $('#form_logout').submit()
    }
}
