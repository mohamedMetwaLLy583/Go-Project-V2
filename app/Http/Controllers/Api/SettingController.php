<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    /**
     * Get all public settings and pages.
     */
    public function index()
    {
        $settings = Setting::first();

        return response()->json([
            'success' => true,
            'data' => [
                'about_us' => $settings->about_us ?? 'من نحن',
                'privacy_policy' => $settings->privacy_policy ?? 'سياسة الخصوصية',
                'terms_and_conditions' => $settings->terms_and_conditions ?? 'الشروط والأحكام',
                'app_commission' => $settings->app_commission ?? '0',
            ]
        ]);
    }

    /**
     * Get a specific page content.
     */
    public function getPage($page)
    {
        $settings = Setting::first();
        
        $content = match($page) {
            'about' => $settings->about_us,
            'privacy' => $settings->privacy_policy,
            'terms' => $settings->terms_and_conditions,
            default => null
        };

        if (!$content) {
            return response()->json(['error' => 'Page not found'], 404);
        }

        return response()->json([
            'success' => true,
            'title' => $this->getPageTitle($page),
            'content' => $content
        ]);
    }

    private function getPageTitle($page)
    {
        return match($page) {
            'about' => 'من نحن',
            'privacy' => 'سياسة الخصوصية',
            'terms' => 'الشروط والأحكام',
            default => ''
        };
    }
}
