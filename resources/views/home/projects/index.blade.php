<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="w-full">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{__('Projects')}}
                            </h2>
                            <div class="flex justify-end mt-5">
                                <a href="{{ route('projects.create') }}" class="px-2 py-1 rounded-md bg-sky-500 text-white hover:bg-sky-600" title="Add New Project">{{ __('Add New') }}</a>
                            </div>
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
                                    <th scope="col" class="px-6 py-3">#</th>
                                    <th scope="col" class="px-6 py-3">Title</th><th scope="col" class="px-6 py-3">User Id</th>
                                    <th scope="col" class="px-6 py-3">Todo & Bug</th>
                                    <th scope="col" class="px-6 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($projects as $item)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="px-6 py-4">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4">{{ $item->title }}</td><td class="px-6 py-4">{{ $item->user->name }}</td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('posts.todo', $item->id) }}" title="View Project"><button type="button" class="bg-indigo-600 hover:bg-indigo-800 text-white font-bold py-1 px-2 rounded">Todo</button></a>
                                        <a href="{{ route('posts.bug', $item->id) }}" title="Edit Project"><button type="button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded">Bug</button></a>
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('projects.show',$item->id) }}" title="View Project"><button type="button" class="bg-indigo-600 hover:bg-indigo-800 text-white font-bold py-1 px-2 rounded">{{ __('View') }}</button></a>
                                        
                                        @if (hasAccess($item->id, 0, "projects_op"))
                                            <a href="{{ route('projects.edit',$item->id) }}" title="Edit Project"><button type="button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded">{{ __('Edit') }}</button></a>
                                        @endif
                                        @if (hasAccess($item->id, 0, "projects_del"))
                                        <form method="POST" action="{{ route('projects.destroy', $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                            {{ method_field('DELETE') }}
                                            @csrf()
                                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded" title="Delete Project" onclick="return confirm(&quot;Confirm delete?&quot;)">{{ __('Delete') }}</button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
    
                        <div class="mt-6">
                            {!! $projects->appends(['search' => Request::get('search')])->render() !!}
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
