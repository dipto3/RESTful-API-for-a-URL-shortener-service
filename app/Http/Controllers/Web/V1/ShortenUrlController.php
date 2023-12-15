<?php

namespace App\Http\Controllers\Web\V1;

use App\Http\Controllers\Controller;
use App\Models\Url;
use App\Models\VisitorCount;
use Illuminate\Http\Request;
use App\Services\ShortenUrlService;

class ShortenUrlController extends Controller
{
    protected $shortenUrlService;
    public function __construct(ShortenUrlService $shortenUrlService)
    {
        $this->shortenUrlService = $shortenUrlService;
    }
    public function redirectToMainUrl($shortened_url_code, Request $request)
    {
        $this->shortenUrlService->redirectToMainUrl($shortened_url_code, $request);
    }
}
