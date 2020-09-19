<div class="panel">
    <div class="panel-heading">
        <ul class="breadcrumb">
            <li><a href="/Bookshop/Admin/news/">News management</a></li>
            <li><a href="/Bookshop/Admin/news/?action=add">Add</a></li>
        </ul>
        <h3 style="text-align: center;">Adding a news</h3>
    </div>
    <div class="panel-body">
        <form class="form-horizontal" method='POST' action="/Bookshop/Admin/news/?action=do_add" onsubmit="return do_add(this);" enctype='multipart/form-data'>
            <div id="add_error_message"></div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="name">Title:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="name" placeholder="Enter news title" value="<?php  ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="content">Content:</label>
                <div class="col-sm-10">
                    <textarea id="content" class="form-control" name="content" rows="5" placeholder="Enter content" required></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="image">Image:</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="image_selected" name="image" placeholder="Select image">
                </div>
                <div class="col-sm-4">
                    <img id="image_tag" width="200px;" height="300px;" class="img-response">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <input class="btn btn-success" type="submit" name="add" value="Add">
                    <input class="btn btn-danger" type="reset" name="reset" value="cancel">
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    CKEDITOR.replace("content");
</script>
<script>
    $(document).ready(function() {
        $("#image_selected").keyup(function() {
            $('#image_tag').attr('src', $("#image_selected").val());
        });
    });

    function do_add(formData) {
        var form_data = new FormData(formData);
        var content = CKEDITOR.instances.content.getData();
        form_data.append("content", content);
        var ajaxConfig = {
            type: "POST",
            url: "/Bookshop/Admin/news/?action=do_add",
            data: form_data,
            success: function(response) {
                if (response.trim() == "") {
                    $("#add_error_message").fadeIn(1000, function() {
                        $("#add_error_message").html("<div class='alert alert-success' style='width:100%; margin:auto;'>Add successfully</div>");
                        $("#add_error_message").fadeOut(3000);
                    })
                } else {
                    $("#add_error_message").fadeIn(1000, function() {
                        $("#add_error_message").html("<div class='alert alert-danger' style='width:100%; margin:auto;'>" + response + "</div>");
                        $("#btn_add").html("try again");
                    })
                }
            }
        }
        if ($(formData).attr('enctype') == "multipart/form-data") {
            ajaxConfig["contentType"] = false;
            ajaxConfig["processData"] = false;
        }
        $.ajax(ajaxConfig);
        return false;
    }
</script>