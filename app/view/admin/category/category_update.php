<?php $category = $this->data["category"]; ?>
<div class="panel">
    <div class="panel-heading">
        <ul class="breadcrumb">
            <li><a href="/Bookshop/Admin/category/">Category management</a></li>
            <li><a href="/Bookshop/Admin/category/?action=update&id=<?php echo $category->category_id;?>"><?php echo $category->name;?></a></li>
        </ul>
        <h3 style="text-align: center;">Updating a category</h3>
    </div>
    <div class="panel-body">
        <form class="form-horizontal" method='POST' action="/Bookshop/Admin/category/?action=do_update" onsubmit="return do_update();">
            <div id="update_error_message"></div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="category_id">ID:</label>
                <div class="col-sm-10">
                    <input type="hidden" id="category_id" name="category_id" value="<?php echo $category->category_id; ?>">
                    <input type="number" class="form-control" placeholder="Enter category id" value="<?php echo $category->category_id; ?>" disabled>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="name">Name:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter category name" value="<?php echo $category->name; ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="description">Description:</label>
                <div class="col-sm-10">
                    <textarea id="description" class="form-control" name="description" placeholder="Enter category description" rows="5"><?php echo $category->description ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <input class="btn btn-success" type="submit" name="submit" value="update">
                    <input class="btn btn-danger" type="reset" name="reset" value="cancel">
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    function do_update() {
        var category_id = $("#category_id").val();
        var name = $("#name").val();
        var description = $("#description").val();
        var status = $("#status").val();
        var ajaxConfig = {
            type: "POST",
            url: "/Bookshop/Admin/category/?action=do_update",
            data: {
                category_id :category_id,
                name: name,
                description: description,
                status: status,
            },
            success: function(response) {
                if (response.trim() == "") {
                    $("#update_error_message").fadeIn(1000, function() {
                        $("#update_error_message").html("<div class='alert alert-success' style='width:100%; margin:auto;'>update successfully</div>");
                        $("#update_error_message").fadeOut(3000);
                    })
                } else {
                    $("#update_error_message").fadeIn(1000, function() {
                        $("#update_error_message").html("<div class='alert alert-danger' style='width:100%; margin:auto;'>" + response + "</div>");
                        $("#btn_update").html("try again");
                    })
                }
            }
        }
        $.ajax(ajaxConfig);
        return false;
    }
</script>