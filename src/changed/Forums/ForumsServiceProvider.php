<?php namespace ScubaClick\Forums;

use URL;
use Request;
use Illuminate\Support\Str;
use ScubaClick\Forums\Models\Topic;
use Illuminate\Support\ServiceProvider;

class ForumsServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('scubaclick/forums');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->bindContracts();
		$this->incrementViews();
		$this->loadHelpers();
	}

	/**
	 * Load the helper functions
	 *
	 * @return void
	 */
	protected function loadHelpers()
	{
		require __DIR__ .'/helpers.php';
	}

	/**
	 * Increment the topic views
	 *
	 * @todo Needs some fine-tuning
	 * @return void
	 */
	protected function incrementViews()
	{
        $this->app['view']->composer('forums::front.loops.replies', function($view) {
			$topic = Topic::findBySlug(Request::segment(2), Request::segment(1));

			if(!Str::contains(URL::previous(), $topic->getLink())) {
        		$topic->increment('views');
        	}
        });
	}

	/**
	 * Bind all interfaces
	 *
	 * @return void
	 */
	protected function bindContracts()
	{
        $this->app->bind(
            'ScubaClick\\Forums\\Contracts\\ForumsInterface',
            'ScubaClick\\Forums\\Repositories\\Eloquent\\ForumsRepository'
        );

        $this->app->bind(
            'ScubaClick\\Forums\\Contracts\\TopicsInterface',
            'ScubaClick\\Forums\\Repositories\\Eloquent\\TopicsRepository'
        );

        $this->app->bind(
            'ScubaClick\\Forums\\Contracts\\RepliesInterface',
            'ScubaClick\\Forums\\Repositories\\Eloquent\\RepliesRepository'
        );

        $this->app->bind(
            'ScubaClick\\Forums\\Contracts\\LabelsInterface',
            'ScubaClick\\Forums\\Repositories\\Eloquent\\LabelsRepository'
        );
    }
}
