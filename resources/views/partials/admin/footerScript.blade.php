<!-- jQuery -->
<script src="/assets/js/library/jquery.min.js"></script>

<!-- Bootstrap -->
<script src="/assets/js/library/bootstrap.bundle.min.js"></script>

<!-- App Scripts -->
<script src="/assets/js/library/app.min.js"></script>
<script src="/assets/js/library/simplebar.js"></script>
<script src="/assets/js/main/admin.js"></script>

<!-- CoreUI -->
<script src="https://cdn.jsdelivr.net/npm/@coreui/coreui-pro@5.0.0-rc.2/dist/js/coreui.bundle.min.js"
    integrity="sha384-aGTCMmOaT4om0+lHGIaFUYKB+b7cRjX9/j/rq19umAyp+xKEAePEeVcH3pTxkVbu" crossorigin="anonymous">
</script>

<!-- Livewire Scripts -->
@livewireScripts

<!-- Enhanced Event Handlers -->
<script>
    // Unified Delete System Event Handlers
    window.addEventListener('confirmDelete', event => {
        Swal.fire({
            title: event.detail.title || 'Confirm Delete',
            text: event.detail.message || 'Are you sure you want to delete this item?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            customClass: {
                popup: 'bg-dark text-white',
                title: 'text-white',
                content: 'text-white'
            },
            background: '#2c3e50'
        }).then((result) => {
            if (result.isConfirmed) {
                window.Livewire.dispatch('delete', [event.detail.id]);
            }
        });
    });

    // Bulk Delete Confirmation
    window.addEventListener('confirmBulkDelete', event => {
        Swal.fire({
            title: event.detail.title || 'Confirm Bulk Delete',
            text: event.detail.message || 'Are you sure you want to delete these items?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete them!',
            cancelButtonText: 'No, cancel!',
            customClass: {
                popup: 'bg-dark text-white',
                title: 'text-white',
                content: 'text-white'
            },
            background: '#2c3e50'
        }).then((result) => {
            if (result.isConfirmed) {
                window.Livewire.dispatch('bulkDelete', [event.detail.ids]);
            }
        });
    });

    // Unassign Course Confirmation
    window.addEventListener('confirmUnassignCourse', event => {
        Swal.fire({
            title: event.detail.title || 'Confirm Unassign',
            text: event.detail.message || 'Are you sure you want to unassign this course?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, unassign it!',
            cancelButtonText: 'No, cancel!',
            customClass: {
                popup: 'bg-dark text-white',
                title: 'text-white',
                content: 'text-white'
            },
            background: '#2c3e50'
        }).then((result) => {
            if (result.isConfirmed) {
                window.Livewire.dispatch('unassignCourse', [event.detail.userId, event.detail
                .courseId]);
            }
        });
    });

    // Unassign Section Confirmation
    window.addEventListener('confirmUnassignSection', event => {
        Swal.fire({
            title: event.detail.title || 'Confirm Unassign',
            text: event.detail.message || 'Are you sure you want to unassign this section?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, unassign it!',
            cancelButtonText: 'No, cancel!',
            customClass: {
                popup: 'bg-dark text-white',
                title: 'text-white',
                content: 'text-white'
            },
            background: '#2c3e50'
        }).then((result) => {
            if (result.isConfirmed) {
                window.Livewire.dispatch('unassignSection', [event.detail.userId, event.detail.courseId,
                    event.detail.sectionId
                ]);
            }
        });
    });

    // Success Delete Handler
    window.addEventListener('successDeleted', event => {
        Swal.fire({
            title: 'Success!',
            text: event.detail.message || 'The item has been deleted successfully.',
            icon: 'success',
            confirmButtonText: 'OK',
            customClass: {
                popup: 'bg-dark text-white',
                title: 'text-white',
                content: 'text-white'
            },
            background: '#2c3e50'
        });
    });

    // Delete Failed Handler
    window.addEventListener('deleteFailed', event => {
        Swal.fire({
            title: 'Delete Failed',
            text: event.detail.message || 'An error occurred while trying to delete the item.',
            icon: 'error',
            confirmButtonText: 'OK',
            customClass: {
                popup: 'bg-dark text-white',
                title: 'text-white',
                content: 'text-white'
            },
            background: '#2c3e50'
        });
    });

    // General Alert Handler
    window.addEventListener('alert', event => {
        const config = {
            title: event.detail.title || '',
            text: event.detail.text || event.detail.message || '',
            icon: event.detail.icon || 'info',
            confirmButtonText: 'OK',
            customClass: {
                popup: 'bg-dark text-white',
                title: 'text-white',
                content: 'text-white'
            },
            background: '#2c3e50'
        };

        if (event.detail.timer) {
            config.timer = event.detail.timer;
            config.timerProgressBar = true;
        }

        if (event.detail.toast) {
            config.toast = true;
            config.position = event.detail.position || 'top-end';
            config.showConfirmButton = false;
        }

        Swal.fire(config);
    });

    // Image View Handler
    window.addEventListener('view-image', event => {
        Swal.fire({
            title: 'Profile Picture',
            imageUrl: event.detail.text,
            imageWidth: 400,
            imageHeight: 400,
            imageAlt: 'Profile Picture',
            showConfirmButton: false,
            showCloseButton: true,
            customClass: {
                popup: 'bg-dark',
                title: 'text-white'
            },
            background: '#2c3e50'
        });
    });

    // Copy to Clipboard Handler
    window.addEventListener('copyToClipboard', event => {
        const email = event.detail.email;

        if (navigator.clipboard && window.isSecureContext) {
            // Use modern clipboard API
            navigator.clipboard.writeText(email).then(() => {
                Swal.fire({
                    title: 'Email Copied!',
                    text: `${email} has been copied to clipboard`,
                    icon: 'success',
                    timer: 2000,
                    timerProgressBar: true,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    customClass: {
                        popup: 'bg-success text-white'
                    }
                });
            }).catch(() => {
                fallbackCopyTextToClipboard(email);
            });
        } else {
            // Fallback for older browsers
            fallbackCopyTextToClipboard(email);
        }
    });

    // Fallback copy function for older browsers
    function fallbackCopyTextToClipboard(text) {
        const textArea = document.createElement("textarea");
        textArea.value = text;
        textArea.style.top = "0";
        textArea.style.left = "0";
        textArea.style.position = "fixed";

        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();

        try {
            const successful = document.execCommand('copy');
            if (successful) {
                Swal.fire({
                    title: 'Email Copied!',
                    text: `${text} has been copied to clipboard`,
                    icon: 'success',
                    timer: 2000,
                    timerProgressBar: true,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    customClass: {
                        popup: 'bg-success text-white'
                    }
                });
            } else {
                throw new Error('Copy command failed');
            }
        } catch (err) {
            Swal.fire({
                title: 'Copy Failed',
                text: 'Please copy the email manually: ' + text,
                icon: 'error',
                confirmButtonText: 'OK',
                customClass: {
                    popup: 'bg-dark text-white',
                    title: 'text-white',
                    content: 'text-white'
                },
                background: '#2c3e50'
            });
        }

        document.body.removeChild(textArea);
    }

    // Password visibility toggle
    $(document).ready(function() {
        $('.password__icon').click(function() {
            const passwordField = $(this).siblings('.auth__password');
            const icon = $(this).find('i');

            if (passwordField.attr('type') === 'password') {
                passwordField.attr('type', 'text');
                icon.removeClass('ti-eye-off').addClass('ti-eye');
            } else {
                passwordField.attr('type', 'password');
                icon.removeClass('ti-eye').addClass('ti-eye-off');
            }
        });
    });
    // Custom CSS for better styling
    const style = document.createElement('style');
    style.textContent = `
    .bg-blue-50 {
        background-color: rgba(59, 130, 246, 0.1) !important;
    }
    .bg-red-50 {
        background-color: rgba(239, 68, 68, 0.1) !important;
    }
    .swal2-popup {
        font-size: 1rem;
    }
    .swal2-title {
        font-size: 1.5rem;
    }
    .form-check-input:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
`;
    document.head.appendChild(style);
</script>

</body>

</html>
