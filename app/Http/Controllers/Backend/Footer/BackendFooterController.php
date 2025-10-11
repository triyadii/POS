<?php

namespace App\Http\Controllers\Backend\Footer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

use App\Models\Changelog;

class BackendFooterController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Get the latest changelog.
     *
     * @return \App\Models\Changelog|null
     */
    public function getLatestChangelog()
    {
        return Changelog::latest()->first();
    }
}
