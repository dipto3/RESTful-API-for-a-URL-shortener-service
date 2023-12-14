<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\UrlResource;
use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ShortenUrlController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'long_url' => 'required|url',
        ]);
        $requestUrl = $request->long_url;
        $loggedInUser = Auth::user()->id;
        $url = Url::where('user_id', $loggedInUser)->where('long_url', $requestUrl)->first();
        $shortCode = Str::random(6);
        if (! $url) {
            $url = Url::create([
                'long_url' => $requestUrl,
                'shortened_url_code' => $shortCode,
                'user_id' => Auth::user()->id,
            ]);
            $url = Url::where('shortened_url_code', $shortCode)->first();
        }

        return response()->json(['message' => 'Shortend URL genarated!', 'shortened_url_code' => url($url->shortened_url_code)]);
    }

    public function list()
    {
        return UrlResource::collection(Cache::remember('urls', 60 * 60 * 24, function () {
            $urls = Url::where('user_id', Auth::user()->id)->get();

            return $urls;
        }));
    }
}
