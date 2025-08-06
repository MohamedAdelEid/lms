
//Dark Mode & Light Mode 
var iconMode = document.getElementById("icon-mode");
var logo = document.getElementById("logo");
var mode = localStorage.getItem("mode") || ''; // Retrieve mode from localStorage or set to empty string

if (iconMode) {
  if (mode === 'dark') {
    document.body.classList.add("dark-mode");
    iconMode.src = "/assets/images/dark mode icons/sun.png";
    logo.src = "/assets/images/logo/Treasure Academy logo light-mode.png";
  } else {
    document.body.classList.add("light-mode");
    iconMode.src = "/assets/images/dark mode icons/moon.png";
    logo.src = "/assets/images/logo/Treasure Academy logo dark-mode.png";
  }

  iconMode.onclick = function () {
    if (mode === 'light') {
      document.body.classList.remove("light-mode");
      document.body.classList.add("dark-mode");
      iconMode.src = "/assets/images/dark mode icons/sun.png";
      logo.src = "/assets/images/logo/Treasure Academy logo light-mode.png";
      mode = 'dark'; // Update mode variable
    } else {
      document.body.classList.remove("dark-mode");
      document.body.classList.add("light-mode");
      iconMode.src = "/assets/images/dark mode icons/moon.png";
      logo.src = "/assets/images/logo/Treasure Academy logo dark-mode.png";
      mode = 'light'; // Update mode variable
    }
    localStorage.setItem("mode", mode); // Save mode to localStorage
  };
}

/*------------------
    Preloader
--------------------*/

$(window).on('load', function () {
  $(".loader").fadeOut();
  $("#preloder").delay(200).fadeOut("slow");
});

/*----------- 
aside page
----------*/

//add active class to element if be in page 
document.addEventListener("DOMContentLoaded", function () {
  // Get the current page URL
  var currentPageUrl = window.location.href;

  // Get all sidebar links
  var sidebarLinks = document.querySelectorAll('.color-active');

  // Loop through each sidebar link
  sidebarLinks.forEach(function (link) {
    // Get the link's href attribute
    var linkHref = link.getAttribute('href');

    // Check if the current page URL matches the link's href attribute
    if (currentPageUrl.includes(linkHref)) {
      // Add the active class to the link
      link.classList.add('active');
    }
  });
});

//===============

//add class active to control becouse hide add category ,add ....
document.addEventListener("DOMContentLoaded", function () {
  var controlItem = document.getElementById('controlItem');
  var control = document.querySelector('.control');

  // Set controlItem to display:block initially
  controlItem.style.display = 'block';

  controlItem.addEventListener('click', function () {
    // Toggle the display of the control class
    if (control.style.display === 'none') {
      control.style.display = 'block';
      control.style = 'block';
    } else {
      control.style.display = 'none';
    }
  });
});

document.addEventListener('DOMContentLoaded', function () {
  // Get all elements with class 'control-hide'
  var controlHideElements = document.querySelectorAll('.control-hide');

  // Loop through each element
  controlHideElements.forEach(function (element) {
    // Add event listener to toggle 'hide' class
    element.addEventListener('click', function (event) {
      event.preventDefault();

      // Get the next sibling which should be the submenu
      var submenu = element.nextElementSibling;

      // Toggle the 'hide' class on the submenu
      submenu.classList.toggle('hide');

      // Check if submenu is visible
      var isVisible = !submenu.classList.contains('hide');

      // Apply transition based on visibility
      if (isVisible) {
        submenu.style.height = submenu.scrollHeight + 'px';
      } else {
        submenu.style.height = '0px';
      }
    });
  });
});

//===============================================

//progress upload file "video"
function reload() {
  location.reload(); // Reload the current page
}
function uploadFile() {
  var file = _("file1").files[0];
  var formdata = new FormData();
  formdata.append("file1", file);
  var ajax = new XMLHttpRequest();
  ajax.upload.addEventListener("progress", progressHandler, false);
  ajax.addEventListener("load", completeHandler, false);
  ajax.addEventListener("error", errorHandler, false);
  ajax.addEventListener("abort", abortHandler, false);
  ajax.open("POST", ""); // Change the URL to your PHP script
  ajax.send(formdata);
}

function progressHandler(event) {
  var percent = (event.loaded / event.total) * 100;
  _("progressBar").value = Math.round(percent);
  var loadedMB = (event.loaded / (1024 * 1024)).toFixed(2); // Convert bytes to megabytes with 2 decimal places
  var totalMB = (event.total / (1024 * 1024)).toFixed(2); // Convert bytes to megabytes with 2 decimal places
  _("status").innerHTML = Math.round(percent) + "% uploaded... please wait";
  _("loaded_n_total").innerHTML = "Uploaded " + loadedMB + " MB of " + totalMB + " MB";
}

function completeHandler(event) {
  _("status").innerHTML = event.target.responseText;
  _("progressBar").value = 0; // Clear progress bar after successful upload
}

function errorHandler(event) {
  _("status").innerHTML = "Upload Failed";
}

function abortHandler(event) {
  _("status").innerHTML = "Upload Aborted";
}

function _(el) {
  return document.getElementById(el);
}

/*----------- 
myProfile page
----------*/

var modalImg = document.getElementById("modalImage");
var profilePic = document.getElementById("profilePicContainer");

