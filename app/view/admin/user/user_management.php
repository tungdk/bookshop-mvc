<div class="panel">
    <div class="panel-heading">
        <h3 style="text-align: center;">User management</h3>
    </div>
    <div class="panel-body">
        <nav class="navbar">
            <div class="container-fluid">
                <form method="GET" class="form-horizontal navbar-form navbar-left" enctype="multipart/form-data" action="/Bookshop/Admin/user/">
                    <div class="form-group ">
                        <input type="text" class="form-control" name="search_name" placeholder="Search name" value="<?php if (isset($_GET["search_name"])) echo $_GET["search_name"]; ?>">
                        <button type="submit" name="search" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span></button>
                        <a class="btn-default btn" href="/Bookshop/Admin/user/"><span class="glyphicon glyphicon-refresh"></span></a>
                    </div>
                </form>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="/Bookshop/Admin/user/?action=restore"><span class="glyphicon glyphicon-repeat"></span> Restore</a></li>
                </ul>
            </div>
        </nav>
        <form method="POST">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th>
                            <button type="submit" onclick="on_mass_remove();" class="btn btn-danger" value='Mass Delete' name='mass_delete'><span class="glyphicon glyphicon-trash"></span></button>
                        </th>
                        <th>User id</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Authority</th>
                        <th>Number</th>
                        <th colspan="3" style="text-align: center;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($this->data["users"] as $user) {
                    ?>
                        <tr>
                            <td align="center">
                                <input type="checkbox" name="mass_remove_list[]" value=<?php echo $user->user_id; ?>>
                            </td>
                            <td>
                                <?php echo $user->user_id; ?>
                            </td>
                            <td>
                                <?php echo $user->name; ?>
                            </td>
                            <td>
                                <?php echo $user->username; ?>
                            </td>
                            <td>
                                <?php
                                if ($user->authority == 0)
                                    echo "Member";
                                else if ($user->authority == 1)
                                    echo  "Administrator";
                                ?>
                            </td>
                            <td>
                                <?php echo $user->number; ?>
                            </td>
                            <td>
                                <?php
                                if ($user->authority == 0)
                                    echo  '<button class="btn btn-success" onclick="on_promote(' . $user->user_id . ')"> <span class="glyphicon glyphicon-arrow-up"></span> Promote </button>';
                                else if ($user->authority == 1)
                                    echo  '<button class="btn btn-danger" onclick="on_demote(' . $user->user_id . ')"> <span class="glyphicon glyphicon-arrow-down"></span> Demote </button>';
                                ?>
                            </td>
                            <td>
                                <a class="btn btn-info" href="/Bookshop/Admin/user/?action=update&id=<?php echo $user->user_id; ?>"><span class="glyphicon glyphicon-edit"></span> Details</a>
                            </td>
                            <td>
                                <button name="delete" class="btn btn-danger" onclick="on_remove(<?php echo $user->user_id; ?>);" value='Delete'><span class="glyphicon glyphicon-remove"></span> Remove</button>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </form>
        <div class="container-fluid">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <ul class="pagination">
                    <?php
                    for ($k = 1; $k <= $this->data["number_of_page"]; $k++) {
                        if ($k != $this->data["page"]) {
                            echo '<li><a href="/Bookshop/Admin/user/?page=' . $k . '">' . $k . '</li>';
                        } else {
                            echo '<li class="active"><a href="/Bookshop/Admin/user/?page=' . $k . '">' . $k . '</li>';
                        }
                    }
                    ?>
                </ul>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
</div>
<script>
    function on_remove(id) {
        var strurl = "/Bookshop/Admin/user/?action=do_remove";
        var user_id = id;
        if (confirm("Are you sure want to delete this user ?") == true) {
            jQuery.ajax({
                url: strurl,
                type: 'POST',
                data: {
                    user_id: id,
                },
                success: function(response) {
                    if (response.trim() == "") {
                        alert("Removed successfully.");
                        document.location.reload(true);

                    } else {
                        alert(response);
                    }
                }
            });
        }

        return false;
    }

    function on_promote(id) {
        var strurl = "/Bookshop/Admin/user/?action=do_grant_rights";
        var user_id = id;
        if (confirm("Are you sure want to promote this user ?") == true) {
            jQuery.ajax({
                url: strurl,
                type: 'POST',
                data: {
                    user_id: id,
                    authority: 1,
                },
                success: function(response) {
                    if (response.trim() == "") {
                        alert("Promoted successfully.");
                        document.location.reload(true);

                    } else {
                        alert(response);
                    }
                }
            });
        }

        return false;
    }

    function on_demote(id) {
        var strurl = "/Bookshop/Admin/user/?action=do_grant_rights";
        var user_id = id;
        if (confirm("Are you sure want to demote this user ?") == true) {
            jQuery.ajax({
                url: strurl,
                type: 'POST',
                data: {
                    user_id: id,
                    authority: 0,
                },
                success: function(response) {
                    if (response.trim() == "") {
                        alert("Demoted successfully.");
                        document.location.reload(true);

                    } else {
                        alert(response);
                    }
                }
            });
        }

        return false;
    }

    function on_mass_remove() {
        try {
            var list = $("input[name='mass_remove_list[]']:checked").map(function() {
                return $(this).val();
            }).get();
            // alert(list);
            if (confirm("Are you sure want to delete all selected users ?") == true) {
                var ajaxConfig = {
                    type: "POST",
                    url: "/Bookshop/Admin/user/?action=do_mass_remove",
                    data: {
                        mass_remove_list: list,
                    },
                    success: function(response) {
                        if (response.trim() == "") {
                            alert("Mass removed.");
                            document.location.reload(true);
                        } else {
                            alert(response);
                        }
                    }
                }
                $.ajax(ajaxConfig);
            }
        } catch (err) {
            alert(err.message);
        }
        return false;

    }
</script>