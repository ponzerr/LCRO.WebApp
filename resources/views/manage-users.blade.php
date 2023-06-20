@extends('layouts.app')

@section('content')
<div class="flex flex-col justify-left items-left mx-1 mt-4">
    <p class="text-gray-500 text-m text-center">Republic of the Philippines</p>
    <p class="text-gray-500 text-m text-center">OFFICE OF THE CIVIL REGISTRAR GENERAL</p>
    <h2 class="font-semibold text-xl mb-2 text-gray-600 text-center">MANAGE USER ACCOUNTS</h2>
    <div class="flex items-center justify-center mx-8">
        <div class="w-full mx-auto px-8 mt-4">
            <div class="overflow-x-auto">
                <table class="w-full table-auto text-left text-sm font-light bg-white border border-gray-300">
                    <thead class="border-b bg-white font-medium">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-center">Name</th>
                            <th scope="col" class="px-6 py-3 text-center">Email</th>
                            <th scope="col" class="px-6 py-3 text-center">Actions</th>
                            <th scope="col" class="px-6 py-3 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr class="border-b bg-neutral-100">
                            <th class="whitespace-nowrap px-6 py-2 text-center">{{ $user->name }}</th>
                            <th class="whitespace-nowrap px-6 py-2 text-center">{{ $user->email }}</th>
                            <th class="whitespace-nowrap px-6 py-2 text-center">
                                @can('manage-users')
                                @if ($user->isApproved())
                                <form action="{{ route('users.pend', $user) }}"  class="inline-block mb-1 ml-4" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="flex items-center h-10 w-28 mr-4 rounded-lg bg-gradient-to-tr from-yellow-600 to-yellow-400 py-3 px-4 text-center font-sans text-xs font-bold uppercase text-white shadow-md shadow-yellow-500/20 transition-all hover:shadow-lg hover:shadow-yellow-500/40 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true" class="h-5 w-5 mr-2">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0-10.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.75c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.75h-.152c-3.196 0-6.1-1.249-8.25-3.286zm0 13.036h.008v.008H12v-.008z" />
                                        </svg>
                                        <span class="inline-block ml-1" class="inline-block mb-1 ml-4">Pending</span>
                                    </button>
                                </form>
                                @else
                                <form action="{{ route('users.approve', $user) }}" class="inline-block mb-1 ml-4" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="flex items-center h-10 w-28 mr-4 rounded-lg bg-gradient-to-tr from-green-600 to-green-400 py-3 px-4 text-center font-sans text-xs font-bold uppercase text-white shadow-md shadow-green-500/20 transition-all hover:shadow-lg hover:shadow-green-500/40 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true" class="h-5 w-5 mr-2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="inline-block ml-1">Approve</span>
                                    </button>
                                </form>
                                @endif
                                <!-- delete button -->
                                <form action="{{ route('users.destroy', $user) }}" class="inline-block mb-1 ml-4" method="POST" onsubmit="return confirm('Are you sure you want to delete this Mcert?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="flex items-center h-10 w-28 mr-4 rounded-lg bg-gradient-to-tr from-red-600 to-red-400 py-3 px-4 text-center font-sans text-xs font-bold uppercase text-white shadow-md shadow-red-500/20 transition-all hover:shadow-lg hover:shadow-red-500/40 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true" class="h-4 w-4 mr-2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                        <span>Delete</span>
                                    </button>
                                </form>
                            </th>
                            
                            <th class="whitespace-nowrap px-6 py-2 text-center">
                                @if ($user->isApproved())
                                <span class="px-2 py-1.5 bg-green-200 text-green-800 rounded-full">Approved</span>
                                @else
                                <span class="px-2 py-1.5 bg-yellow-200 text-yellow-800 rounded-full">Pending</span>
                                @endif
                            </th>
                            @endcan
                        </tr>
                        @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>



    <!-- <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if ($user->isApproved())
                            <span class="text-green-500">Approved</span>
                        @else
                            <span class="text-red-500">Pending</span>
                        @endif
                    </td>
                    <td>
                        @can('manage-users')
                            @if ($user->isApproved())
                                <form action="{{ route('users.pend', $user) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit">Pend</button>
                                </form>
                            @else
                                <form action="{{ route('users.approve', $user) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit">Approve</button>
                                </form>
                            @endif
                            <form action="{{ route('users.destroy', $user) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Delete</button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table> -->
@endsection