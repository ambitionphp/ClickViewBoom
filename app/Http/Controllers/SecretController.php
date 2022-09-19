<?php

namespace App\Http\Controllers;

use App\Models\Text;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Http\Request;

class SecretController extends Controller
{
    public function private(Text $text) {
        if( $text->expires_at->lessThanOrEqualTo(\Carbon\Carbon::now()) ) {
            $text->delete();
            SEOTools::setTitle('No such text');
            return response()->view('text.unknown');
        }
        SEOTools::setTitle('You saved a text');
        return view('text.private', [
            'text' => $text
        ]);
    }

    public function secret(Text $text) {
        if( $text->expires_at->lessThanOrEqualTo(\Carbon\Carbon::now()) ) {
            $text->delete();
            SEOTools::setTitle('No such text');
            return response()->view('text.unknown');
        }
        SEOTools::setTitle('You received a text');
        return view('text.secret', [
            'text' => $text
        ]);
    }
}
