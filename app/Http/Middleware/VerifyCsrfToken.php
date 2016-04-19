<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
        'auth/*',
        'activity/*',
        'club/*',
        'team/*',
        'myTeamMember/*',
        'article/*',
        'clubImg/*',
        'clubNotice/*',
        'test/*',
        'h5/auth/*',
        'h5/activity/*',
        'h5/club/*',
        'h5/team/*',
        'h5/myTeamMember/*',
        'h5/article/*',
        'h5/clubImg/*',
        'h5/clubNotice/*',
        'h5/test/*',
        'h5/member/*',
        'h5/common/*',
        'admin/*',
    ];
}
