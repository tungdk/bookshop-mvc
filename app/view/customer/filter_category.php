<div class="panel">
    <div class="panel-heading">
        <ul class="breadcrumb">
            <li><a href="/Bookshop/Home/index/">Home</a></li>
            <li><a href="">Filter</a></li>
            <li><a href="/Bookshop/Filter/according_to_category/?id=<?php echo $this->data["selected_category"]->category_id; ?>"><?php echo $this->data["selected_category"]->name; ?></a></li>
        </ul>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h4 style="text-align: center;"> Category : <?php echo $this->data["selected_category"]->name; ?></h4>
                </div>
                <div class="panel-body">
                    <h4>Description : <?php echo $this->data["selected_category"]->description; ?></h4>
                </div>
                <div class="panel-footer">
                    <a <?php if ($this->data["sort"] == "none") echo 'class="btn btn-info"'; else echo 'class="btn btn-default"'; ?> href="/Bookshop/Filter/according_to_category/?id=<?php echo $this->data["selected_category"]->category_id; ?>&sort=none">None</a>
                    <a <?php if ($this->data["sort"] == "name") echo 'class="btn btn-info"'; else echo 'class="btn btn-default"'; ?> href="/Bookshop/Filter/according_to_category/?id=<?php echo $this->data["selected_category"]->category_id; ?>&sort=name">Name</a>
                    <a <?php if ($this->data["sort"] == "sale") echo 'class="btn btn-info"'; else echo 'class="btn btn-default"'; ?> href="/Bookshop/Filter/according_to_category/?id=<?php echo $this->data["selected_category"]->category_id; ?>&sort=sale">Sale</a>
                    <a <?php if ($this->data["sort"] == "sell") echo 'class="btn btn-info"'; else echo 'class="btn btn-default"'; ?> href="/Bookshop/Filter/according_to_category/?id=<?php echo $this->data["selected_category"]->category_id; ?>&sort=sell">Sell</a>
                    <a <?php if ($this->data["sort"] == "rate") echo 'class="btn btn-info"'; else echo 'class="btn btn-default"'; ?> href="/Bookshop/Filter/according_to_category/?id=<?php echo $this->data["selected_category"]->category_id; ?>&sort=rate">Rate</a>
                    <a <?php if ($this->data["sort"] == "date") echo 'class="btn btn-info"'; else echo 'class="btn btn-default"'; ?> href="/Bookshop/Filter/according_to_category/?id=<?php echo $this->data["selected_category"]->category_id; ?>&sort=date">Date</a>
                </div>
            </div>
            <div class="col-md-8">
                <?php
                if (count($this->data["books"]) > 0) {
                ?>
                    <div class="row">
                        <?php
                        foreach ($this->data["books"] as $books) {
                        ?>
                            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
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
                                            <li><a href="/Bookshop/Details/index/?book_id=<?php echo $books->book_id; ?>" data-tip="Quick View"><span class="glyphicon glyphicon-search"></span></a></li>
                                            <li><a href="" id="<?php if (isset($_SESSION["user"])) echo $books->book_id; ?>" onclick="onAddCart(<?php echo $books->book_id; ?>)" data-tip="Add to Cart"><span class="glyphicon glyphicon-shopping-cart"></span></a></li>
                                        </ul>
                                    </div>
                                    <div class="product-content">
                                        <h3 class="title"><a href="/Bookshop/Details/index/?book_id=<?php echo $books->book_id; ?>"><?php echo $books->name ?></a></h3>
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
                        <ul class="pagination">
                            <?php
                            for ($n = 1; $n <= $this->data["number_of_page"]; $n++) {
                                if ($n != $this->data["page"]) { ?>
                                    <li><a href="/Bookshop/Filter/according_to_category/?id=<?php echo $this->data["selected_category"]->category_id; ?>&page=<?php echo $n; ?>"> <?php echo $n; ?> </a></li>;
                                <?php
                                } else {
                                ?>
                                    <li class="active"><a href="/Bookshop/Filter/according_to_category/?id=<?php echo $this->data["selected_category"]->category_id; ?>&page=<?php echo $n; ?>"> <?php echo $n; ?> </a></li>
                            <?php
                                }
                            }
                            ?>
                        </ul>
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
            <div class="col-md-4">
                <h4>List of Category</h4>
                <ul class="list-group">
                    <?php foreach ($this->data["categories"] as $categories) { ?>
                        <li class="list-group-item">
                            <a href="/Bookshop/Filter/according_to_category/?id=<?php echo $categories->category_id ?>"><?php echo $categories->name ?></a>
                            <span class="badge">
                                <?php
                                foreach ($this->data["count_book_of_each_category"] as $number) {
                                    foreach ($number as $id => $value) {
                                        if ($categories->category_id == $id)
                                            echo $value;
                                    }
                                }
                                ?>
                            </span>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</div>