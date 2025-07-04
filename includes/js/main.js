const overlay = document.getElementById("overlay");
const modalContainer = document.getElementById("modal-container");
const createPostBtn = document.getElementById("create-post-btn");
const feedPostCreateBtn = document.getElementById("feedPostCreateBtn");
const lightModeBtns = document.querySelectorAll(".light-mode");
const darkModeBtns = document.querySelectorAll(".dark-mode");
const logoutBtn = document.querySelectorAll(".logout-btn");

lightModeBtns.forEach((btn) => {
  btn.addEventListener("click", toggleLightMode);
});

darkModeBtns.forEach((btn) => {
  btn.addEventListener("click", toggleDarkMode);
});

function toggleLightMode() {
  localStorage.setItem("theme", "light");
  loadTheme();
}

function toggleDarkMode() {
  localStorage.setItem("theme", "dark");
  loadTheme();
}

function loadTheme() {
  const theme = localStorage.getItem("theme");
  if (theme === "dark") {
    document.body.classList.add("dark-theme");
  } else {
    document.body.classList.remove("dark-theme");
  }
  changeUIicon(theme);
}

function changeUIicon(theme) {
  if (theme === "dark") {
    darkModeBtns.forEach((btn) => {
      btn.style.display = "none";
    });
    lightModeBtns.forEach((btn) => {
      btn.style.display = "flex";
    });
  } else {
    darkModeBtns.forEach((btn) => {
      btn.style.display = "flex";
    });
    lightModeBtns.forEach((btn) => {
      btn.style.display = "none";
    });
  }
}

// window.addEventListener("load", loadTheme);
loadTheme();

//start modal functionality
function openModal(modalGeneratorFn) {
  overlay.style.display = "flex";
  overlay.onclick = closeModals;
  const modal = modalGeneratorFn();
  if (modal === undefined || modal === null || modal === "") {
    modalContainer.innerHTML = `<div class="modal-form"><p>Something went wrong</p></div>`;
    return;
  }
  modalContainer.innerHTML = modal;
  modalContainer.style.display = "flex";
  const cancelModalBtn = document.getElementById("cancel-modal-btn");
  cancelModalBtn.onclick = closeModals;
}

function closeModals() {
  overlay.style.display = "none";
  modalContainer.style.display = "none";
  modalContainer.innerHTML = "";
}

logoutBtn.forEach((btn) => {
  btn.onclick = () => {
    openModal(logOutModal);
  };
});
if (createPostBtn) {
  createPostBtn.onclick = () => {
    openModal(createPostModal);
    const postImageInput = document.getElementById("post_image");
    const imgPreview = document.getElementById("img-preview");
    const imgPreviewClose = document.getElementById("img-preview-close");
    postImageInput.addEventListener("change", function () {
      const file = this.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
          imgPreview.src = e.target.result;
          imgPreview.style.display = "block";
          imgPreviewClose.style.display = "block";
        };
        reader.readAsDataURL(file);
      } else {
        imgPreview.src = "";
        imgPreview.style.display = "none";
        imgPreviewClose.style.display = "none";
      }
    });
    imgPreviewClose.addEventListener("click", function () {
      imgPreview.src = "";
      imgPreview.style.display = "none";
      imgPreviewClose.style.display = "none";
      postImageInput.value = "";
    });
  };
}
if (feedPostCreateBtn) {
  feedPostCreateBtn.onclick = () => openModal(createPostModal);
}

if (document.querySelectorAll(".trigger-auth-btn")) {
  document.querySelectorAll(".trigger-auth-btn").forEach((btn) => {
    btn.onclick = () => {
      openModal(authModal);
    };
  });
}

// Show update notifications

document.addEventListener("DOMContentLoaded", function () {
  // Check for update message from PHP
  if (typeof updateMessage !== "undefined" && updateMessage) {
    showNotification(updateMessage.text, updateMessage.type);
  }

  // Alternatively, check for a data attribute on the body
  const bodyMessage = document.body.dataset.message;
  const bodyMessageType = document.body.dataset.messageType;
  if (bodyMessage) {
    showNotification(bodyMessage, bodyMessageType || "success");
  }
});

function showNotification(message, type = "success") {
  // Create notification element
  const notification = document.createElement("div");
  notification.className = `notification ${type}`;
  notification.innerHTML = `
        <div class="notification-content">
            <span class="notification-message">${message}</span>
            <button class="notification-close">&times;</button>
        </div>
    `;

  // Add to body
  document.body.appendChild(notification);

  // Close button functionality
  notification
    .querySelector(".notification-close")
    .addEventListener("click", () => {
      notification.remove();
    });

  // Auto-remove after 5 seconds
  setTimeout(() => {
    notification.classList.add("fade-out");
    setTimeout(() => notification.remove(), 300);
  }, 5000);
}
