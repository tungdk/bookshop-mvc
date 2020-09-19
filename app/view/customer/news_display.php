<div class="panel">
    <div class="panel-heading">
        <ul class="breadcrumb">
            <li><a href="/Bookshop/">Home</a></li>
            <li><a href="/Bookshop/Home/news/">News</a></li>
        </ul>
    </div>
    <div class="panel-body">
        <!-- <h3 style="text-align: center;">News</h3> -->
        <?php
        foreach ($this->data["news"] as $news) {
        ?>
            <div class="panel container">
                <a href="/Bookshop/Home/news_details/?id=<?php echo $news->news_id; ?>">
                    <div class="row">
                        <div class="col-md-2">
                            <img src="<?php echo $news->image; ?>" alt="<?php echo $news->name; ?>" class="img-rounded" style="width:100%">
                        </div>
                        <div class="col-md-10">
                            <h4><?php echo $news->name; ?></h4>
                            <p><span class="glyphicon glyphicon-time"></span><?php echo " " . date_format(date_create($news->date), "d-m-yy"); ?></p>
                        </div>
                    </div>
                </a>
            </div>
        <?php
        }
        ?>
        <div class="container-fluid">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <ul class="pagination">
                    <?php
                    for ($k = 1; $k <= $this->data["number_of_page"]; $k++) {
                        if ($k != $this->data["page"]) {
                            echo '<li><a href="/Bookshop/Home/news/?page=' . $k . '">' . $k . '</li>';
                        } else {
                            echo '<li class="active"><a href="/Bookshop/Home/news/?page=' . $k . '">' . $k . '</li>';
                        }
                    }
                    ?>
                </ul>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
</div>