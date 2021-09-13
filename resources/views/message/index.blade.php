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
                <a href="{{ url('/messages/create') }}" style="float: right;">
                    <span class="btn btn-success">Create Message</span>
                </a>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Message</th>
                        <th>Topic</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($msgs as $msg)
                        <tr>
                            <td>{{ $msg->message }}</td>
                            <td>{{ $msg->topic->topic }}</td>
                            <td class="text-right">
                                <form action="{{ url('/messages/'.$msg->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ url('/messages/'.$msg->id.'/edit') }}">
                                        <span class="btn btn-warning">Edit Message</span>
                                    </a>
                                    <button class="btn btn-danger" onclick="return confirm('Are you Sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
