<?php
/**
 * @package Minimalizine
 * @since Minimalizine 1.0
 */
?>
	<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
		<input type="text" class="field" name="s" id="s" placeholder="<?php esc_attr_e( 'Search &hellip;', 'minimalizine' ); ?>" />
		<input type="submit" class="submit" id="submit" value="<?php esc_attr_e( 'Search', 'minimalizine' ); ?>" />
	</form>
