<div class="py-12">
    <div class="w-full">
        <section>
            @if (session()->has('flash_message'))
            <div class="text-white px-6 py-4 border-0 rounded relative mb-4 bg-emerald-500">
                <span class="inline-block align-middle mr-8">
                    {{ session('flash_message') }}
                </span>
                <button class="absolute bg-transparent text-2xl font-semibold leading-none right-0 top-0 mt-4 mr-6 outline-none focus:outline-none" onclick="this.parentNode.parentNode.removeChild(this.parentNode);">
                    <span>×</span>
                </button>
            </div>
            @endif

            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">{{__('Content')}}</th><th scope="col" class="px-6 py-3">{{__('User')}}</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($comments as $item)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4">{!! $item->content !!}</td>
                        <td class="px-6 py-4">{{ $item->user->name }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="mt-6">
                {!! $comments->appends(['search' => Request::get('search')])->render() !!}
            </div>
        </section>
    </div>
</div>
