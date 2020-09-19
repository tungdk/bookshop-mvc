<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Shop Online</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- /* product  */ -->
    <style>
        .product-grid {
            /* font-family: Raleway, sans-serif; */
            text-align: center;
            padding: 0 0 72px;
            border: 1px solid rgba(0, 0, 0, .1);
            overflow: hidden;
            position: relative;
            z-index: 1
        }

        .product-grid .product-image {
            position: relative;
            transition: all .3s ease 0s
        }

        .product-grid .product-image a {
            display: block
        }

        .product-grid .product-image img {
            width: 100%;
            height: 200px;
        }

        .product-grid .pic-1 {
            opacity: 1;
            transition: all .3s ease-out 0s
        }

        .product-grid:hover .pic-1 {
            opacity: 1
        }

        .product-grid .pic-2 {
            opacity: 0;
            position: absolute;
            top: 0;
            left: 0;
            transition: all .3s ease-out 0s
        }

        .product-grid:hover .pic-2 {
            opacity: 1
        }

        .product-grid .social {
            width: 150px;
            padding: 0;
            margin: 0;
            list-style: none;
            opacity: 0;
            transform: translateY(-50%) translateX(-50%);
            position: absolute;
            top: 60%;
            left: 50%;
            z-index: 1;
            transition: all .3s ease 0s
        }

        .product-grid:hover .social {
            opacity: 1;
            top: 50%
        }

        .product-grid .social li {
            display: inline-block
        }

        .product-grid .social li a {
            color: #fff;
            background-color: #333;
            font-size: 16px;
            line-height: 40px;
            text-align: center;
            height: 40px;
            width: 40px;
            margin: 0 2px;
            display: block;
            position: relative;
            transition: all .3s ease-in-out
        }

        .product-grid .social li a:hover {
            color: #fff;
            background-color: #ef5777
        }

        .product-grid .social li a:after,
        .product-grid .social li a:before {
            content: attr(data-tip);
            color: #fff;
            background-color: #000;
            font-size: 12px;
            letter-spacing: 1px;
            line-height: 20px;
            padding: 1px 5px;
            white-space: nowrap;
            opacity: 0;
            transform: translateX(-50%);
            position: absolute;
            left: 50%;
            top: -30px
        }

        .product-grid .social li a:after {
            content: '';
            height: 15px;
            width: 15px;
            border-radius: 0;
            transform: translateX(-50%) rotate(45deg);
            top: -20px;
            z-index: -1
        }

        .product-grid .social li a:hover:after,
        .product-grid .social li a:hover:before {
            opacity: 1
        }

        .product-grid .product-discount-label,
        .product-grid .product-new-label {
            color: #fff;
            background-color: #ef5777;
            font-size: 12px;
            text-transform: uppercase;
            padding: 2px 7px;
            display: block;
            position: absolute;
            top: 10px;
            left: 0
        }

        .product-grid .product-discount-label {
            background-color: #333;
            left: auto;
            right: 0
        }

        .product-grid .rating {
            color: #FFD200;
            font-size: 12px;
            padding: 12px 0 0;
            margin: 0;
            list-style: none;
            position: relative;
            z-index: -1
        }

        .product-grid .rating li.disable {
            color: rgba(0, 0, 0, .2)
        }

        .product-grid .product-content {
            background-color: #fff;
            text-align: left;
            padding: 12px 0;
            margin: 0 auto;
            position: absolute;
            left: 0;
            right: 0;
            bottom: -27px;
            z-index: 1;
            transition: all .3s
        }

        .product-grid .product-content a:link {
            text-decoration-line: none;
        }

        .product-grid:hover .product-content {
            bottom: 0
        }

        .product-grid .title {
            font-size: 14px;
            font-weight: 200s;
            text-align: center;
            letter-spacing: .5px;
            text-transform: capitalize;
            margin: 0 0 10px;
            transition: all .3s ease 0s
        }

        .product-grid .title a {
            color: #828282
        }

        .product-grid .title a:hover,
        .product-grid:hover .title a {
            color: #ef5777
        }

        .product-grid .price {
            color: #333;
            font-size: 17px;
            font-family: Montserrat, sans-serif;
            font-weight: 700;
            letter-spacing: .6px;
            margin-bottom: 8px;
            text-align: center;
            transition: all .3s
        }

        .product-grid .price span {
            color: #999;
            font-size: 13px;
            font-weight: 400;
            text-decoration: line-through;
            margin-left: 3px;
            display: inline-block
        }

        .product-grid .add-to-cart {
            color: #000;
            font-size: 13px;
            font-weight: 600
        }

        @media only screen and (max-width:990px) {
            .product-grid {
                margin-bottom: 30px
            }
        }

        /* slider */
        .transition-timer-carousel .carousel-caption {
            background: -moz-linear-gradient(top, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.1) 4%, rgba(0, 0, 0, 0.5) 32%, rgba(0, 0, 0, 1) 100%);
            /* FF3.6+ */
            background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, rgba(0, 0, 0, 0)), color-stop(4%, rgba(0, 0, 0, 0.1)), color-stop(32%, rgba(0, 0, 0, 0.5)), color-stop(100%, rgba(0, 0, 0, 1)));
            /* Chrome,Safari4+ */
            background: -webkit-linear-gradient(top, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.1) 4%, rgba(0, 0, 0, 0.5) 32%, rgba(0, 0, 0, 1) 100%);
            /* Chrome10+,Safari5.1+ */
            background: -o-linear-gradient(top, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.1) 4%, rgba(0, 0, 0, 0.5) 32%, rgba(0, 0, 0, 1) 100%);
            /* Opera 11.10+ */
            background: -ms-linear-gradient(top, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.1) 4%, rgba(0, 0, 0, 0.5) 32%, rgba(0, 0, 0, 1) 100%);
            /* IE10+ */
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.1) 4%, rgba(0, 0, 0, 0.5) 32%, rgba(0, 0, 0, 1) 100%);
            /* W3C */
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#00000000', endColorstr='#000000', GradientType=0);
            /* IE6-9 */
            width: 100%;
            left: 0px;
            right: 0px;
            bottom: 0px;
            text-align: left;
            padding-top: 5px;
            padding-left: 15%;
            padding-right: 15%;
        }

        .transition-timer-carousel .carousel-caption .carousel-caption-header {
            margin-top: 10px;
            font-size: 24px;
        }

        @media (min-width: 970px) {

            /* Lower the font size of the carousel caption header so that our caption
    doesn't take up the full image/slide on smaller screens */
            .transition-timer-carousel .carousel-caption .carousel-caption-header {
                font-size: 36px;
            }
        }

        .transition-timer-carousel .carousel-indicators {
            bottom: 0px;
            margin-bottom: 5px;
        }

        .transition-timer-carousel .carousel-control {
            z-index: 11;
        }

        .transition-timer-carousel .transition-timer-carousel-progress-bar {
            height: 5px;
            background-color: #5cb85c;
            width: 0%;
            margin: -5px 0px 0px 0px;
            border: none;
            z-index: 11;
            position: relative;
        }

        .transition-timer-carousel .transition-timer-carousel-progress-bar.animate {
            /* We make the transition time shorter to avoid the slide transitioning
    before the timer bar is "full" - change the 4.25s here to fit your
    carousel's transition time */
            -webkit-transition: width 4.25s linear;
            -moz-transition: width 4.25s linear;
            -o-transition: width 4.25s linear;
            transition: width 4.25s linear;
        }

        /* end of slider */
        .center_title {
            text-align: center;
            background-color: blue;
            color: white;
        }
    </style>
    <script>
        $(document).ready(function() {
            //Events that reset and restart the timer animation when the slides change
            $("#transition-timer-carousel").on("slide.bs.carousel", function(event) {
                //The animate class gets removed so that it jumps straight back to 0%
                $(".transition-timer-carousel-progress-bar", this)
                    .removeClass("animate").css("width", "0%");
            }).on("slid.bs.carousel", function(event) {
                //The slide transition finished, so re-add the animate class so that
                //the timer bar takes time to fill up
                $(".transition-timer-carousel-progress-bar", this)
                    .addClass("animate").css("width", "100%");
            });
            //Kick off the initial slide animation when the document is ready
            $(".transition-timer-carousel-progress-bar", "#transition-timer-carousel")
                .css("width", "100%");
        });
    </script>
    <style>
        #result {
            position: absolute;
            width: 100%;
            max-width: 400px;
            cursor: pointer;
            overflow-y: auto;
            max-height: 200px;
            box-sizing: border-box;
            z-index: 1001;
        }
    </style>

