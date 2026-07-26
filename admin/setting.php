<?php include("../include/sidebar.php"); ?>

<div class="main-content p-4">
  <!-- Page Header -->
  <div class="d-flex justify-content-between align-items-center mb-2">
    <div>
      <h2 class="font-display fw-bold mb-0 text-uppercase">Profile Settings</h2>
      <div class="text-muted small">ការកំណត់ប្រវត្តិរូបអ្នកគ្រប់គ្រង</div>
    </div>
  </div>

  <div class="border-bottom my-3" style="border-style: dashed !important; opacity: 0.3;"></div>

  <!-- Profile Settings Form -->
  <div class="card border-0 shadow-sm">
    <div class="card-body p-4">
      <!-- Form action should point to your backend script (e.g., update_profile.php) -->
      <form action="" method="POST" enctype="multipart/form-data">
        <div class="row">

          <!-- Profile Picture Section -->
          <div class="col-md-4 text-center mb-4 mb-md-0 border-end">
            <!-- Placeholder avatar image -->
            <img src="../team/user.png"
              class="rounded-circle img-thumbnail mb-3 shadow-sm"
              alt="Admin Avatar"
              style="width: 150px; height: 150px; object-fit: cover;">

          </div>

          <!-- Profile Details Section -->
          <div class="col-md-8 px-md-4">
            <h5 class="mb-4">Personal Information</h5>

            <form id="profileForm">
              <div class="mb-3">
                <label class="form-label text-muted small fw-semibold">Full Name</label>
                <div type="text" class="form-control" id="fullNameInput" name="name" ></div>
              </div>

              <div class="mb-3">
                <label class="form-label text-muted small fw-semibold">Email Address</label>
                <div type="email" class="form-control" id="emailInput" name="email"> </div>
              </div>
            </form>

            <div class="border-bottom my-4" style="border-style: dashed !important; opacity: 0.2;"></div>
          </div>

        </div>
      </form>
    </div>
  </div>
</div>

</body>

</html>
<script>
  $(document).ready(function () {
    loadProfileData();

    function loadProfileData() {
        $.ajax({
            url: '../api/profile/get.php',
            type: 'GET',
            dataType: 'json',
            success: function (res) {
                if (res.status === 'success') {
                    //get name ,email as disble
                    $('#fullNameInput').text(res.data.name);
                    $('#emailInput').text(res.data.email);
                } else {
                    console.error('Error:', res.message);
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error:', error);
            }
        });
    }
});
</script>