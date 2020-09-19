<div class="panel">
    <div class="panel-heading">
        <ul class="breadcrumb">
            <li><a href="/Bookshop/Admin/category/">Category management</a></li>
            <li><a href="/Bookshop/Admin/category/?action=add">Add</a></li>
        </ul>
        <h3 style="text-align: center;">Adding a category</h3>
    </div>
    <div class="panel-body">
        <form class="form-horizontal" method='POST' action="/Bookshop/Admin/category/?action=do_add" onsubmit="return do_add();">
            <div id="add_error_message"></div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="name">Name:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter category name" value="<?php  ?>" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="description">Description:</label>
                <div class="col-sm-10">
                    <!-- <input type="text" id="description" class="form-control" name="description" placeholder="Enter category desciption" value="<?php  ?>" required> -->
                    <textarea id="description" class="form-control" name="description" placeholder="Enter category description" rows="5"></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <input class="btn btn-success" type="submit" name="add" value="add">
                    <input class="btn btn-danger" type="reset" name="reset" value="cancel">
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    function do_add() {
        var name = $("#name").val();
        var description = $("#description").val();
        var ajaxConfig = {
            type: "POST",
            url: "/Bookshop/Admin/category/?action=do_add",
            data: {
                name : name,
                description : description,
            },
            success: function(response) {
                if (response.trim() == "") {
                    $("#add_error_message").fadeIn(1000, function() {
                        $("#add_error_message").html("<div class='alert alert-success' style='width:100%; margin:auto;'>Add successfully</div>");
                    })
                } else {
                    $("#add_error_message").fadeIn(1000, function() {
                        $("#add_error_message").html("<div class='alert alert-danger' style='width:100%; margin:auto;'>" + response + "</div>");
                        $("#btn_add").html("try again");
                    })
                }
            }
        }
        $.ajax(ajaxConfig);
        return false;
    }
</script>