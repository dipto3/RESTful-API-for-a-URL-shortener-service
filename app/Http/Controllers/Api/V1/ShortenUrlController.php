<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShortenUrlRequest;
use App\Http\Resources\V1\UrlResource;
use App\Models\Url;
use App\Services\ShortenUrlService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ShortenUrlController extends Controller
{
    protected $shortenUrlService;
    public function __construct(ShortenUrlService $shortenUrlService)
    {
        $this->shortenUrlService = $shortenUrlService;
    }
    public function store(ShortenUrlRequest $request)
    {
        $request->validated();
        $url = $this->shortenUrlService->store($request);
        return response()->json(['message' => 'Shortend URL genarated!', 'shortened_url_code' => url($url->shortened_url_code)]);
    }

    public function list()
    {
        return UrlResource::collection(Cache::remember('urls', 60 * 60 * 24, function () {
            $urls =  $this->shortenUrlService->list();
            return $urls;
        }));
    }
}
