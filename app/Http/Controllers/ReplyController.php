<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReplyRequest;
use App\Models\File;
use App\Models\Reply;
use Intervention\Image\Facades\Image;
use Spatie\QueryBuilder\QueryBuilder;

class ReplyController extends Controller
{
    public function index()
    {
        //$replies = Reply::where('parent_id', null)->paginate(25);
        $replies = QueryBuilder::for(Reply::class)
            ->defaultSort('id')
            ->allowedSorts('name', 'email','id')
            ->paginate(25)
            ->appends(request()->query());
        return view('home')->with('replies', $replies);
    }

    public function store(StoreReplyRequest $request)
    {

        $validated = $request->validated();

        $reply = Reply::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'comment' => $validated['reply'],
        ]);

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $filename = uniqid() . '_' . $file->getClientOriginalName();
//                $file->storeAs('public/images', $filename);
                $img = Image::make($file);
                $img->resize(320,240, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $fileRecord = File::create([
                    'path' => $filename,
                    'reply_id' => $reply->id,
                ]);

                $img->save(storage_path('/app/public/images/').$filename);
            }
        }



        return redirect()->route('reply.index');

    }

    public function reply($id,StoreReplyRequest $request)
    {
        $parentReply = Reply::findOrFail($id);
        $validated = $request->validated();

        $reply = Reply::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'comment' => $validated['reply'],
            'parent_id'=> $parentReply->id
        ]);

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $filename = uniqid() . '_' . $file->getClientOriginalName();

                // Сжимаем изображение перед сохранением
                $compressedFilename = 'compressed_' . $filename;
                $compressedPath = storage_path("app/public/images/{$compressedFilename}");

                Image::make($file)
                    ->resize(800, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })
                    ->save($compressedPath);

                // Записываем данные о файле в базу данных
                $fileRecord = File::create([
                    'path' => $compressedFilename,
                    'reply_id' => $reply->id,
                ]);
            }
        }



        return redirect()->route('reply.index');

    }
}
