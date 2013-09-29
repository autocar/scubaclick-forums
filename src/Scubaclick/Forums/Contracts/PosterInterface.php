<?php namespace ScubaClick\Forums\Contracts;

interface PosterInterface
{
    /**
     * Get the posters full name
     *
     * @return string
     */
	public function getFullName();

    /**
     * Get the posters avatar
     *
     * @return string
     */
	public function getAvatarUrl($size = 32);
}
