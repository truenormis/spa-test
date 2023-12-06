<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReplyRequest;
use App\Models\File;
use App\Models\Reply;
use App\Services\ReplyService;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;
use Spatie\QueryBuilder\QueryBuilder;

class ReplyController extends Controller
{
    public function index()
    {
        //$replies = Reply::where('parent_id', null)->paginate(25);
        $cacheKey = 'home_page';

        $replies = Cache::remember($cacheKey, now()->addMinutes(10), function () {
            return QueryBuilder::for(Reply::class)
                ->defaultSort('-id')
                ->allowedSorts('name', 'email', 'id')
                ->where('parent_id', null)
                ->paginate(25)
                ->appends(request()->query());
        });

        return view('home')->with('replies',$replies);
    }

    public function store(StoreReplyRequest $request)
    {
        $reply = new ReplyService($request);
        return redirect()->back();
    }

    public function reply($id,StoreReplyRequest $request)
    {
        $reply = new ReplyService($request,$id);
        return redirect()->route('reply.index');

    }
}
