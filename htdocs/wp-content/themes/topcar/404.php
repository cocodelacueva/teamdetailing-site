<?php
//try to find the page selected search page id
$notfound_page_id = ot_get_option("ic_404_page");
if((int)$notfound_page_id > 0 && get_page($notfound_page_id)) {
	header("location:" . get_permalink($notfound_page_id) );
	exit();
}

//if no custom 404 page found, continue to default one
get_header(); 
?>

<div class="container">

	<div class="row">
<?php
	
	echo '<div class="span12 ozy-page-content">' . PHP_EOL;
	
	echo '	<p>' . PHP_EOL;
	
	_e('Apologies, but the page you requested could not be found. Perhaps searching will help.', 'ozy_frontend');
	
	echo '	</p>' . PHP_EOL;
	
	get_search_form();
		
	echo '</div>' . PHP_EOL;

?>
	</div>
    
</div>

<script type="text/javascript">document.getElementById('search') && document.getElementById('search').focus();//focus on search field</script>

<?php
get_footer(); 	
?>