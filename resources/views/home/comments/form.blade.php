<div>
    <label for="content" class="block font-medium text-sm text-gray-700">{{ __('Content') }}</label>
    <textarea id="content" name="content" type="textarea" rows="5" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" >{{ isset($comment->content) ? $comment->content : ''}}</textarea>

    {!! $errors->first('content', '<p>:message</p>') !!}
</div>

<div>
    <label for="post_id" class="block font-medium text-sm text-gray-700"></label>
    <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="post_id" name="post_id" type="hidden" value="{{ isset($post->id) ? $post->id : ''}}" >
    {!! $errors->first('post_id', '<p>:message</p>') !!}
</div>


<div>
    <label for="status" class="block font-medium text-sm text-gray-700">{{ __('Status') }}</label>
    <select name="status" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="status" >
    @if ($post->type == "bug")
        @foreach (json_decode('{"\u672a\u89e3\u51b3":"\u672a\u89e3\u51b3","\u5df2\u89e3\u51b3":"\u5df2\u89e3\u51b3","\u5df2\u5173\u95ed":"\u5df2\u5173\u95ed"}', true) as $optionKey => $optionValue)
            <option value="{{ $optionKey }}" {{ (isset($post->status) && $post->status == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
        @endforeach
    @endif
    @if ($post->type == "todo")
        @foreach (['未完成'=>'未完成','进行中'=>'进行中','已完成'=>'已完成'] as $optionKey => $optionValue)
            <option value="{{ $optionKey }}" {{ (isset($post->status) && $post->status == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
        @endforeach
    @endif
    </select>
    {!! $errors->first('status', '<p>:message</p>') !!}
</div>

<div>
    <label for="user_id_do" class="block font-medium text-sm text-gray-700">{{ __('Assign') }}</label>
    <select name="user_id_do" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="user_id_do" >
        @foreach ($projectusers as $item)
            <option value="{{ $item->user->id }}" {{ (isset($post->user_id_do) && $post->user_id_do == $item->user->id) ? 'selected' : ''}}>{{ $item->user->name }}</option>
        @endforeach
    </select>
    {!! $errors->first('user_id_do', '<p>:message</p>') !!}
</div>


<div class="flex items-center gap-4">
    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
        {{ $formMode === 'edit' ? __('Update') : __('Create') }}
    </button>
</div>

<!--Include the JS & CSS-->
<link rel="stylesheet" href="{{ asset('richtexteditor/rte_theme_default.css') }}" />
<script type="text/javascript" src="{{ asset('richtexteditor/rte.js') }}"></script>
<script type="text/javascript" src="{{ asset('richtexteditor/plugins/all_plugins.js') }}"></script>

<script>
	var editor1cfg = {}
	editor1cfg.toolbar = "basic";
	var editor1 = new RichTextEditor("#content", editor1cfg);
	//editor1.setHTMLCode("Use inline HTML or setHTMLCode to init the default content.");
</script>