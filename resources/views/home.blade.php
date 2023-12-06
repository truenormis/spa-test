<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
    @vite(['resources/css/app.css','resources/js/app.js'])

</head>
<body>

<section class="bg-white dark:bg-gray-900 py-8 lg:py-16 antialiased">
    <div class="max-w-2xl mx-auto px-4">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg lg:text-2xl font-bold text-gray-900 dark:text-white">Discussion ({{count($replies)}})</h2>
        </div>
        @if ($errors->any())
            <div class="flex p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 me-3 mt-[2px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <span class="sr-only">Danger</span>
                <div>
                    <span class="font-medium">Ensure that these requirements are met:</span>
                    <ul class="mt-1.5 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>

        @endif
        @include('form')

        @include('sort')




        <ul class="wtree">

            @foreach ($replies as $reply)
                <li>
                    @include('reply', ['reply' => $reply])
                </li>

            @endforeach
        </ul>

    </div>
</section>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    body {
        padding: 50px;
        font-family: helvetica, arial, sans-serif;
    }
    ul {
        margin-left: 20px;
    }
    .wtree li {
        list-style-type: none;
        margin: 10px 0 10px 10px;
        position: relative;
    }
    .wtree li:before {
        content: "";
        position: absolute;
        top: -10px;
        left: -20px;
        border-left: 1px solid #ddd;
        border-bottom: 1px solid #ddd;
        width: 20px;
        height: 15px;
    }
    .wtree li:after {
        position: absolute;
        content: "";
        top: 5px;
        left: -20px;
        border-left: 1px solid #ddd;
        border-top: 1px solid #ddd;
        width: 20px;
        height: 100%;
    }
    .wtree li:last-child:after {
        display: none;
    }
    .wtree li span {
        display: block;
        border: 1px solid #ddd;
        padding: 10px;
        color: #888;
        text-decoration: none;
    }

</style>





<!-- Main modal -->
<div id="reply-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full" >
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700 pe-10 pl-10 pb-3" id="form-modal">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Reply to Comment:
                </h3>
                <button type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="reply-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            @include('form')
        </div>
    </div>
</div>


<div class="flex justify-center">
    {{$replies->links()}}
</div>



@vite(['resources/js/replyform.js'])
@vite(['resources/js/venobox.min.js'])
@vite(['resources/css/venobox.min.css'])
@vite(['resources/js/image.js'])
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>
</body>
</html>
