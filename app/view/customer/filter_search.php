<?php
// print_r($this->data["categorized_books"]);
?>
<div class="row">
    <h3 style="text-align: center;"> Searching for : <?php echo $this->data["search_name"] ?></h3>
    <h4 style="text-align: center;"> There are <?php echo ($this->data["count_book_according_to_search_name"]); ?> results </h4>
    <div class="col-md-12">
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
                                    <li><a href="" onclick="onAddCart(<?php echo $books->book_id; ?>);" id="<?php if (isset($_SESSION["user"])) echo $books->book_id; ?>" onclick="onAddCart(<?php echo $books->book_id; ?>)" data-tip="Add to Cart"><span class="glyphicon glyphicon-shopping-cart"></span></a></li>
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
                                <a class="add-to-cart" onclick="onAddCart(<?php echo $book->book_id; ?>);" href="">+ Add To Cart</a>
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
                            <li><a href="/Bookshop/Filter/according_to_search_name/?search_name=<?php echo $this->data["search_name"]; ?>&page=<?php echo $n; ?>"> <?php echo $n; ?> </a></li>;
                        <?php
                        } else {
                        ?>
                            <li class="active"><a href="/Bookshop/Filter/according_to_search_name/?search_name=<?php echo $this->data["search_name"]; ?>&page=<?php echo $n; ?>"> <?php echo $n; ?> </a></li>
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
</div>