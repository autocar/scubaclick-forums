<?php namespace ScubaClick\Forums\Traits;

trait UserTrait
{
    /**
     * Connect the replies to the user
     *
     * @return object
     */
	public function replies()
	{
        return $this->hasMany('\\ScubaClick\\Forums\\Models\\Reply');
	}

    /**
     * Connect the topics to the user
     *
     * @return object
     */
	public function topics()
	{
        return $this->hasMany('\\ScubaClick\\Forums\\Models\\Topic');
	}
}
