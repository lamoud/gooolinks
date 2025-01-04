<?php

namespace App\Http\Controllers\Tenant\Backend;

use App\Http\Controllers\Controller;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use Illuminate\Http\Request;

class BackendController extends Controller
{
    public function dashboard()
    {
        $title = __('Dashboard');
        $pageType = 'te.dashboard';
        $SEOData = new SEOData(
            title: $title,
            description: get_setting('site_description'),
            author: get_setting('site_name'),
            site_name: get_setting('site_name'),
            image: get_setting('site_logo'),
        );
        return view('tenant.backend.dashboard.dashboard', compact(
            'SEOData',
            'pageType'
        ));
    }
}