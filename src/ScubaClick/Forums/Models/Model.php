<?php namespace ScubaClick\Forums\Models;

use DB;
use Request;
use Validator;
use Illuminate\Support\Str;
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
    public static $rules = array();

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

    /**
     * Create a unique slug
     *
     * @param string $title
     * @return void
     */
    public function getUniqueSlug($title)
    {
        $slug  = Str::slug($title);
        $table = $this->getTable();

        $row = DB::table($table)->where('slug', $slug)->first();

        if ($row) {
            $num = 2;
            while ($row) {
                $newSlug = $slug .'-'. $num;

                $row = DB::table($table)->where('slug', $newSlug)->first();
                $num++;
            }

            $slug = $newSlug;
        }

        return $slug;
    }

    /**
     * Get the route prefix
     *
     * @todo Moe this somewhere. Really shouldn't be here...
     * @return string
     */
    public function getRoutePrefix()
    {
        $chunks = explode('.', parse_url(Request::root(), PHP_URL_HOST));

        if(count($chunks) == 3 && $chunks[0] != 'www') {
            return $chunks[0] .'.';
        }

        return '';
    }
}
