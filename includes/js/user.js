const userSettingsContainer = document.getElementById("user-settings");
const activtyContainer = document.getElementById("user-activity");
const editProfile = document.getElementById("edit-profile");
const accountSettings = document.getElementById("account-settings");
const activityBtn = document.getElementById("activity-btn");
const editProfileBtn = document.getElementById("edit-profile-btn");
const accountSettingsBtn = document.getElementById("account-settings-btn");

//editors
// Edit Profile section
const usernameEdit = document.getElementById("username-edit");
const proffessionEdit = document.getElementById("proffession-edit");
const bioEdit = document.getElementById("bio-edit");
const profilePicEdit = document.getElementById("profile-pic-edit");

// Account Settings section
const emailEdit = document.getElementById("email-edit");
const passwordEdit = document.getElementById("password-edit");
const locationEdit = document.getElementById("location-edit");
const genderEdit = document.getElementById("gender-edit");

//initialize the current page as an empty string
let currentSection = "";

document.addEventListener("DOMContentLoaded", function () {
  getCurrentSection();
  //event listeners for the nav buttons
  activityBtn.addEventListener("click", () => {
    changeSection("activity");
  });
  editProfileBtn.addEventListener("click", () => {
    changeSection("edit-profile");
  });
  accountSettingsBtn.addEventListener("click", () => {
    changeSection("account-settings");
  });
});

//get or set the current page with search params
function getCurrentSection() {
  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.has("cs")) {
    // return urlParams.get("cs");
    const section = urlParams.get("cs");
    currentSection = section;
  } else {
    currentSection = "activity";
  }
  showSection();
}
//show the current page on window load
window.onload = () => {
  showSection();
};

function changeSection(page) {
  const url = new URL(window.location);
  url.searchParams.set("cs", page);
  window.history.replaceState({}, "", url);
  getCurrentSection();
}

function showSection() {
  //hide all pages
  activtyContainer.style.display = "none";
  editProfile.style.display = "none";
  accountSettings.style.display = "none";
  // show the currentSection
  switch (currentSection) {
    case "activity":
      activtyContainer.style.display = "block";
      break;
    case "edit-profile":
      editProfile.style.display = "flex";
      break;
    case "account-settings":
      accountSettings.style.display = "flex";
      break;
  }
  //update active button states
  activityBtn.classList.remove("active");
  editProfileBtn.classList.remove("active");
  accountSettingsBtn.classList.remove("active");

  switch (currentSection) {
    case "activity":
      activityBtn.classList.add("active");
      break;
    case "edit-profile":
      editProfileBtn.classList.add("active");
      break;
    case "account-settings":
      accountSettingsBtn.classList.add("active");
      break;
  }
}

//editing accunt settings and profile functions

profilePicEdit.addEventListener("click", () => {
  openModal(profilePicForm);
  const profilePhotoInput = document.getElementById("profile_photo");
  const imgPreview = document.getElementById("img-preview");
  profilePhotoInput.addEventListener("change", function () {
    const file = this.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function (e) {
        imgPreview.src = e.target.result;
        imgPreview.style.display = "block";
      };
      reader.readAsDataURL(file);
    } else {
      imgPreview.src = "${profile_photo}";
    }
  });
});

bioEdit.addEventListener("click", () => {
  openModal(bioForm);
});

emailEdit.addEventListener("click", () => {
  openModal(emailForm);
});

passwordEdit.addEventListener("click", () => {
  openModal(changePasswordForm);
});

genderEdit.addEventListener("click", () => {
  openModal(genderForm);
});

locationEdit.addEventListener("click", () => {
  openModal(() =>
    textFormGenerator(
      "Edit location",
      userLocation,
      "new_location",
      "update_location"
    )
  );
});

usernameEdit.addEventListener("click", () => {
  openModal(() =>
    textFormGenerator(
      "Edit username",
      username,
      "new_username",
      "save_username"
    )
  );
});

proffessionEdit.addEventListener("click", () => {
  openModal(() =>
    textFormGenerator(
      "Edit proffession",
      proffession,
      "new_proffession",
      "save_proffession"
    )
  );
});
