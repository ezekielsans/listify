
//referencing an id to a modal
document.addEventListener("DOMContentLoaded", function () {
    var deleteModal = document.getElementById('deleteConfirmModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
        //whatever button i click
        var button = event.relatedTarget;
        //get something from this button
        var userId = button.getAttribute('data-user-id');

        var deleteInput = document.getElementById('deleteUserId');
        deleteInput.value = userId;
    });


    var deactivationModal = document.getElementById('deactConfirmModal');
    deactivationModal.addEventListener('show.bs.modal', function (event) {
        //whatever button i click
        var button = event.relatedTarget;
        //get something from this button
        var userId = button.getAttribute('data-user-id');

        var deactivationInput = document.getElementById('deactUserId');
        deactivationInput.value = userId;
    });

})