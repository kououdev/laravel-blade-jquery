<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="confirmDeleteLabel">Delete Confirmation</h5>
                <button type="button" class="close text-white" onclick="$('#confirmDeleteModal').modal('hide')"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this data?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"
                    onclick="$('#confirmDeleteModal').modal('hide')">Cancel</button>
                <button type="button" class="btn btn-danger" id="btnConfirmDelete">Yes, Delete</button>
            </div>
        </div>
    </div>
</div>
