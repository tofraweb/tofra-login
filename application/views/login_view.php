<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Welcome to CodeIgniter</title>
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.css">
    <script src="<?php echo base_url();?>assets/js/jquery-3.2.1.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>

    <style type="text/css">

        ::selection { background-color: #E13300; color: white; }
        ::-moz-selection { background-color: #E13300; color: white; }

        body {
            background-color: #fff;
            font: 13px/20px normal Helvetica, Arial, sans-serif;
            color: #4F5155;
            text-align: center;
        }

        a {
            color: #003399;
            background-color: transparent;
            font-weight: normal;
        }

        h1 {
            color: #444;
            background-color: transparent;
            border-bottom: 1px solid #D0D0D0;
            font-size: 19px;
            font-weight: normal;
            margin: 0 0 14px 0;
            padding: 14px 15px 10px 15px;
        }

        code {
            font-family: Consolas, Monaco, Courier New, Courier, monospace;
            font-size: 12px;
            background-color: #f9f9f9;
            border: 1px solid #D0D0D0;
            color: #002166;
            display: block;
            margin: 14px 0 14px 0;
            padding: 12px 10px 12px 10px;
        }

        #body {
            margin: 0 15px 0 15px;
        }

        p.footer {
            text-align: right;
            font-size: 11px;
            border-top: 1px solid #D0D0D0;
            line-height: 32px;
            padding: 0 10px 0 10px;
            margin: 20px 0 0 0;
        }

        #container {
            margin: 0 auto;
            border: 1px solid #D0D0D0;
            box-shadow: 0 0 8px #D0D0D0;
            width: 600px;
            text-align: left;
        }
    </style>
</head>
<body>

<div id="container">
    <h1>Please login</h1>

    <div id="body">
        <code>
            <?php
            if($this->session->flashdata('errors')){
                echo "<span style='color:red'>".$this->session->flashdata('errors')."</span>";
            }
            $form_attributes = array(
                'class' => 'form-horizontal',
                'method' => "post"
            );
            $username_input_attributes = array(
                'class' => 'form-control',
                'name' => 'username',
                'placeholder' => 'Enter your username',
                'type' => 'text'
            );
            $password_input_attributes = array(
                'class' => 'form-control',
                'name' => 'password',
                'placeholder' => 'Enter your password',
                'type' => 'password'
            );
            $button_attributes = array(
                'class' => 'btn btn-success',
                'name' => 'send_form',
                'type' => 'submit',
                'value' => 'Submit'
            );
            echo form_open('login/verifylogin', $form_attributes);
            echo form_label('Username:');
            echo form_input($username_input_attributes);
            echo form_label('Password:');
            echo form_input($password_input_attributes);
            echo form_input($button_attributes);
            echo form_close();
            ?>
        </code>
    </div>

    <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
</div>

</body>
</html>