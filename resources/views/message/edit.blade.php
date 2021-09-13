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
                <a href="{{ url('/messages') }}" style="float: right;">
                    <span class="btn btn-secondary">Back to Subscribers</span>
                </a>
                <form action="{{ url('/messages/'.$message->id) }}" method="post">
                    @csrf
                    @method('PATCH')
                    <table class="table">
                        <thead>
                        <tr>
                            <th>
                                <p>Topic</p>
                                <select class="form-control" name="topic_id" required>
                                    <option value="">Select a Topic</option>
                                    @foreach($topics as $topic)
                                        <option {{ $topic->id == $message->topic_id?'selected':'' }} value="{{ $topic->id }}">{{ $topic->topic }}</option>
                                    @endforeach
                                </select>
                            </th>
                            <th>
                                <p>Message</p>
                                <input type="text" class="form-control" name="message" placeholder="http:localhost:9000" value="{{ $message->message }}">
                            </th>
                            <th>
                                <button class="btn btn-success">Update Message</button>
                            </th>
                        </tr>
                        </thead>
                    </table>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
