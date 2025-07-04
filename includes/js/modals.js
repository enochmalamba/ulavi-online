const textFormGenerator = (label, value, name, submitName) => {
  return `
     <form action="includes/backend/account_edit.php" method="post" >
        <input type="hidden" name="csrf_token" value="${CSRF_TOKEN}">
        <label>${label}</label>
        <input type="text" name="${name}" placeholder="${label}" value="${value}">
        <div class="form-btns">
            <button id="cancel-modal-btn">Cancel</button>
            <button type="submit" name="${submitName}">Save</button>
        </div>
    </form>
  `;
};

const bioForm = () => {
  return `
   <form action="includes/backend/account_edit.php" method="post">
   <input type="hidden" name="csrf_token" value="${CSRF_TOKEN}">
        <label for="new_bio">Update bio</label>
        <textarea name="new_bio">${bio}</textarea>
        <div class="form-btns">
            <button id="cancel-modal-btn">Cancel</button>
            <button type="submit" name="update_bio">Save</button>
        </div>
    </form>
  `;
};

const changePasswordForm = () => {
  return `
 <form action="includes/backend/account_edit.php" method="post">
       <input type="hidden" name="csrf_token" value="${CSRF_TOKEN}">
        <label>New password</label>
        <input type="password" name="new_password" required />
        <label>Confirm password</label>
        <input type="password" name="confirm_password" required />
        <div class="form-btns">
            <button id="cancel-modal-btn">Cancel</button>
            <button type="submit" name="update_password">Save</button>
        </div>

    </form>
  `;
};

const emailForm = () => {
  return `
    <form action="includes/backend/account_edit.php" method="post">
    <input type="hidden" name="csrf_token" value="${CSRF_TOKEN}">
        <label>New email</label>
        <input type="email" name="new_email" value="${email}" required />
        <div class="form-btns">
            <button id="cancel-modal-btn">Cancel</button>
            <button type="submit" name="update_email">Save</button>
        </div>
    </form>
  `;
};

const profilePicForm = () => {
  return `
 <form action="includes/backend/account_edit.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="${CSRF_TOKEN}">
        <label>Upload new profile picture</label>
        <input type="file" accept="image/*" name="profile_photo" id="profile_photo" required />
        <img src="${profile_photo}" alt="Image preview" id="img-preview" style="max-width: 200px; max-height: 200px;">
        <div class="form-btns">
            <button id="cancel-modal-btn">Cancel</button>
            <button type="submit" name="update_profile_pic">Save</button>
        </div>
       
    </form>
  `;
};

const genderForm = () => {
  return `
  <form action="includes/backend/account_edit.php" method="post">
    <input type="hidden" name="csrf_token" value="${CSRF_TOKEN}">
    <label>Change your identity</label>
    <select name="gender" id="gender" required>
        <option disabled selected value>--Select your identity--</option>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
        <option value="Other">Other</option>
        <option value="Hidden">Prefer not to say</option>
     </select>
     <div class="form-btns">
    <button id="cancel-modal-btn">Cancel</button>
    <button type="submit" name="update_gender">Save</button>
    </div>
  </form>
  `;
};

const logOutModal = () => {
  return `
    <form class="modal-form" method="post" action="includes/backend/auth.php">
    <input type="hidden" name="csrf_token" value="${CSRF_TOKEN}">
        <p>Are you sure you want to log out?</p>
        <div class="form-btns">
         <button type="reset" id="cancel-modal-btn">Cancel</button>
                <button type="submit" name="logout">Log Out</button>
        </div>
    </form>`;
};

const createPostModal = () => {
  return `   
        <form action="includes/backend/post_submit.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="${CSRF_TOKEN}">
            <label for="title">Enter post title <span>*</span></label>
            <input type="text" name="title" id="title" placeholder="Write an attention-grabbing headline..." required>

            <label for="content">Enter post content <span>*</span></label>
            <textarea name="content" id="content" placeholder="Share your thoughts, ideas, or story in detail..." required></textarea>

            <label for="post_image">Upload with an image (Optional)</label>
            <input type="file" name="post_image" id="post_image" accept="image/*">
            <div class="upload-img-preview">
                <img src="" alt="Image preview" id="img-preview">
                <span class="material-symbols-outlined" id="img-preview-close">
                    close
                </span>
            </div>
            <div class="form-btns">
                <button type="reset" id="cancel-modal-btn">Cancel</button>
                <button type="submit" name="create_post">Publish Post</button>
            </div>
        </form>
    `;
};

const authModal = () => {
  return `
       <div class="unlock-content-modal">
        <div class="modal-header">
          <h2 class="modal-title">Unlock All Features</h2>
          <p class="modal-subtitle">
            Join thousands of users and get access to all features
          </p>
        </div>

        <ul class="features-list">
          <li class="feature-item">
            <i class="bx bx-check"></i>
            <span
              >Create a profile for yourself, your team, or your
              organization</span
            >
          </li>
          <li class="feature-item">
            <i class="bx bx-check"></i>
            <span>Get a voice and create posts on your profile</span>
          </li>
          <li class="feature-item">
            <i class="bx bx-check"></i>
            <span>Connect with others and share ideas</span>
          </li>
          <li class="feature-item">
            <i class="bx bx-plus"></i>
            <span>+Many more </span>
          </li>
        </ul>

        <div class="buttons-container">
          <a href="signup.php" class="btn btn-primary">Create Account</a>
          <a href="signin.php" class="btn btn-secondary">Login</a>
          <a href="home.php" class="btn btn-ghost">Maybe later </a>
        </div>
      </div>
  `;
};
