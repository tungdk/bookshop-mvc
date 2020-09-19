<?php $news = $this->data["news"] ?>
<div class="panel">
    <div class="panel-heading">
        <ul class="breadcrumb">
            <li><a href="/Bookshop/">Home</a></li>
            <li><a href="/Bookshop/Home/news/">News</a></li>
            <li><a href="/Bookshop/Home/news_details/?id=<?php echo $news->news_id; ?>"><?php echo $news->name; ?></a></li>
        </ul>
    </div>
    <div class="panel-body">
        <div class="panel">
            <h3><?php echo $news->name; ?></h3>
            <p><span class="glyphicon glyphicon-time"></span><?php echo " " . date_format(date_create($news->date), "d-m-yy"); ?></p>
        </div>
        <?php
        echo $news->content;
        ?>
    </div>
</div>