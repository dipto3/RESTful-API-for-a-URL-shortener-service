<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ShortenUrlController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'long_url' => 'required|url',
        ]);
        $requestUrl = $request->long_url;
        $url = Url::where('long_url', $requestUrl)->first();
        $sc = Str::random(6);
        if (! $url) {
            $url = Url::create([
                'long_url' => $requestUrl,
                'shortened_url_code' => $sc,
                'user_id' => Auth::user()->id,
                'total_visit' => 1,
            ]);
            $url = Url::where('shortened_url_code', $sc)->first();
        }

        return response()->json(['message' => 'Shortend URL genarated!', 'shortened_url_code' => url($url->shortened_url_code)]);
    }
}
