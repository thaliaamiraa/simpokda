<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8" />
        <title>SIMPOKDA</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="<?=base_url()?>assets/images/simpokda1.png">
        <!-- App css -->
        <link href="<?=base_url()?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url()?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url()?>assets/css/app.min.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <div id="preloader">
            <div id="status">
                <div class="bouncingLoader"><div ></div><div ></div><div ></div></div>
            </div>
        </div>
        <div class="account-pages mt-5 mb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card">
                            <div class="card-body p-4">
                                <div class="text-center m-auto">
                                <div class="brand-logo">
                                <center>
                                <img src="<?= base_url() ?>assets/images/simpokda.png" width="150" heigth="150" >
                                </center>
                                </div>
                                    <h3>Sistem Pengelompokan Kerawanan Desa <br> Kabupaten Bojonegoro</h3>
                                    <p class="text-muted mb-4 mt-3">Login menggunakan username & password</p>
                                </div>
                                <?php echo form_open('C_login/login'); ?>
                                    <div class="form-group mb-3">
                                        <label for="emailaddress">Username</label>
                                        <input class="form-control" type="text" name="user_name" autocomplete="off" required="" placeholder="Masukan Username">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="password">Password</label>
                                        <input class="form-control" type="password" required="" autocomplete="off" name="user_password" placeholder="Masukan Password">
                                    </div>
                                    <div class="form-group mb-0 text-center">
                                        <button class="btn btn-dark btn-block" type="submit"> Log In </button>
                                    </div>
                                <?=form_close()?>
                            </div> <!-- end card-body -->
                        </div>
                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->
        <footer class="footer footer-alt">
        </footer>
        <!-- Vendor js -->
        <script src="<?=base_url()?>assets/js/vendor.min.js"></script>
        <!-- App js -->
        <script src="<?=base_url()?>assets/js/app.min.js"></script>
    </body>
</html>
