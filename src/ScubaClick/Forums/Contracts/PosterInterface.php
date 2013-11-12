<?php namespace ScubaClick\Forums\Contracts;

interface PosterInterface
{
    /**
     * Get the posters full name
     *
     * @return string
     */
	public function getFullNameAttribute();

    /**
     * Get the posters avatar
     *
     * @return string
     */
	public function getAvatarUrl($size = 32);
}
