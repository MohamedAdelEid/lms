import './bootstrap';

document.addEventListener('livewire:load', function () {
    Livewire.on('emailCopied', function (email) {
        navigator.clipboard.writeText(email)
            .then(() => {
                alert('Email copied to clipboard: ' + email);
            })
            .catch((error) => {
                console.error('Error copying email:', error);
            });
    });
});