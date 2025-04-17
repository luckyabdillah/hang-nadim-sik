const flashData = $('.flash-data').data('flash')
const flashDataFailed = $('.flash-data-failed').data('flash')

if (flashData) {
    Swal({
        title: 'Success',
        text: flashData,
        type: 'success',
        confirmButtonColor: '#024687',
        cancelButtonText: 'OK'
    })
}

if (flashDataFailed) {
    Swal({
        title: 'Oops!',
        text: flashDataFailed,
        type: 'error',
        confirmButtonColor: '#024687',
        cancelButtonText: 'OK'
    })
}

$(document).on('click', '.btn-delete', function (event) {
    event.preventDefault()
    let form = $(this).closest("form")
    Swal({
        title: "Delete Data",
        text: "You sure want to delete this data?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#ff3e1d',
        cancelButtonColor: '#8592a3',
        confirmButtonText: 'Delete',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.value) {
            form.submit()
        }
    })
})