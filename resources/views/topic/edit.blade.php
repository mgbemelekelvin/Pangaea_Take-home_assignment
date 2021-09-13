<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $title?$title:'Dashboard' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg m-5" style="padding: 20px;">
                @include('includes.notifications')
                <a href="{{ url('/topics') }}" style="float: right;">
                    <span class="btn btn-secondary">Back to Topics</span>
                </a>
                <form action="{{ url('/topics/'.$topic->id) }}" method="post">
                    @csrf
                    @method('PATCH')
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Topic</th>
                            <th>
                                <input type="text" class="form-control" name="topic" value="{{ $topic->topic }}">
                            </th>
                            <th>
                                <button class="btn btn-success">Update Topic</button>
                            </th>
                        </tr>
                        </thead>
                    </table>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
