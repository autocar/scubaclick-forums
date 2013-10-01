<?php

if (!function_exists('load_forum_routes'))
{
	/**
	 * Include the forum routes
	 *
	 * If used on a subdomain, then $prefix should be set to that subdomain slug
	 *
	 * @param string $prefix
	 * @return void
	 */
	function load_forum_routes($prefix = '')
	{
		if(! empty($prefix)) {
			$prefix = $prefix .'.';
		}

		require __DIR__ .'/routes.php';
	}
}