if (modalImg && profilePic) {
  // Set src attribute of modal image
  modalImg.src = profilePic.src;

  // Get the profile picture source
  var profilePicSrc = profilePic.src;

  // Set the source of modal image
  modalImg.src = profilePicSrc;
}

//============

//view courses in view pages
// Add event listener to the click-desc-view div


//===============

//view desc in view pages
// Add event listener to the click-desc-view div
var clickDescViewElements = document.querySelectorAll(".click-desc-view");
clickDescViewElements.forEach(function (element) {
  element.addEventListener("click", function () {
    // Get the modal element
    var modal = document.getElementById("modal-view-desc");
    // Get the text content from the clicked element
    var descText = this.textContent.trim();
    // Set the text content of modal-body's h2 to the clicked text
    document.getElementById("desc").textContent = descText;
    // Display the modal
    modal.style.display = "block";
  });
});

// Close modal
function closeViewdesc() {
  var modalDesc = document.getElementById("modal-view-desc");
  modalDesc.style.display = "none";
}

//===============

//view image in view pages 
// Add event listener to the click-img-view div
var clickImgViewElements = document.querySelectorAll(".click-img-view");
if (clickImgViewElements) {
  clickImgViewElements.forEach(function (element) {
    element.addEventListener("click", function () {
      // Get the modal element
      var modal = document.getElementById("modal-view");
      // Get the image source from the clicked img element
      var imgSrc = this.querySelector("img").src;
      // Set the src attribute of modalImage to the clicked image source
      document.getElementById("modalImage").src = imgSrc;
      // Display the modal
      modal.style.display = "block";
    });
  });

  // Close modal when clicking outside the modal content
  window.onclick = function (event) {
    var modal = document.getElementById("modal-view");
    if (event.target == modal) {
      closeViewImg();
    }
  }

  // Close image view
  function closeViewImg() {
    var modal = document.getElementById("modal-view");
    modal.style.display = "none";
  }
}

//===============================

// profile image
// Add event listener to the "Edit" button to display the modal
var modalFound = document.getElementById("click-modal");
if (modalFound) {
  document.getElementById("click-modal").addEventListener("click", function (event) {
    var modal = document.getElementById("modal");
    modal.style.display = "block";
    event.stopPropagation(); // Prevent the event from bubbling up to the window
  });

  // Close modal when clicking outside the modal content
  window.onclick = function (event) {
    var modal = document.getElementById("modal");
    if (event.target == modal) {
      closeModal();
    }
  }

  // Close modal
  function closeModal() {
    var modal = document.getElementById("modal");
    modal.style.display = "none";
  }
}

//=====================

document.addEventListener("DOMContentLoaded", function () {
  // Check if there's a stored state for the settings div
  var settingsState = localStorage.getItem('settingsState');

  // If there's a stored state, set the display accordingly
  if (settingsState === 'block') {
    document.getElementById('settings').style.display = 'block';
    document.getElementById('personal-details').style.display = 'none';
    document.querySelector('.clickable-paragraph[data-target="settings"]').classList.add('active');
  } else {
    document.querySelector('.clickable-paragraph[data-target="personal-details"]').classList.add('active');
  }

  // Check if there's a stored state for the settings edit div
  var settingsEditState = localStorage.getItem('settingsEditState');

  // If there's a stored state, set the display accordingly
  if (settingsEditState === 'block') {
    document.getElementById('password-edit').style.display = 'block';
    document.getElementById('personal-details-edit').style.display = 'none';
    document.querySelector('.clickable-edit[data-target="password-edit"]').classList.add('active');
  } else {
    document.querySelector('.clickable-edit[data-target="personal-details-edit"]').classList.add('active');
  }

  // Toggle between "Personal details" and "Settings"
  document.querySelectorAll('.clickable-paragraph').forEach(function (el) {
    el.addEventListener('click', function () {
      var targetId = this.getAttribute('data-target');
      document.getElementById(targetId).style.display = 'block';
      document.getElementById(targetId === 'personal-details' ? 'settings' : 'personal-details').style.display = 'none';
      document.querySelectorAll('.clickable-paragraph').forEach(function (elem) {
        if (elem.getAttribute('data-target') === targetId) {
          elem.classList.add('active');
        } else {
          elem.classList.remove('active');
        }
      });

      // Store the state of the settings div
      if (targetId === 'settings') {
        localStorage.setItem('settingsState', 'block');
      } else {
        localStorage.setItem('settingsState', 'none');
      }
    });
  });

  // Toggle between "Personal details edit" and "Settings edit"
  document.querySelectorAll('.clickable-edit').forEach(function (el) {
    el.addEventListener('click', function () {
      var targetId = this.getAttribute('data-target');
      document.getElementById(targetId).style.display = 'block';
      document.getElementById(targetId === 'personal-details-edit' ? 'password-edit' : 'personal-details-edit').style.display = 'none';
      document.querySelectorAll('.clickable-edit').forEach(function (elem) {
        if (elem.getAttribute('data-target') === targetId) {
          elem.classList.add('active');
        } else {
          elem.classList.remove('active');
        }
      });

      // Store the state of the settings edit div
      if (targetId === 'password-edit') {
        localStorage.setItem('settingsEditState', 'block');
      } else {
        localStorage.setItem('settingsEditState', 'none');
      }
    });
  });
});

//=====================

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

