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
                <a href="{{ url('/subscribers') }}" style="float: right;">
                    <span class="btn btn-secondary">Back to Subscribers</span>
                </a>
                <form action="{{ url('/subscribers') }}" method="post">
                    @csrf
                    <table class="table">
                        <thead>
                        <tr>
                            <th>
                                <p>Topic</p>
                                <select class="form-control" name="topic_id" required>
                                    <option value="">Select a Topic</option>
                                    @foreach($topics as $topic)
                                        <option value="{{ $topic->id }}">{{ $topic->topic }}</option>
                                    @endforeach
                                </select>
                            </th>
                            <th>
                                <p>URL</p>
                                <input type="text" class="form-control" name="url" placeholder="http:localhost:9000">
                            </th>
                            <th>
                                <button class="btn btn-success">Create Subscriber</button>
                            </th>
                        </tr>
                        </thead>
                    </table>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
