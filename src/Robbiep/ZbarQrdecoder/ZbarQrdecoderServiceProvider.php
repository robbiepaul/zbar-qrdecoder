<?php namespace RobbieP\ZbarQrdecoder;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Process\ProcessBuilder;

class ZbarQrdecoderServiceProvider extends ServiceProvider {

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

		$this->package('robbiep/zbar-qrdecoder');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['zbardecoder'] = $this->app->share(function($app)
		{
			$processBuilder = new ProcessBuilder();
			$config = $app['config']->get('zbar-qrdecoder::config');
			return new ZbarDecoder($config, $processBuilder);
		});

		$this->app->booting(function()
		{
			$loader = AliasLoader::getInstance();
			$loader->alias('ZbarDecoder', 'RobbieP\ZbarQrdecoder\Facades\ZbarDecoder');
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('zbardecoder');
	}

}
