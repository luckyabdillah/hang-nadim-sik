document.addEventListener('DOMContentLoaded', e => {
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault()
            const container = e.target
            const submitBtn = container.querySelector('.btn-submit')
            const cancelBtn = container.querySelector('.btn-cancel')
            if (submitBtn) {
                const submitBtnWidth = submitBtn.offsetWidth;
                submitBtn.style.width = `${submitBtnWidth}px`;

                submitBtn.setAttribute('disabled', true)
                submitBtn.innerHTML = `
                    <div class="spinner-border spinner-border-sm" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                `
            }
            if (cancelBtn) {
                cancelBtn.classList.add('disabled')
                cancelBtn.setAttribute('disabled', true)
            }
            return this.submit()
        })
    })

    const flashData = $('.flash-data').data('flash')
    const flashDataFailed = $('.flash-data-failed').data('flash')

    if (flashData) {
        new Swal({
            title: 'Success',
            html: flashData,
            icon: 'success',
            confirmButtonText: 'OK',
            customClass: {
                popup: 'rounded-4',
                confirmButton: 'px-4 bg-primary rounded-3',
            },
        })
    }

    if (flashDataFailed) {
        new Swal({
            title: 'Oops!',
            html: flashDataFailed,
            icon: 'error',
            confirmButtonText: 'OK',
            customClass: {
                popup: 'rounded-4',
                confirmButton: 'px-4 bg-primary rounded-3',
            }
        })
    }
})