</head>
<script type="text/javascript">
    function onAddCart(id) {
        <?php if (isset($_SESSION["user"])) { ?>
            $.ajax({
                url: "/Bookshop/Shopping/add_to_cart/",
                type: 'POST',
                data: {
                    book_id: id,
                },
                success: function(response) {
                    if (response.trim() == "Insert") {
                        alert("A book was added to the shopping cart.");
                    } else {
                        if (response.trim() == "Update") {
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
<body>
    <div class="panel-group">
        <div class="panel-heading">
            <div class="container">
                <nav class="nav">
                    <ul class="nav navbar-nav navbar-right">
                        <?php if (!isset($_SESSION["user"])) { ?>
                            <li><a class="btn btn-primary btn-sm" href="/Bookshop/Account/login/"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                            <li><a class="btn btn-default btn-sm" href="/Bookshop/Account/register/"><span class="glyphicon glyphicon-user"></span> Signup</a></li>
                        <?php } else { ?>
                            <li><a class="btn-primary" class="btn btn-primary btn-sm" href='#'><span class='glyphicon glyphicon-user'></span>Hello <?php echo $_SESSION["user"]["name"]; ?></a></li>
                            <li><a class="btn btn-default btn-sm" href="/Bookshop/Account/do_logout/"><span class="glyphicon glyphicon-log-out"></span>Log out</a></li>
                        <?php } ?>
                    </ul>
                </nav>
                <div class="row" style="margin-top: 10px;">
                    <div class="col-md-3">
                        <a href="/Bookshop/"><img style="margin-left: auto;margin-right:auto;display:block;" width="100px;" height="100px;" src="<?php echo "https://mir-s3-cdn-cf.behance.net/project_modules/disp/c039b824474525.56334ce736de9.jpg"; ?>"></a>
                    </div>
                    <div class="col-md-5">
                        <form style="margin-top: auto;margin-bottom:auto;" class="form-inline navbar-form" method="GET" action="/Bookshop/Filter/according_to_search_name/">
                            <div class="form-group form-group-lg">
                                <div class="text-primary"><i class="fa fa-phone"></i> 099999999</div>
                                <div class="text-primary"><i class="fa fa-envelope-square"></i> contact@bookshop.vn</div>
                                <input type="text" class="form-control" id="search_name" name="search_name" placeholder="Search">
                                <button name="search_button" class="btn btn-info btn-lg" type="submit">
                                    <i class="glyphicon glyphicon-search"></i>
                                </button>
                                <ul class="list-group" id="result"></ul>

                                <script>
                                    $(document).ready(function() {
                                        $("#search_name").keyup(function() {
                                            var query = $("#search_name").val();
                                            if (query != "" || query != null) {
                                                $.ajax({
                                                    url: '/Bookshop/Filter/live_search/',
                                                    method: 'GET',
                                                    data: {
                                                        search_name: query,
                                                    },
                                                    success: function(data) {
                                                        $("#result").html(data);
                                                    },
                                                });
                                            }
                                        });
                                    });
                                </script>
                            </div>
                        </form>
                    </div>
                    <?php
                    if (isset($_SESSION["user"])) {
                    ?>
                        <div class="col-md-2">
                            <a href="/Bookshop/Account/">
                                <img style="margin-left: auto;margin-right:auto;display:block;" width="50px;" height="50px;" src="<?php echo "data:image/png;base64,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"; ?>">
                                <p style="text-align: center;">Account</p>
                            </a>
                        </div>
                        <div class="col-md-2">
                            <a href="/Bookshop/Shopping/">
                                <img style="margin-left: auto;margin-right:auto;display:block;" width="50px;" height="50px;" src="<?php echo "data:image/png;base64,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"; ?>">
                                <p style="text-align: center;">Cart (<?php echo count($this->data["get_all_carts"]); ?>)</p>
                                <p style="text-align: center;"><?php echo $this->data["total_cost"]; ?> <small> vnd</small></p>
                            </a>
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <nav class="navbar navbar-inverse">
                    <ul class="nav navbar-nav">
                        <li><a href="/Bookshop/Home/"><span class="glyphicon glyphicon-home"></span> Home</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <span class="glyphicon glyphicon-user"></span> Author <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <?php
                                foreach ($this->data["authors"] as $authors) {
                                ?>
                                    <li><a href="/Bookshop/Filter/according_to_author/?id=<?php echo $authors->author_id; ?>"><?php echo $authors->name; ?></a></li>
                                <?php
                                }
                                ?>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <span class="glyphicon glyphicon-th"></span> Category <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <?php
                                foreach ($this->data["categories"] as $category) {
                                ?>
                                    <li><a href="/Bookshop/Filter/according_to_category/?id=<?php echo $category->category_id; ?>"><?php echo $category->name; ?></a></li>
                                <?php
                                }
                                ?>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <span class="glyphicon glyphicon-king"></span> Publisher <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <?php
                                foreach ($this->data["publishers"] as $publisher) {
                                ?>
                                    <li><a href="/Bookshop/Filter/according_to_publisher/?id=<?php echo $publisher->publisher_id; ?>"><?php echo $publisher->name; ?></a></li>
                                <?php
                                }
                                ?>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <span class="glyphicon glyphicon-sort"></span> Sort <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="/Bookshop/Filter/sort/?sort=name">A-Z</a></li>
                                <li><a href="/Bookshop/Filter/sort/?sort=date">Date</a></li>
                                <li><a href="/Bookshop/Filter/sort/?sort=sell">Most Sell</a></li>
                                <li><a href="/Bookshop/Filter/sort/?sort=rate">Most rating</a></li>
                                <li><a href="/Bookshop/Filter/sort/?sort=sale">Sale off</a></li>
                            </ul>
                        </li>
                        <li><a href="/Bookshop/Home/news/"><span class="glyphicon glyphicon-info-sign"></span> News</a></li>
                        <li><a href="/Bookshop/Home/introduction/"><span class="glyphicon glyphicon-asterisk"></span> Introduction</a></li>
                    </ul>
                </nav>
            </div>
        </div>