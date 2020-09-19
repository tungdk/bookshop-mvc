<?php $author = $this->data["author"]; ?>
<div class="panel">
    <div class="panel-heading">
        <ul class="breadcrumb">
            <li><a href="/Bookshop/Admin/author/index/">Author management</a></li>
            <li><a href="/Bookshop/Admin/author/?action=update&id=<?php echo $author->author_id;?>"><?php echo $author->name; ?></a></li>
        </ul>
        <h3 style="text-align: center;">Updating an author</h3>
    </div>
    <div class="panel-body">
        <form class="form-horizontal" method='POST' action="/Bookshop/Admin/author/?action=do_update" onsubmit="return do_update();">
            <div id="update_error_message"></div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="author_id">ID:</label>
                <div class="col-sm-10">
                    <input type="hidden" id="author_id" value="<?php echo $author->author_id; ?>">
                    <input type="number" class="form-control" name="author_id" placeholder="Enter author id" value="<?php echo $author->author_id; ?>" disabled>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="name">Name:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter author name" value="<?php echo $author->name; ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="address">Address:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="address" name="address" placeholder="Enter author address" value="<?php echo $author->address; ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="desciption">Description:</label>
                <div class="col-sm-10">
                    <textarea class="form-control" name="description" id="description" rows="5"><?php echo $author->description; ?></textarea>
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
        var author_id = $("#author_id").val();
        var name = $("#name").val();
        var address = $("#address").val();
        var description = $("#description").val();
        var status = $("#status").val();
        var ajaxConfig = {
            type: "POST",
            url: "/Bookshop/Admin/author/?action=do_update",
            data: {
                author_id: author_id,
                name: name,
                address: address,
                description: description,
                status: status,
            },
            success: function(response) {
                if (response.trim() == "") {
                    $("#update_error_message").fadeIn(1000, function() {
                        $("#update_error_message").html("<div class='alert alert-success' style='width:100%; margin:auto;'>update successfully</div>");
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