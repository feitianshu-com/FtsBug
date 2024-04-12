<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="w-full">

                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{__('Show')}}
                            </h2>
                            <div class="flex justify-end mt-5">
                                <a class="px-2 py-1 rounded-md bg-sky-500 text-sky-100 hover:bg-sky-600" href="{{ route('posts.' . $post->type ,  $post->project_id ) }}" title="Back">< {{__('Back')}}</a>
                            </div>
                        </header>
                        </br>

                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <tr>
                                <td class="border px-8 py-4 font-bold">ID</td>
                                <td class="border px-8 py-4">{{ $post->id }}</td>
                            </tr>
                            <tr><td class="border px-8 py-4 font-bold"> {{__('Title')}} </td><td class="border px-8 py-4"> {{ $post->title }} </td></tr>
                            <tr><td class="border px-8 py-4 font-bold"> {{__('Content')}} </td><td class="border px-8 py-4"> {!! $post->content !!} </td></tr>
                            <tr><td class="border px-8 py-4 font-bold"> {{__('Assign')}} </td><td class="border px-8 py-4"> {{ $post->user_do->name }} </td></tr>
                            <tr><td class="border px-8 py-4 font-bold"> {{__('Status')}} </td><td class="border px-8 py-4"> {{ $post->status }} </td></tr>
                        </table>
                        @if (hasAccess(0, $post->id, "posts_comment"))
                        <form method="POST" action="{{ route('comments.store') }}" class="mt-6 space-y-6" accept-charset="UTF-8" enctype="multipart/form-data">
                            @csrf()
                            @include ('home.comments.form', ['formMode' => 'create'])
                        </form>
                        @endif
                        @include ('home.comments.index', ['comments' => $comments])
                    </section>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
