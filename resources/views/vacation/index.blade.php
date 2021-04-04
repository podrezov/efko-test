<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Vacations
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('vacations.search') }}" method="GET">
                <div class="grid grid-cols-12 gap-2">
                    <div class="col-span-5">
                        <label for="start_date" class="block text-sm font-medium text-gray-700">Start date</label>
                        <input type="date" name="start_date" id="start_date" value="{{ request()->input('start_date') }}"
                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                    <div class="col-span-5">
                        <label for="end_date" class="block text-sm font-medium text-gray-700">End date</label>
                        <input type="date" name="end_date" id="end_date" value="{{ request()->input('end_date') }}"
                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                    <div class="col-span-1 self-end">
                        <button type="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Search
                        </button>
                    </div>
                    <div class="col-span-1 self-end">
                        <a href="{{ route('vacations.index') }}"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Clear
                        </a>
                    </div>
                    @if(session()->exists('error_search'))
                        <div class="col-span-12 text-red-800">
                            {{ session()->get('error_search') }}
                        </div>
                    @endif
                </div>
            </form>

            @if((isset($isFixed) && !$isFixed) && request()->exists('start_date') && request()->exists('end_date') && auth()->user()->hasRole(\App\Models\Role::EMPLOYEE))
                <form action="{{ route('vacations.store') }}" method="post" class="mt-2">
                    @csrf
                    <input type="hidden" name="start_date" value="{{ request()->input('start_date') }}">
                    <input type="hidden" name="end_date" value="{{ request()->input('end_date') }}">
                    <button type="submit"
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        To plan
                    </button>
                </form>
            @endif

            <div class="flex flex-col mt-2">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Name
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Start
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        End
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Fixed
                                    </th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Edit</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($vacations as $vacation)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $vacation->user->name }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        {{ $vacation->user->email }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ $vacation->start_date->format('Y.m.d') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ $vacation->end_date->format('Y.m.d') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                             <span
                                                 class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $vacation->fixed ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ $vacation->fixed ? 'Yes' : 'No' }}
                                                </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            @if(auth()->user()->hasRole(\App\Models\Role::DIRECTOR))
                                                <form action="{{ route('vacations.fixed', $vacation) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="fixed"
                                                           value="{{ $vacation->fixed ? 0 : 1 }}">
                                                    <button
                                                        type="submit"
                                                        class="text-indigo-600 hover:text-indigo-900"
                                                    >
                                                        {{ $vacation->fixed ? 'Unfixed' : 'Fixed' }}
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-3">
                                            No dates scheduled
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{ $vacations->links() }}
        </div>
    </div>
</x-app-layout>
