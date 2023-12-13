<?php

namespace App\Http\Controllers\Web\V1;

use App\Http\Controllers\Controller;
use App\Models\Url;
use Illuminate\Http\Request;

class ShortenUrlController extends Controller
{
    public function redirectToMainUrl($shortened_url_code)
    {
        $url = Url::where('shortened_url_code', $shortened_url_code)->first();
        if ($url) {
            $url->increment('total_visit');
            return redirect($url->long_url);
        }
    }
}
