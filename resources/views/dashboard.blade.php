<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="w-full bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 flex w-full text-gray-900">
                    <div>
                        <h2 class="text-xl mb-4">Users</h2>
                        <ul class="w-80 h-96 overflow-auto">
                            @foreach ($participants as $participant)
                                <li class="mb-3 p-1 border">
                                    <a class="flex items-center" href="/messages/rooms/{{ $participant->room->id }}">
                                        <div class="pr-3 flex">
                                            <span class="relative inline-block">
                                                <img class="h-16 w-16 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                                                <span class="absolute right-0 top-0 block h-4 w-4 rounded-full bg-green-400 ring-2 ring-white"></span>
                                            </span>
                                        </div>
                                        <div>
                                            {{ $participant->user->name }}
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="w-2/3">
                        <div class="border h-full w-full ml-4 flex flex-col justify-between">
                            <div class="max-h-80 overflow-auto">
                                @foreach ($room->messages as $message)
                                    <div class="py-1 px-2 @if($message->user_id == auth()->id()) text-right @endif">
                                        <p class="font-bold">{{ $message->user->name }}</p>
                                        {{ $message->message }}
                                    </div>
                                @endforeach
                            </div>
                            <div class="mt-3">
                                <form class="flex flex-col items-end" method="POST" action="/messages/rooms/{{ $room->id }}">
                                    @csrf
                                    <textarea class="form-textarea w-full h-16" name="message"></textarea>
                                    <button type="submit" class="border py-1 px-4 my-2">Send</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
