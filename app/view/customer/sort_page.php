<div class="panel">
    <div class="panel-heading">
        <ul class="breadcrumb">
            <li><a href="/Bookshop/Home/index/">Home</a></li>
            <li><a href="">Filter</a></li>
            <li><a href="/Bookshop/Filter/<?php echo $this->data["sort"] ?>"><?php echo $this->data["sort_type"]; ?></a></li>
        </ul>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h4 style="text-align: center;"> Sort : <?php echo $this->data["sort_type"]; ?></h4>
                </div>
                <div class="panel-footer">
                    <a <?php if ($this->data["sort"] == "none") echo 'class="btn btn-info"'; else echo 'class="btn btn-default"'; ?> href="/Bookshop/Filter/sort/?sort=none">None</a>
                    <a <?php if ($this->data["sort"] == "name") echo 'class="btn btn-info"'; else echo 'class="btn btn-default"'; ?> href="/Bookshop/Filter/sort/?sort=name">Name</a>
                    <a <?php if ($this->data["sort"] == "sale") echo 'class="btn btn-info"'; else echo 'class="btn btn-default"'; ?> href="/Bookshop/Filter/sort/?sort=sale">Sale</a>
                    <a <?php if ($this->data["sort"] == "sell") echo 'class="btn btn-info"'; else echo 'class="btn btn-default"'; ?> href="/Bookshop/Filter/sort/?sort=sell">Sell</a>
                    <a <?php if ($this->data["sort"] == "rate") echo 'class="btn btn-info"'; else echo 'class="btn btn-default"'; ?> href="/Bookshop/Filter/sort/?sort=rate">Rate</a>
                    <a <?php if ($this->data["sort"] == "date") echo 'class="btn btn-info"'; else echo 'class="btn btn-default"'; ?> href="/Bookshop/Filter/sort/?sort=date">Date</a>
                </div>
            </div>
            <div class="col-md-12">
                <?php
                if (count($this->data["books"]) > 0) {
                ?>
                    <div class="row">
                        <?php
                        foreach ($this->data["books"] as $books) {
                            if ($books->book_id == null) {
                                continue;
                            }
                        ?>
                            <div class="col-md-3">
                                <div class="product-grid">
                                    <div class="product-image">
                                        <a href="#">
                                            <?php if ($books->image != "") { ?>
                                                <img class="pic-1" src="<?php echo $books->image; ?>">
                                            <?php  } else { ?>
                                                <img class="pic-1" src="/Bookshop/public/uploads/book_image/no_image.jpg">

                                            <?php
                                            } ?>
                                        </a>
                                        <ul class="social">
                                            <li><a href="/Bookshop/Details/index/?book_id=<?php echo $books->book_id; ?>/" data-tip="Quick View"><span class="glyphicon glyphicon-search"></span></a></li>
                                            <li><a href="" onclick="onAddCart(<?php echo $books->book_id; ?>);" id="<?php if (isset($_SESSION["user_id"])) echo $books->book_id; ?>" onclick="onAddCart(<?php echo $books->book_id; ?>)" data-tip="Add to Cart"><span class="glyphicon glyphicon-shopping-cart"></span></a></li>
                                        </ul>
                                    </div>
                                    <div class="product-content">
                                        <h3 class="title"><a href="/Bookshop/Details/index/?book_id=<?php echo $books->book_id; ?>/"><?php echo $books->name ?></a></h3>
                                        <h3 class="title">
                                            <?php foreach ($this->data["authors"] as $authors) {
                                                if ($authors->author_id == $books->author_id) {
                                            ?>
                                                    <a href="#">by <?php echo $authors->name; ?></a>
                                            <?php
                                                }
                                            } ?>
                                        </h3>
                                        <div class="price">
                                            <?php if ($books->coupon_id == null) {
                                                echo $books->price . " " . "<small>vnd</small>";
                                            } else {
                                                foreach ($this->data["coupons"] as $coupons) {
                                                    if ($books->coupon_id == $coupons->coupon_id) {
                                                        $sale = $books->price * (1 - $coupons->content);
                                                        echo "<p style='color:red'> " . $sale . "<small>vnd</small></p>" . "<span style='text-decoration-line:line-through'> " . $books->price . "<small>vnd</small> </span>";
                                                    }
                                                }
                                            }
                                            ?>
                                        </div>
                                        <a class="add-to-cart" onclick="onAddCart(<?php echo $books->book_id; ?>);" href="">+ Add To Cart</a>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <div>
                        <?php
                        if ($this->data["sort_type"] != "sort_sale" && $this->data["sort_type"] != "sort_rate") { ?>
                            <ul class="pagination">
                                <?php
                                for ($n = 1; $n <= $this->data["number_of_page"]; $n++) {
                                    if ($n != $this->data["page"]) { ?>
                                        <li><a href="/Bookshop/Filter/sort/?sort=<?php echo $this->data["sort"]; ?>&page=<?php echo $n; ?>"> <?php echo $n; ?> </a></li>
                                    <?php
                                    } else {
                                    ?>
                                        <li class="active"><a href="/Bookshop/Filter/sort/?sort=<?php echo $this->data["sort"]; ?>&page=<?php echo $n; ?>"> <?php echo $n; ?> </a></li>
                                <?php
                                    }
                                }
                                ?>
                            </ul>
                        <?php
                        }
                        ?>
                    </div>
                <?php
                } else {
                ?>
                    <div>
                        <h3>Empty</h3>
                    </div>
                <?php
                }

                ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function onAddCart(id) {
        <?php if (isset($_SESSION["user_id"])) { ?>
            $.ajax({
                url: "/Bookshop/Shopping/add_to_cart/",
                type: 'POST',
                data: {
                    book_id: id,
                },
                success: function(response) {
                    if (response == "Insert") {
                        alert("A book was added to the shopping cart.");
                    } else {
                        if (response == "Update") {
                            alert("Increase the quantity of the selected book by 1.");
                        } else {
                            alert(response);
                        }
                    }
                }
            });
        <?php } else { ?>
            alert("You need to login to add product to cart.");
        <?php
        } ?>
        return false;
    }
</script>