<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  

  <title><?php echo $title; ?></title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="/arcmeridians/include/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/arcmeridians/include/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- Jquery -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="https://apis.google.com/js/platform.js" async defer></script>
  <!-- Bootstrap -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style type="text/css">
   #card-ani {
    transition: 0.3s;
    border-radius: 5px;
    }

   #card-ani:hover {
    box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
    }
   .imgbox{
      max-height:100px;
      max-width: 100px; 
    }
   .image-checkbox {
        cursor: pointer;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        -webkit-box-sizing: border-box;
        border: 4px solid transparent;
        margin-bottom: 0;
        outline: 0;
    }
    .image-checkbox input[type="checkbox"] {
        display: none;
    }
    .image-checkbox-checked {
        border-color: #4783B0;
    }
    .image-checkbox .glyphicon {
      position:absolute;
      color: #4A79A3;
      background-color: #fff;
      padding: 10px;
      top: 0;
      right: 0;
    }
    .image-checkbox-checked .glyphicon {
      display: block !important;
    }
    .custom-active{
      background-color: #f0575a;
    }
    .custom-footer{
      color: #869099;
      position:auto;
      bottom: 0;
      padding: 10px 10px 0px 10px;
      width: 100%;
      height: 40px;
      text-align: center;
    }
  </style>
</head>
<body class="hold-transition sidebar-mini">
