<form action="<?php echo home_url(); ?>/" method="get">
    <input type="text" name="s" id="search" placeholder="<?php echo get_search_query() == '' ? __('To Search; type and hit Enter', 'ozy_frontend') : get_search_query() ?>" />
</form>