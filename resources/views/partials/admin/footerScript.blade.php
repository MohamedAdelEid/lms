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
    integrity="sha384-aGTCMmOaT4om0+lHGIaFUYKB+b7cRjX9/j/rq19umAyp+xKEAePEeVcH3pTxkVbu" crossorigin="anonymous"></script>

<!-- Livewire Scripts -->
@livewireScripts

<!-- Enhanced Event Handlers -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof Livewire !== 'undefined') {
        console.log('Livewire loaded successfully');
        
        // Simple alert handler (for backward compatibility)
        Livewire.on('alert', (data) => {
            Swal.fire({
                position: data.position || 'center',
                timer: data.timer || 5000,
                toast: data.toast || false,
                text: data.text,
                showConfirmButton: data.showConfirmButton || false,
                width: data.width || '300px',
                icon: data.icon || 'success'
            });
        });

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
                reverseButtons: true
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
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.Livewire.dispatch('bulkDelete', [event.detail.ids]);
                }
            });
        });

        // Success Delete Handler
        window.addEventListener('successDeleted', event => {
            Swal.fire({
                title: 'Deleted!',
                text: event.detail.message || 'The item has been deleted successfully.',
                icon: 'success',
                timer: 3000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end'
            });
        });

        // Delete Failed Handler
        window.addEventListener('deleteFailed', event => {
            Swal.fire({
                title: 'Delete Failed',
                text: event.detail.message || 'An error occurred while trying to delete the item.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });

        // Copy to Clipboard Handler
        window.addEventListener('copyToClipboard', event => {
            const email = event.detail.email;
            
            // Modern clipboard API
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(email).then(() => {
                    Swal.fire({
                        title: 'Email Copied!',
                        text: `${email} has been copied to clipboard`,
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                }).catch(() => {
                    fallbackCopyTextToClipboard(email);
                });
            } else {
                // Fallback for older browsers
                fallbackCopyTextToClipboard(email);
            }
        });

        // Fallback copy function
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
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                } else {
                    throw new Error('Copy command failed');
                }
            } catch (err) {
                Swal.fire({
                    title: 'Copy Failed',
                    text: 'Unable to copy email to clipboard',
                    icon: 'error',
                    timer: 2000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
            }
            
            document.body.removeChild(textArea);
        }

    } else {
        console.error('Livewire not loaded!');
    }
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
