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
                <a href="{{ url('/topics/create') }}" style="float: right;">
                    <span class="btn btn-success">Create Topic</span>
                </a>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Topic</th>
                        <th>Subscribers</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($topics as $topic)
                        <tr>
                            <td>{{ $topic->topic }}</td>
                            <td>
                                <ul>
                                    @foreach($topic->subscribers as $key=>$subscriber)
                                        <li>{{ $key+1 }}. {{ $subscriber->url }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="text-right">
                                <form action="{{ url('/topics/'.$topic->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ url('/topics/'.$topic->id.'/edit') }}">
                                        <span class="btn btn-warning">Edit Topic</span>
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
