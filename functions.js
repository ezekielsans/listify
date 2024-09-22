document.getElementById('dropdownToggle').onclick = function() {


const dropDownMenu = document.getElementById('dropdownMenu');
dropDownMenu.classList.contains('show') ?  dropDownMenu.classList.remove('show') : dropDownMenu.classList.add('show');
}



//for delete button


// document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
//     // Your delete logic here
//     alert('Item successfully deleted.');
//     // Close the modal after deletion (Bootstrap 5 method)
//     const deleteModal = bootstrap.Modal.getInstance(document.getElementById('deleteConfirmModal'));
//     deleteModal.hide();
// });

/*

const deleteConfirmModal = document.getElementById('deleteConfirmModal');
deleteConfirmModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget; // Button that triggered the modal
    const userId = button.getAttribute('data-user-id'); // Extract user ID from data-* attribute
    console.log("Delete button clicked for User ID: " + userId);

    // Update the modal's hidden input field with the user ID
    const modalInput = document.getElementById('deleteUserId');
    modalInput.value = userId;

});
*/




