<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Chi tiết RM</title>

  <?php include('include-css.php'); ?>
</head>

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <?php include('include-header.php'); ?>

      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>User Details</h1>
          </div>

          <div class="section-body">
            <div class="row">
              <div class="col-md-12">
                <div class="card profile-widget">
                  <div class="profile-widget-header">
                      <div class="user-avtar rounded-circle"><?= mb_substr($user_detail->full_name, 0, 1); ?></div>
                    
                  </div>
                  <div class="profile-widget-description pb-0">
                    <div class="col-md-8 d-flex justify-content-between p-5">
                      <!-- User Details -->
                      <table class="profile-table w-75">
                        <tr>
                          <td class="font-weight-600">RM Code:</td>
                          <td class="text-muted d-inline font-weight-normal"><?= $user_detail->rm_code ?></td>
                        </tr>
                        <tr>
                          <td class="font-weight-600">HRIS Code:</td>
                          <td class="text-muted d-inline font-weight-normal"><?= $user_detail->hris_code ?></td>
                        </tr>
                        <tr>
                          <td class="font-weight-600">Full Name:</td>
                          <td class="text-muted d-inline font-weight-normal"><?= $user_detail->full_name ?></td>
                        </tr>
                        <tr>
                          <td class="font-weight-600">Phone:</td>
                          <td class="text-muted d-inline font-weight-normal"><?= $user_detail->phone ?></td>
                        </tr>
                        <tr>
                          <td class="font-weight-600">Email:</td>
                          <td class="text-muted d-inline font-weight-normal"><?= $user_detail->email ?></td>
                        </tr>
                        <tr>
                          <td class="font-weight-600">Position:</td>
                          <td class="text-muted d-inline font-weight-normal"><?= $user_detail->position ?></td>
                        </tr>
                        <tr>
                          <td class="font-weight-600">Branch Level 2 Code:</td>
                          <td class="text-muted d-inline font-weight-normal"><?= $user_detail->branch_lv2_code ?></td>
                        </tr>
                        <tr>
                          <td class="font-weight-600">Branch Level 2 Name:</td>
                          <td class="text-muted d-inline font-weight-normal"><?= $user_detail->branch_lv2_name ?></td>
                        </tr>
                        <tr>
                          <td class="font-weight-600">Branch Level 1 Code:</td>
                          <td class="text-muted d-inline font-weight-normal"><?= $user_detail->branch_lv1_code ?></td>
                        </tr>
                        <tr>
                          <td class="font-weight-600">Branch Level 1 Name:</td>
                          <td class="text-muted d-inline font-weight-normal"><?= $user_detail->branch_lv1_name ?></td>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </section>
      </div>
      <?php include('include-footer.php'); ?>
    </div>
  </div>

  <?php include('include-js.php'); ?>

</body>

</html>
