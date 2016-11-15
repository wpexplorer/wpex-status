<?php
/**
 * The Header for our theme.
 *
 * @package   Status WordPress Theme
 * @author    Alexander Clarke
 * @copyright Copyright (c) 2015, WPExplorer.com
 * @link      http://www.stplorer.com
 * @since     1.0.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?><?php st_schema_markup( 'body' ); ?>>

	<?php do_action( 'st_after_body_tag' ); ?>

	<div class="st-site-wrap">

		<?php get_template_part( 'partials/layout-topbar' ); ?>

		<?php get_template_part( 'partials/layout-header' ); ?>

		<?php get_template_part( 'partials/global/breadcrumbs' ); ?>

		<?php get_template_part( 'partials/global/trending' ); ?>
		
		<div class="st-site-content st-container st-clr">