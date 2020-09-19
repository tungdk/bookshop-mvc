<div class="panel">
    <div class="panel-heading">
        <h3 style="text-align: center;">Author management</h3>
    </div>
    <div class="panel-body">
        <nav class="navbar">
            <div class="container-fluid">
                <form method="GET" class="form-horizontal navbar-form navbar-left" enctype="multipart/form-data" action="/Bookshop/Admin/author/">
                    <div class="form-group ">
                        <input type="text" class="form-control" name="search_name" placeholder="Search name" value="<?php if (isset($_GET["search_name"])) echo $_GET["search_name"]; ?>">
                        <button type="submit" name="search" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span></button>
                        <a class="btn-default btn" href="/Bookshop/Admin/author/"><span class="glyphicon glyphicon-refresh"></span></a>
                    </div>
                </form>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="/Bookshop/Admin/author/?action=add"><span class="glyphicon glyphicon-plus"></span> Add</a></li>
                    <li><a href="/Bookshop/Admin/author/?action=restore"><span class="glyphicon glyphicon-repeat"></span> Restore</a></li>
                </ul>
            </div>
        </nav>
        <form method="POST" action="">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th>
                            <button type="submit" class="btn btn-danger" onclick="on_mass_remove();" value='Mass Delete' name='mass_delete'><span class="glyphicon glyphicon-trash"></span></button>
                        </th>
                        <th>Author id</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th colspan="2" style="text-align: center;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($this->data["authors"] as $author) {
                    ?>
                        <tr>
                            <td align="center">
                                <input type="checkbox" name="mass_remove_list[]" value=<?php echo $author->author_id; ?>>
                            </td>
                            <td>
                                <?php echo $author->author_id; ?>
                            </td>
                            <td>
                                <?php echo $author->name; ?>
                            </td>
                            <td>
                                <textarea class="form_control" rows="5" cols="50"> <?php echo $author->description; ?> </textarea>
                            </td>
                            <td>
                                <a class="btn btn-info" href="/Bookshop/Admin/author/?action=update&id=<?php echo $author->author_id; ?>"><span class="glyphicon glyphicon-edit"></span> Update</a>
                            </td>
                            <td>
                                <button type="submit" name="delete" class="btn btn-danger" onclick="on_remove(<?php echo $author->author_id; ?>);" value='Delete'><span class="glyphicon glyphicon-remove"></span> Remove</button>
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
                            echo '<li><a href="/Bookshop/Admin/author/?page=' . $k . '">' . $k . '</li>';
                        } else {
                            echo '<li class="active"><a href="/Bookshop/Admin/author/?page=' . $k . '">' . $k . '</li>';
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
        var strurl = "/Bookshop/Admin/author/?action=do_remove";
        var author_id = id;
        if (confirm("Are you sure want to delete this author ?") == true) {
            jQuery.ajax({
                url: strurl,
                type: 'POST',
                data: {
                    author_id: id,
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

    function on_mass_remove() {
        try {
            var list = $("input[name='mass_remove_list[]']:checked").map(function(){return $(this).val();}).get();
            // alert(list);
            if (confirm("Are you sure want to delete all selected authors ?") == true) {
                var ajaxConfig = {
                    type: "POST",
                    url: "/Bookshop/Admin/author/?action=do_mass_remove",
                    data: {
                        mass_remove_list : list,
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