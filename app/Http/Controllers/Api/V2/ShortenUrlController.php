<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\UrlResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Url;

class ShortenUrlController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'long_url' => 'required|url',
        ]);
        $requestUrl = $request->long_url;
        $url = Url::where('long_url', $requestUrl)->first();
        $shortCode = Str::random(6);
        if (!$url) {
            $url = Url::create([
                'long_url' => $requestUrl,
                'shortened_url_code' => $shortCode,
                'user_id' => Auth::user()->id,
                'total_visit' => 0
            ]);
            $url = Url::where('shortened_url_code', $shortCode)->first();
        }
        return response()->json(['message' => 'Shortend URL genarated!', 'shortened_url_code' => url($url->shortened_url_code)]);
    }

    public function list()
    {
        $loggedInUser = Auth::user()->id;
        $urls =  Url::where('user_id', $loggedInUser)->get();
        return response()->json(UrlResource::collection($urls));
    }
}
