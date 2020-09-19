<!-- <div class="container"> -->
<div class="panel">
    <div class="panel-heading">
        <ul class="breadcrumb">
            <li><a href="/Bookshop/Home/index/">Home</a></li>
            <li><a href="/Bookshop/Account/login/">Login</a></li>
        </ul>
    </div>
    <div class="panel-body">
        <div class="modal-header">
            <h3 class="modal-title" style="text-align:center;">Login Screen</h3>
        </div>
        <div class="modal-body">
            <div style="width: 70%; margin:auto;">
                <form id="login_form" class="form-horizontal" enctype='multipart/form-data' method="POST" action="/Bookshop/Account/do_login/" onsubmit="return do_login();">
                    <div id="login_error_message"></div>
                    <div class="form-group">
                        <label for="login_username" class="control-label col-sm-3 ">Username: </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="login_username" name="username" value="" placeholder="Enter username" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="login_password" class="control-label col-sm-3">Password: </label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" id="login_password" name="password" value="" placeholder="Enter password" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-10">
                            <button type="submit" id="btn_login" name="btn_login" class="btn btn-primary">Login</button>
                        </div>
                        <div style="float: right;">
                            <a href="/Bookshop/Account/register/">Sign up for new account?</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function do_login() {
        var username = $("#login_username").val();
        var password = $("#login_password").val();
        if (username != "" && password != "") {
            $.ajax({
                type: "POST",
                url: "/Bookshop/Account/do_login/",
                data: {
                    username : username,
                    password : password,
                },
                beforeSend: function() {
                    $("#login_error_message").fadeOut();
                    $("#btn_login").html("Waiting.....");
                },
                success: function(response) {
                    if ((response.trim()) == "") {
                        $("#login_error_message").fadeIn(1000, function() {
                            $("#login_error_message").html("<div class='alert alert-success' style='width:100%; margin:auto;'>Login successfully</div>");
                            setTimeout('window.location.href="/Bookshop/"', 2000);
                        })
                    } else {
                        $("#login_error_message").fadeIn(1000, function() {
                            $("#login_error_message").html("<div class='alert alert-danger' style='width:100%; margin:auto;'>" + response + "</div>");
                            $("#btn_login").html("Try again");
                        });
                    }
                }
            });
        } else {
            $("#login_error_message").fadeIn(1000, function() {
                $("#login_error_message").html("<div class='alert alert-danger' style='width:100%; margin:auto;'>You must enter both email and password. </div>");
            })
        }
        return false;
    }
</script>