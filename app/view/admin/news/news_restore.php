<div class="panel">
    <div class="panel-heading">
        <ul class="breadcrumb">
            <li><a href="/Bookshop/Admin/news/">News management</a></li>
            <li><a href="/Bookshop/Admin/news/?action=restore">Restore</a></li>
        </ul>
        <h3 style="text-align: center;">Trash can</h3>
    </div>
    <div>
        <form method="POST" action="">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th>News ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Date</th>
                        <th colspan="3" style="text-align: center;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($this->data["news"] as $news) {
                    ?>
                        <tr>
                            <td>
                                <?php echo $news->news_id; ?>
                            </td>
                            <td>
                                <img style="width: 70px; height : 70px;margin-left: auto;margin-right: auto;" src="<?php echo $news->image; ?>">
                            </td>
                            <td>
                                <?php echo $news->name; ?>
                            </td>
                            <td>
                                <?php
                                $date = date_create($news->date);
                                echo date_format($date, "d-m-yy");
                                ?>
                            </td>
                            <td>
                                <button name="restore" class="btn btn-success" onclick="return do_restore(<?php echo $news->news_id; ?>);" value='Restore'><span class="glyphicon glyphicon-ok"></span> Restore</button>
                            </td>
                            <td>
                                <a href="/Bookshop/Admin/news/?action=update&id=<?php echo $news->news_id; ?>" name="details" class="btn btn-primary" value='Details'><span class="glyphicon glyphicon-edit"></span> Details</a>
                            </td>
                            <td>
                                <button name="restore" class="btn btn-danger" onclick="return do_delete(<?php echo $news->news_id; ?>);" value='Delete'><span class="glyphicon glyphicon-remove"></span> Delete</button>
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
                            echo '<li><a href="/Bookshop/Admin/news/?action=restore&page=' . $k . '">' . $k . '</li>';
                        } else {
                            echo '<li class="active"><a href="/Bookshop/Admin/news/?action=restore&page=' . $k . '">' . $k . '</li>';
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
    function do_restore(id) {
        if (confirm("Are you sure want to restore this news ?") == true) {
            var ajaxConfig = {
                type: "POST",
                url: "/Bookshop/Admin/news/?action=do_restore",
                data: {
                    news_id: id,
                },
                success: function(response) {
                    if (response.trim() == "") {
                        alert("Restored.");
                        document.location.reload(true);
                    } else {
                        alert(response);
                    }
                }
            }
            $.ajax(ajaxConfig);
        }
        return false;
    }

    function do_delete(id) {
        if (confirm("Are you sure want to delete this news for good ?") == true) {
            var ajaxConfig = {
                type: "POST",
                url: "/Bookshop/Admin/news/?action=do_delete",
                data: {
                    news_id: id,
                },
                success: function(response) {
                    if (response.trim() == "") {
                        alert("Deleted.");
                        document.location.reload(true);
                    } else {
                        alert(response);
                    }
                }
            }
            $.ajax(ajaxConfig);
        }
        return false;
    }
</script>