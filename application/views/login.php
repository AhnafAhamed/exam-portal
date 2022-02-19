<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>ScienceClassLk | Online Portal</title>

  <!-- Custom fonts for this template-->
  <link href="<?php echo base_url(); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Favicon --->
  <link rel="icon" href="<?php echo base_url('images/sci-logo.png'); ?>" type="image/gif" sizes="16x16">

  <!-- Custom styles for this template-->
  <link href="<?php echo base_url(); ?>css/sb-admin-2.min.css" rel="stylesheet">

</head>

<style>
  .logo {
    width: 100px;

  }

  body {
    background: #0c179a !important;
  }

  .btn {
    background-color: #ffe136;
    border: none;
    font-weight: bolder;
    font-size: 20px !important;
  }

  .btn:hover {
    background: #0c179a !important;
  }
</style>

<body class="bg-gradient-primary">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center main">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-2 ">
            <!-- Nested Row within Card Body -->
            <div class="row">

              <div class="col-lg-6 mx-auto">
                <div class="p-5">
                  <div class="text-center">
                    <?php
                    $hquery = $this->db->query(" select * from savsoftquiz_setting where setting_name='App_Name' || setting_name='App_title' order by setting_id asc ");
                    $hres = $hquery->result_Array();
                    ?>

                    <img src="<?php echo base_url('images/sci-logo.png'); ?>" class="logo" alt="ScienceClassLK Logo">
                    <h1 class="h4 text-gray-900 mb-4 mt-3">

                      <b>ScienceClassLK - Online Portal</b>

                    </h1>
                  </div>
                  <form class="user" method="post" action="<?php echo site_url('login/verifylogin'); ?>">

                    <?php
                    if ($this->session->flashdata('message')) {
                    ?>
                      <div class="alert alert-danger">
                        <?php echo str_replace('{resend_url}', site_url('login/resend'), $this->session->flashdata('message')); ?>
                      </div>
                    <?php
                    }
                    ?>



                    <div class="form-group">
                      <input type="email" name="email" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Username">
                    </div>
                    <div class="form-group">
                      <input type="password" name="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="<?php echo $this->lang->line('password'); ?>">
                    </div>
                    <div class="form-group">

                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block">
                      Login
                    </button>

                  </form>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="<?php echo base_url(); ?>vendor/jquery/jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?php echo base_url(); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?php echo base_url(); ?>js/sb-admin-2.min.js"></script>

</body>

</html>