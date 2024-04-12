<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="w-full">

                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Show Project') }}
                            </h2>
                            <div class="flex justify-end mt-5">
                                <a class="px-2 py-1 rounded-md bg-sky-500 text-sky-100 hover:bg-sky-600" href="{{ route('projects.index') }}" title="Back">< {{ __('Back') }}</a>
                            </div>
                        </header>
                        </br>

                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <tr>
                                <td class="border px-8 py-4 font-bold">ID</td>
                                <td class="border px-8 py-4">{{ $project->id }}</td>
                            </tr>
                            <tr><td class="border px-8 py-4 font-bold"> Title </td><td class="border px-8 py-4"> {{ $project->title }} </td></tr>
                            <tr>
                                <td class="border px-8 py-4 font-bold"> Owner </td>
                                <td class="border px-8 py-4"> 
                                    {{ $project->user->name }}
                                </td>
                            </tr>
                            <tr>
                                <td class="border px-8 py-4 font-bold"> Testers </td>
                                <td class="border px-8 py-4"> 
                                    @foreach($testers as $item)
                                            {{ $item->user->name }} 
                                            @if (hasAccess($project->id, 0, "projects_op"))
                                            <form method="POST" action="{{ route('projects.deluser', $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                @csrf()
                                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded" title="Delete Project" onclick="return confirm(&quot;Confirm delete?&quot;)">{{ __('Delete') }}</button>
                                            </form>
                                            <form method="POST" action="{{ route('projects.changeuser', [$item->id, 'developer']) }}" accept-charset="UTF-8" style="display:inline">
                                                @csrf()
                                                <button type="submit" class="bg-indigo-600 hover:bg-indigo-800 text-white font-bold py-1 px-2 rounded" title="Delete Project">{{ __('To Developer') }}</button>
                                            </form>
                                            <form method="POST" action="{{ route('projects.changeuser', [$item->id, 'manager']) }}" accept-charset="UTF-8" style="display:inline">
                                                @csrf()
                                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded" title="Delete Project">{{ __('To Manager') }}</button>
                                            </form>
                                            @endif
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <td class="border px-8 py-4 font-bold"> developers </td>
                                <td class="border px-8 py-4"> 
                                    @foreach($developers as $item)
                                            {{ $item->user->name }} 
                                            @if (hasAccess($project->id, 0, "projects_op"))
                                            <form method="POST" action="{{ route('projects.deluser', $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                @csrf()
                                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded" title="Delete Project" onclick="return confirm(&quot;Confirm delete?&quot;)">{{ __('Delete') }}</button>
                                            </form>
                                            <form method="POST" action="{{ route('projects.changeuser', [$item->id, 'tester']) }}" accept-charset="UTF-8" style="display:inline">
                                                @csrf()
                                                <button type="submit" class="bg-indigo-600 hover:bg-indigo-800 text-white font-bold py-1 px-2 rounded" title="Delete Project">{{ __('To Tester') }}</button>
                                            </form>
                                            <form method="POST" action="{{ route('projects.changeuser', [$item->id, 'manager']) }}" accept-charset="UTF-8" style="display:inline">
                                                @csrf()
                                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded" title="Delete Project">{{ __('To Manager') }}</button>
                                            </form>
                                            @endif
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <td class="border px-8 py-4 font-bold"> managers </td>
                                <td class="border px-8 py-4"> 
                                    @foreach($managers as $item)
                                            {{ $item->user->name }} 
                                            @if (hasAccess($project->id, 0, "projects_op"))
                                            <form method="POST" action="{{ route('projects.deluser', $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                @csrf()
                                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded" title="Delete Project" onclick="return confirm(&quot;Confirm delete?&quot;)">{{ __('Delete') }}</button>
                                            </form>
                                            <form method="POST" action="{{ route('projects.changeuser', [$item->id, 'tester']) }}" accept-charset="UTF-8" style="display:inline">
                                                @csrf()
                                                <button type="submit" class="bg-indigo-600 hover:bg-indigo-800 text-white font-bold py-1 px-2 rounded" title="Delete Project">{{ __('To Tester') }}</button>
                                            </form>
                                            <form method="POST" action="{{ route('projects.changeuser', [$item->id, 'developer']) }}" accept-charset="UTF-8" style="display:inline">
                                                @csrf()
                                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded" title="Delete Project">{{ __('To Developer') }}</button>
                                            </form>
                                            @endif
                                    @endforeach
                                </td>
                            </tr>
                            @if (hasAccess($project->id, 0, "projects_op"))
                            <tr>
                                <td class="border px-8 py-4 font-bold"> Add User </td>
                                <td class="border px-8 py-4"> 
                                    <form method="POST" action="{{ route('projects.adduser') }}" class="" accept-charset="UTF-8" enctype="multipart/form-data">
                                        @csrf()
                                        <input name="project_id" type="hidden" value="{{ $project->id }}" />
                                        <input name="name" type="text" value="" placeholder="{{ __('Name') }}" />
                                        <select name="role">
                                            <option value="tester">{{ __('tester') }}</option>
                                            <option value="developer">{{ __('developer') }}</option>
                                            <option value="manager">{{ __('manager') }}</option>
                                        </select>
                                        <button class="px-2 py-1 rounded-md bg-sky-500 text-white hover:bg-sky-600">{{ __('Submit') }}</button>
                                    </form>
                                    {!! $errors->first('name', '<p>:message</p>') !!}
                                </td>
                            </tr>
                            @endif
                        </table>

                    </section>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
