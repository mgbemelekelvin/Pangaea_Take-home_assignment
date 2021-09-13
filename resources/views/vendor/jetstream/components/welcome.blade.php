<div class="p-6 sm:px-20 bg-white border-b border-gray-200">
    <div class="mt-8 text-2xl">
        Welcome {{ Auth::user()->name }}<br>
        You can CRUD Topics, Subscribers and also publish Messages on topic.
    </div>
</div>

<div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2">
    <div class="p-6 border-t border-gray-200 md:border-l">
        <div class="ml-12">
            <div class="mt-2 text-sm text-gray-500 text-center">
                <a href="{{ url('/topics') }}">
                    <x-jet-button class="ml-4">
                        {{ __('View Topics') }}
                    </x-jet-button>
                </a>
            </div>
        </div>
    </div>
    <div class="p-6 border-t border-gray-200 md:border-l">
        <div class="ml-12">
            <div class="mt-2 text-sm text-gray-500 text-center">
                <a href="{{ url('/subscribers') }}">
                    <x-jet-button class="ml-4">
                        {{ __('View Subscribers') }}
                    </x-jet-button>
                </a>
            </div>
        </div>
    </div>
    <div class="p-6 border-t border-gray-200 md:border-l">
        <div class="ml-12">
            <div class="mt-2 text-sm text-gray-500 text-center">
                <a href="{{ url('/messages') }}">
                    <x-jet-button class="ml-4">
                        {{ __('View Messages') }}
                    </x-jet-button>
                </a>
            </div>
        </div>
    </div>
    <div class="p-6 border-t border-gray-200 md:border-l">
        <div class="ml-12">
            <div class="mt-2 text-sm text-gray-500 text-center">
                <a href="">
                    <x-jet-button class="ml-4">
                        Visit Github
                    </x-jet-button>
                </a>
            </div>
        </div>
    </div>
</div>
