<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DirectedLanguage;
use App\Models\SpontaneousLanguage;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class SpontaneousLanguageController extends Controller
{

    public function getSpontaneousLanguageList($id){
        $spontaneousLanguages = SpontaneousLanguage::with('spontaneous', 'language')->where('language_id', $id)->orderBy('id', 'DESC')->get();
//        return $spontaneousLanguages;
        $firstItem = Arr::first($spontaneousLanguages, function ($value, $key) {
            return $value;
        });
        return view('admin.spontaneous_language.index', compact('spontaneousLanguages', 'firstItem'));
    }
}
