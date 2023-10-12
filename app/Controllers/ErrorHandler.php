<?php

namespace App\Controllers;

class ErrorHandler extends BaseController
{
	public function pageNotFound()
	{
		return view('templates/page_not_found', ['dashboardUrl' => $this->getResourcesURLs('dashboard')]);
	}

	public function getResourcesURLs($resource_type)
    {
        $current_env = strtolower($_SERVER['CI_ENVIRONMENT']);

        $resources = (object) [];

        $resources->form = $current_env === 'production' ? 'https://helloshuttle.com/' : 'http://localhost/projects/hello-shuttle/public/';
        $resources->dashboard = $current_env === 'production' ? 'https://dashboard.helloshuttle.com/' : 'http://localhost/projects/hello-shuttle-dashboard/public/';

        return $resources->{$resource_type};
    }
}