<?php

namespace App\Http\Controllers\Web\V1;

use App\Http\Controllers\Controller;
use App\Models\Url;
use App\Models\VisitorCount;
use Illuminate\Http\Request;

class ShortenUrlController extends Controller
{
    public function redirectToMainUrl($shortened_url_code, Request $request)
    {
        $url = Url::where('shortened_url_code', $shortened_url_code)->first();
        if ($url) {
            $ipAddress = $request->ip();
            $existingRecord = VisitorCount::where('shortened_url_id', $url->id)
                ->where('ip_address', $ipAddress)
                ->first();
            if (! $existingRecord) {
                VisitorCount::create([
                    'shortened_url_id' => $url->id,
                    'ip_address' => $ipAddress,
                ]);
            }

            return redirect($url->long_url);
        }
    }
}
