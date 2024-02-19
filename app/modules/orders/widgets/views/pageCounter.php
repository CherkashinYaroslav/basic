<div class="col-sm-4 pagination-counters">
    <?php
    if ($provider->totalCount > $provider->pagination->limit) {
        echo $provider->pagination->page * $provider->pagination->limit.' to';
        echo ($provider->pagination->page + 1) * $provider->pagination->limit.'of';
    }
    ?>
    <?php echo $provider->totalCount?>
</div>
