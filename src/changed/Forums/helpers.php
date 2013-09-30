<?php

if (!function_exists('load_forum_routes'))
{
	/**
	 * Include the forum routes
	 *
	 * @return void
	 */
	function load_forum_routes()
	{
		require __DIR__ .'/routes.php';
	}
}
