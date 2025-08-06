let toggleBtn = document.getElementById('toggle-btn');
let body = document.body;
let darkMode = localStorage.getItem('dark-mode');
var logo = document.getElementById("logo");

const enableDarkMode = () => {
    toggleBtn.classList.replace('fa-sun', 'fa-moon');
    body.classList.add('dark');
    localStorage.setItem('dark-mode', 'enabled');
}

const disableDarkMode = () => {
    toggleBtn.classList.replace('fa-moon', 'fa-sun');
    body.classList.remove('dark');
    localStorage.setItem('dark-mode', 'disabled');
}

if (darkMode === 'enabled') {
    enableDarkMode();
}

toggleBtn.onclick = (e) => {
    darkMode = localStorage.getItem('dark-mode');
    if (darkMode === 'disabled') {
        enableDarkMode();
        logo.src = "/assets/images/logo/Treasure Academy logo light-mode.png";
    } else {
        disableDarkMode();
        logo.src = "/assets/images/logo/Treasure Academy logo dark-mode.png";
    }
}

if (darkMode === 'disabled') {
    logo.src = "../../../../public/assets/images/logo/Treasure Academy logo dark-mode.png";
} else {
    logo.src = "../../../../public/assets/images/logo/Treasure Academy logo light-mode.png";
}

//=============================

let profile = document.querySelector('.header .flex .profile');
let userBtn = document.querySelector('#user-btn');

document.querySelector('#user-btn').onclick = () => {
    profile.classList.toggle('active');
    search.classList.remove('active');
}

// Event listener for clicks anywhere on the document
document.addEventListener('click', (event) => {
    const clickedElement = event.target;

    // Check if the clicked element or its parent is the profile or user button
    if (!clickedElement.closest('.header .flex .profile') && clickedElement !== userBtn) {
        // Remove 'active' class from profile if clicked outside
        profile.classList.remove('active');
    }
});

let search = document.querySelector('.header .flex .search-form');

document.querySelector('#search-btn').onclick = () => {
    search.classList.toggle('active');
    profile.classList.remove('active');
}

let sideBar = document.querySelector('.side-bar');

document.querySelector('#menu-btn').onclick = () => {
    sideBar.classList.toggle('active');
    body.classList.toggle('active');
}

document.querySelector('#close-btn').onclick = () => {
    sideBar.classList.remove('active');
    body.classList.remove('active');
}

window.onscroll = () => {
    profile.classList.remove('active');
    search.classList.remove('active');

    if (window.innerWidth < 1200) {
        sideBar.classList.remove('active');
        body.classList.remove('active');
    }
}

//==========================

//dropdwon for sections

document.addEventListener('DOMContentLoaded', function () {
    // Get all elements with class 'control-hide'
    var controlHideElements = document.querySelectorAll('.control-hide');

    // Loop through each element
    controlHideElements.forEach(function (element) {
        // Add event listener to toggle the clicked section
        element.addEventListener('click', function (event) {
            event.preventDefault();

            // Get the next sibling which should be the submenu
            var submenu = element.nextElementSibling;

            // Toggle the visibility of the submenu
            if (submenu.classList.contains('active')) {
                // Close the submenu
                submenu.classList.remove('active');
                submenu.classList.add('hide');
                submenu.style.height = '0px';
                element.classList.remove('active'); // Remove 'active' class from control-hide
            } else {
                // Open the submenu
                submenu.classList.remove('hide');
                submenu.classList.add('active');
                submenu.style.height = submenu.scrollHeight + 'px';

                // Add 'active' class to control-hide
                element.classList.add('active');

                // Remove 'active' class from other control-hide elements
                controlHideElements.forEach(function (el) {
                    if (el !== element) {
                        el.classList.remove('active');
                    }
                });
            }
        });

        // Check if the submenu is initially open and add 'active' class to control-hide element
        if (element.nextElementSibling.classList.contains('active')) {
            element.classList.add('active');
        }
    });
});

//==================
const passwordIcon = document.querySelectorAll('.password__icon');
const authPassword = document.querySelectorAll('.auth__password');

for (let i = 0; i < passwordIcon.length; ++i) {
    passwordIcon[i].addEventListener('click', (event) => {
        const inputField = event.currentTarget.parentElement.querySelector('input');
        if (event.target.classList.contains('ti-eye-off')) {
            event.target.classList.remove('ti-eye-off');
            event.target.classList.add('ti-eye');
            inputField.type = 'text';
        } else {
            event.target.classList.add('ti-eye-off');
            event.target.classList.remove('ti-eye');
            inputField.type = 'password';
        }
    });
}