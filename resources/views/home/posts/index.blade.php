<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="w-full">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ $type }}
                            </h2>
                            @if (hasAccess($project_id, 0, "posts_create".$type))
                            <div class="flex justify-end mt-5">
                                <a href="{{ route('posts.create'.$type, $project_id) }}" class="px-2 py-1 rounded-md bg-sky-500 text-white hover:bg-sky-600" title="Add New Post">{{__('Add New')}}</a>
                            </div>
                            @endif
                        </header>
                        </br>

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

                        <table class="overflow-x-auto w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">{{__('User')}}</th>
                                    <th scope="col" class="px-6 py-3">{{__('Project')}}</th>
                                    <th scope="col" class="px-6 py-3">{{__('Title')}}</th>
                                    <th scope="col" class="px-6 py-3">{{__('Status')}}</th>
                                    <th scope="col" class="px-6 py-3">{{__('Actions')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($posts as $item)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="px-6 py-4">{{ $item->user->name }}</td>
                                    <td class="px-6 py-4">{{ $item->project->title }}</td>
                                    <td class="px-6 py-4">{{ $item->title }}</td>
                                    <td class="px-6 py-4">{{ $item->status }}</td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('posts.show', $item->id) }}" title="View Post"><button type="button" class="bg-indigo-600 hover:bg-indigo-800 text-white font-bold py-1 px-2 rounded">{{__('View')}}</button></a>
                                        @if (hasAccess(0, $item->id, "posts_op"))
                                        <a href="{{ route('posts.edit', $item->id) }}" title="Edit Post"><button type="button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded">{{__('Edit')}}</button></a>
                                        @endif
                                        @if (hasAccess(0, $item->id, "posts_del"))
                                        <form method="POST" action="{{ route('posts.destroy', $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                            {{ method_field('DELETE') }}
                                            @csrf()
                                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded" title="Delete Post" onclick="return confirm(&quot;Confirm delete?&quot;)">{{__('Delete')}}</button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
    
                        <div class="mt-6">
                            {!! $posts->appends(['search' => Request::get('search')])->render() !!}
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
