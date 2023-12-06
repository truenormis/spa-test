<article class="p-6 text-base bg-white rounded-lg dark:bg-gray-900 border-2" data-id="{{$reply->id}} ">
    <footer class="flex justify-between items-center mb-2">
        <div class="flex items-center">
            <p class="inline-flex items-center mr-3 text-sm text-gray-900 dark:text-white font-semibold">
                <img
                    class="mr-2 w-6 h-6 rounded-full"
                    src="https://flowbite.com/docs/images/people/profile-picture-2.jpg"
                    alt="Michael Gough">{{$reply->name}}</p>
            <p class="text-sm text-gray-600 dark:text-gray-400">

                <time pubdate datetime="2022-02-08"
                      title="February 8th, 2022">{{(\Carbon\Carbon::parse($reply->created_at))->format('M. j, Y')}}
                </time>
            </p>
        </div>
        <button id="dropdownComment1Button" data-dropdown-toggle="dropdownComment1"
                class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-500 dark:text-gray-400 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-50 dark:bg-gray-900 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                type="button">
            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                 viewBox="0 0 16 3">
                <path
                    d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z"/>
            </svg>
            <span class="sr-only">Comment settings</span>
        </button>
        <!-- Dropdown menu -->
        <div id="dropdownComment1"
             class="hidden z-10 w-36 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
            <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                aria-labelledby="dropdownMenuIconHorizontalButton">
                <li>
                    <a href="#"
                       class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit</a>
                </li>
                <li>
                    <a href="#"
                       class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Remove</a>
                </li>
                <li>
                    <a href="#"
                       class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Report</a>
                </li>
            </ul>
        </div>
    </footer>

        <article class="format lg:format-lg">
            {!! $reply->comment !!}
        </article>
    <div class="flex" id="images">
        @foreach($reply->images as $image)
            <a class="my-image-links" data-gall="gallery{{$reply->id}}" href="{{asset('storage/images/' . $image->path)}}">
                <img id="image" class="object-contain h-16 w-16 m-2 rounded-xl" src="{{asset('storage/images/' . $image->path)}}" alt="image description">
            </a>
        @endforeach
    </div>
    <div class="flex items-center mt-4 space-x-4">
        <button type="button" id="replybtn" data-modal-target="reply-modal" data-modal-toggle="reply-modal" data-reply="{{$reply->id}}" onclick="set_modal()"
                class="flex items-center text-sm text-gray-500 hover:underline dark:text-gray-400 font-medium">
            <svg class="mr-1.5 w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                 fill="none"
                 viewBox="0 0 20 18">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M5 5h5M5 8h2m6-3h2m-5 3h6m2-7H2a1 1 0 0 0-1 1v9a1 1 0 0 0 1 1h3v5l5-5h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1Z"/>
            </svg>
            Reply
        </button>
    </div>
</article>
@if(count($reply->childReplies)>0)
    <ul>

            @foreach($reply->childReplies as $reply_child)
            <li>@include('reply', ['reply' => $reply_child])</li>
            @endforeach

    </ul>
@endif
