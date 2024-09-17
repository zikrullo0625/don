<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function get_news()
    {
        return response()->json(News::all());
    }
}
