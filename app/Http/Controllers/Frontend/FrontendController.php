<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class FrontendController extends Controller
{
    public function home()
    {
        return view('frontend.home.home');
    }

    public function profile()
    {
        $title = __('Profile');
        $pageType = 'profile.index';
        $SEOData = new SEOData(
            title: $title,
            description: get_setting('site_description'),
            author: get_setting('site_name'),
            site_name: get_setting('site_name'),
            image: get_setting('site_logo'),
        );
        return view('frontend.profile.profile', compact(
            'SEOData',
            'pageType'
        ));

    }

    public function plans_subscription()
    {
        $title = __('Plan and subscription');
        $pageType = 'plans';
        $SEOData = new SEOData(
            title: $title,
            description: get_setting('site_description'),
            author: get_setting('site_name'),
            site_name: get_setting('site_name'),
            image: get_setting('site_logo'),
        );
        return view('frontend.plans.plans', compact(
            'SEOData',
            'pageType'
        ));

    }

    public function plans_subscription_show( $slug )
    {
        $plan = Plan::where('slug', $slug)->firstOrFail();
        $title =  $plan->name;
        $pageType = 'plans.show';
        $SEOData = new SEOData(
            title: $title,
            description: get_setting('site_description'),
            author: get_setting('site_name'),
            site_name: get_setting('site_name'),
            image: get_setting('site_logo'),
        );
        return view('frontend.plans.plans_show', compact(
            'SEOData',
            'pageType',
            'plan'
        ));

    }

    public function profile_settings()
    {
        $title = __('Edit Profile');
        $pageType = 'profile.settings';
        $SEOData = new SEOData(
            title: $title,
            description: get_setting('site_description'),
            author: get_setting('site_name'),
            site_name: get_setting('site_name'),
            image: get_setting('site_logo'),
        );
        return view('frontend.profile.profile_settings', compact(
            'SEOData',
            'pageType'
        ));

    }
}
