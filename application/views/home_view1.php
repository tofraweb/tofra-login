<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>Simple Login with CodeIgniter - Private Area</title>
      <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.css">
      <script src="<?php echo base_url();?>assets/js/jquery-3.2.1.min.js"></script>
      <script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
  </head>
  <body>
    <h1>Home</h1>
    <h2>Welcome <?php echo $username; ?>!</h2>
    <a href="home/logout">Logout</a>
  </body>
</html>
