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

if (!function_exists('get_route_prefix'))
{
	/**
	 * Get the route prefix
	 *
	 * @return string
	 */
	function get_route_prefix()
	{
	    $chunks = explode('.', parse_url(Request::root(), PHP_URL_HOST));

	    if(count($chunks) == 3 && $chunks[0] != 'www') {
	        return $chunks[0] .'.';
	    }

	    return '';
	}
}
