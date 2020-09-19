<?php $coupon = $this->data["coupon"]; ?>
<div class="panel">
    <div class="panel-heading">
        <ul class="breadcrumb">
            <li><a href="/Bookshop/Admin/coupon/">Coupon management</a></li>
            <li><a href="/Bookshop/Admin/coupon/?action=update&id=<?php echo $coupon->coupon_id;?>"><?php echo $coupon->content*100 ."%" ;?></a></li>
        </ul>
        <h3 style="text-align: center;">Updating a coupon</h3>
    </div>
    <div class="panel-body">
        <form class="form-horizontal" method='POST' action="/Bookshop/Admin/coupon/?action=do_update" onsubmit="return do_update();">
            <div id="update_error_message"></div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="coupon_id">ID:</label>
                <div class="col-sm-10">
                    <input type="hidden" id="coupon_id" name="coupon_id" value="<?php echo $coupon->coupon_id; ?>">
                    <input type="number" class="form-control" placeholder="Enter coupon id" value="<?php echo $coupon->coupon_id; ?>" disabled>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="content">Sale off %:</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" id="content" name="content" min="0" max="100" placeholder="Enter coupon %" value="<?php echo $coupon->content * 100; ?>" required>
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
        var coupon_id = $("#coupon_id").val();
        var value = $("#content").val();
        var content = value / 100;
        var status = $("#status").val();
        var ajaxConfig = {
            type: "POST",
            url: "/Bookshop/Admin/coupon/?action=do_update",
            data: {
                coupon_id :coupon_id,
                content: content,
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