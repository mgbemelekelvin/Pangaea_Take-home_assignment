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
                <a href="{{ url('/subscribers/create') }}" style="float: right;">
                    <span class="btn btn-success">Create Subscriber</span>
                </a>
                <table class="table">
                    <thead>
                    <tr>
                        <th>URL</th>
                        <th>Topic</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($subs as $sub)
                        <tr>
                            <td>{{ $sub->url }}</td>
                            <td>{{ $sub->topic->topic }}</td>
                            <td class="text-right">
                                <form action="{{ url('/subscribers/'.$sub->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ url('/subscribers/'.$sub->id.'/edit') }}">
                                        <span class="btn btn-warning">Edit Subscriber</span>
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
