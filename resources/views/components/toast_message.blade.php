<div class="toast-container position-fixed top-0 start-50 translate-middle-x p-3" style="z-index: 2000;">
    <div id="mainToast" class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive"
        aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body" id="toastMessage">
                Gagal menghapus data.
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                aria-label="Close"></button>
        </div>
    </div>
</div>

<script>
    function showToast(message, type) {
        const toastEl = $('#mainToast');
        const toastBody = $('#toastMessage');

        toastBody.text(message);
        toastEl.removeClass('text-bg-danger text-bg-success text-bg-warning')
            .addClass(`text-bg-${type}`);

        const toast = new bootstrap.Toast(toastEl[0], {
            delay: 3000
        });
        toast.show();
    }
</script>
