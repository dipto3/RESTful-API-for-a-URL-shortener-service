<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Models\Url;
use Illuminate\Support\Str;
use App\Models\VisitorCount;

class ShortenUrlService
{
    public function store($request)
    {
        $requestUrl = $request->long_url;
        $loggedInUser = Auth::user()->id;
        $url = Url::where('user_id', $loggedInUser)->where('long_url', $requestUrl)->first();
        $shortCode = Str::random(6);
        if (!$url) {
            $url = Url::create([
                'long_url' => $requestUrl,
                'shortened_url_code' => $shortCode,
                'user_id' => Auth::user()->id,
            ]);
            $url = Url::where('shortened_url_code', $shortCode)->first();
        }

        return $url;
    }

    public function list(){
        $urls = Url::where('user_id', Auth::user()->id)->get();
        return $urls;
    }

    public function redirectToMainUrl($shortened_url_code, $request)
    {
        $url = Url::where('shortened_url_code', $shortened_url_code)->first();
        if ($url) {
            $ipAddress = $request->ip();
            $existingRecord = VisitorCount::where('shortened_url_id', $url->id)
                ->where('ip_address', $ipAddress)
                ->first();
            if (!$existingRecord) {
                VisitorCount::create([
                    'shortened_url_id' => $url->id,
                    'ip_address' => $ipAddress,
                ]);
            }

            return redirect($url->long_url);
        }
    }
}
