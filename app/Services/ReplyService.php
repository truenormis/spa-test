<?php

namespace App\Services;

use App\Events\ReplyEvent;
use App\Http\Requests\StoreReplyRequest;
use App\Models\File;
use App\Models\Reply;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;

class ReplyService
{
    public function __construct(StoreReplyRequest $request, $id = null)
    {
        $validated = $request->validated();
//        if (!captcha_check($validated['captcha'])) {
//            return redirect()->back()->withErrors(['captcha' => 'Invalid Captcha']);
//        }
        if ($id !== null) {
            $parentReply = Reply::findOrFail($id);

            $reply = Reply::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'comment' => $validated['reply'],
                'parent_id'=> $parentReply->id
            ]);
        }else{
            $reply = Reply::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'comment' => $validated['reply'],
            ]);
        }
        event(new ReplyEvent($reply));
        Cache::forget('home_page');
        $this->fileStore($request, $reply);
    }


    /**
     * @param StoreReplyRequest $request
     * @param $reply
     * @return void
     */
    public function fileStore(StoreReplyRequest $request, $reply)
    {
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                // Проверка типа файла
                if (strpos($file->getMimeType(), 'image') !== false) {
                    // Если файл является изображением
                    $filename = uniqid() . '_' . $file->getClientOriginalName();
                    $img = Image::make($file);
                    $img->resize(320, 240, function ($constraint) {
                        $constraint->aspectRatio();
                    });

                    $fileRecord = File::create([
                        'path' => $filename,
                        'reply_id' => $reply->id,
                    ]);

                    $img->save(storage_path('/app/public/images/') . $filename);
                } else {
                    // Если файл не является изображением, просто сохраните его
                    $filename = uniqid() . '_' . $file->getClientOriginalName();
                    $file->storeAs('public/images', $filename);

                    $fileRecord = File::create([
                        'path' => $filename,
                        'reply_id' => $reply->id,
                    ]);
                }
            }
        }

    }

}
