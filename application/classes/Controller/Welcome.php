<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Welcome extends Controller {

	public function action_index()
	{
		
		$view = View::factory('layouts/default');
		$view->page_title="Home Page::Throttled Search";
		$view->body = View::factory('welcome/index');
		$this->response->body($view);
	}

} // End Welcome
