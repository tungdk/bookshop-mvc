<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Management</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.js"></script>
  <script src="https://cdn.ckeditor.com/4.14.1/full/ckeditor.js"></script>
</head>

<body>
  <nav class="navbar-default" style="margin: 0;">
    <div class="container-fluid" style="padding: 0;">
      <div class="col-md-2">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/Bookshop/Admin/index/">System</a>
        </div>
      </div>
      <div class="col-md-10">
        <ul class="nav navbar-nav navbar-right">
          <li><a href="/Bookshop/Admin/order/" class="notification">
              <span>Undone orders</span>
              <span class="badge"><?php echo $this->data["count_all_undone_orders"]; ?></span>
            </a>
          </li>
          <li><a href="/Bookshop/"><span class="glyphicon glyphicon-globe"></span>Website</a></li>
          <!-- <li><a href="#"><span class="glyphicon glyphicon-user"></span>Admin</a></li> -->
          <!-- <li><a href="#" data-toggle="dropdown" data-placement="bottom" title="Administrator" data-target="#admin"><span class="glyphicon glyphicon-user"></span> Admin</a></li> -->
          <li class="dropdown">
            <a class="btn btn-default" type="button" data-toggle="dropdown"> <span class="glyphicon glyphicon-user"></span> Admin
              <span class="caret"></span>
            </a>
            <div class="dropdown-menu">
              <img width="300px;" src="https://cv.com.vn/blog/wp-content/uploads/2019/12/Administrator-l%C3%A0-g%C3%AC.png">
              <h3 style="text-align : center" ><?php echo $_SESSION["admin"]["name"]; ?></h3>
              <a class="btn btn-info" style="float: left;" href="/Bookshop/Admin/administrator/">Details</a>
              <a class="btn btn-danger" style="float: right;" href="/Bookshop/Admin/administrator/?action=do_logout">Exit</a>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </nav>