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
    	'file_upload/file/delete' , 'file_upload/file/upload/store' , 'file_upload/file/upload', 'file_upload/file/zipcreate'
    ];
}
