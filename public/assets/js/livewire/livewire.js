
//main alert
document.addEventListener('alert', (event) => {
    let data = event.detail;
    console.log(data);
    Swal.fire({
        position: data.position,
        timer: data.timer,
        toast: data.toast,
        text: data.text,
        showConfirmButton: true,
        icon: data.type,
        width: data.width,
    });
});

/*=========
start user-table
===========*/

//alert modal for view image
document.addEventListener('view-image', (event) => {
    var imagePath = event.detail.text; // Access image path as event.detail.text

    // Use SweetAlert2 to display the image path in a modal
    Swal.fire({
        imageUrl: imagePath,
        imageAlt: 'Image',
        showConfirmButton: false,
        width: '350',
        padding: '0 2rem 2rem 2rem',
        // background: 'rgba(0, 0, 0, 0.8)',
        onClose: () => {
            // Do something when the modal is closed
        },
        customClass: {
            image: 'custom-image' // Custom CSS class for the image
        },
        showCloseButton: true,
        closeButtonHtml: '&times;', // Custom HTML for the close button
        onOpen: (modalElement) => {
            // Attach event listener to close button
            modalElement.querySelector('.swal2-close').addEventListener('click', () => {
                Swal.close(); // Close the modal when the close button is clicked
            });
        }
    });
});


//alert for copy email
document.addEventListener('copy-email', (event) => {
    var email = event.detail.text; // Access email as event.detail.text
    var tempInput = document.createElement('input');
    tempInput.value = email;
    document.body.appendChild(tempInput);
    tempInput.select();
    document.execCommand('copy');
    document.body.removeChild(tempInput);

    // Use SweetAlert2 to display a custom alert
    Swal.fire({
        title: 'Email Copied!',
        width: '350',
        icon: 'success',
        showConfirmButton: false,
        timer: 2000 // Close the alert automatically after 2 seconds
    });
});

/*=========
end user-table
===========*/

/*=========
start lecture-table
===========*/

//alert for view description
document.addEventListener('view-description', (event) => {
    var description = event.detail.text; // Access description as event.detail.text

    // Use SweetAlert2 to display the description in a modal
    Swal.fire({
        title: 'Description',
        text: description,
        // showConfirmButton: false,
        position: 'center',
        padding: '0 2rem 2rem 2rem',
        width: '300px',
        showCloseButton: true,
        closeButtonHtml: '&times;', // Custom HTML for the close button
        onOpen: (modalElement) => {
            // Attach event listener to close button
            modalElement.querySelector('.swal2-close').addEventListener('click', () => {
                Swal.close(); // Close the modal when the close button is clicked
            });
        }
    });
});