<?php

namespace App\Http\Controllers\Tenant\Frontend;

use App\Http\Controllers\Controller;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function home()
    {
        $title = __('Home');
        $pageType = 'te.home';
        $SEOData = new SEOData(
            title: $title,
            description: get_setting('site_description'),
            author: get_setting('site_name'),
            site_name: get_setting('site_name'),
            image: get_setting('site_logo'),
        );
        return view('tenant.frontend.home.home', compact(
            'SEOData',
            'pageType'
        ));
    }

    public function profile()
    {
        $title = __('Profile');
        $pageType = 'te.profile.index';
        $SEOData = new SEOData(
            title: $title,
            description: get_setting('site_description'),
            author: get_setting('site_name'),
            site_name: get_setting('site_name'),
            image: get_setting('site_logo'),
        );
        return view('tenant.frontend.profile.profile', compact(
            'SEOData',
            'pageType'
        ));

    }

    public function profile_settings()
    {
        $title = __('Edit Profile');
        $pageType = 'te.profile.settings';
        $SEOData = new SEOData(
            title: $title,
            description: get_setting('site_description'),
            author: get_setting('site_name'),
            site_name: get_setting('site_name'),
            image: get_setting('site_logo'),
        );
        return view('tenant.frontend.profile.profile_settings', compact(
            'SEOData',
            'pageType'
        ));

    }
}
