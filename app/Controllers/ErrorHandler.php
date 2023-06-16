<?php

namespace App\Controllers;

class ErrorHandler extends BaseController
{
	public function pageNotFound()
	{
		return view('templates/page_not_found');
	}
}