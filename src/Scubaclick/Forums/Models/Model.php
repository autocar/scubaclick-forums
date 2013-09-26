<?php namespace ScubaClick\Forums\Models;

use Validator;
use Illuminate\Support\MessageBag;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Model extends Eloquent
{
    /**
     * Error message bag
     * 
     * @var Illuminate\Support\MessageBag
     */
    protected $errors;

    /**
     * Holds all validation rules
     *
     * @var MessageBag
     */
    public static $rules = [];

    /**
     * Validates current attributes against rules
     *
     * @return bool
     */
    public function validate()
    {
        $validator = Validator::make($this->attributes, static::$rules);

        if ($validator->passes()) {
            return true;
        }

        $this->setErrors($validator->messages());

        return false;
    }

    /**
     * Set error message bag
     * 
     * @var Illuminate\Support\MessageBag
     * @return void
     */
    protected function setErrors(MessageBag $errors)
    {
        $this->errors = $errors;
    }

    /**
     * Retrieve error message bag
     *
     * @return Illuminate\Support\MessageBag
     */
    public function getErrors()
    {
        return $this->errors instanceof MessageBag ? $this->errors : new MessageBag;
    }

    /**
     * Check if a model has been saved
     *
     * @return boolean
     */
    public function isSaved()
    {
        return $this->errors instanceof MessageBag ? false : true;
    }
}
