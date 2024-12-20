<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Contracts') }}
            </h2>
            @can('create contracts')
            <h1 class="flex items-center">
                <a href="{{ route('contracts.renew') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded inline-flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Renew Contract
                </a>
                <a href="{{ route('contracts.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded inline-flex items-center ml-2">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Fresh Contract
                </a>
            </h1>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                            <thead class="bg-gray-100">
                                <tr class="text-left text-gray-600 text-sm font-medium">
                                    <th class="py-2 px-4 border-b">#</th>
                                    <th class="py-2 px-4 border-b">Name</th>
                                    <th class="py-2 px-4 border-b">Tenant</th>
                                    <th class="py-2 px-4 border-b">Property</th>
                                    <th class="py-2 px-4 border-b">Start Date</th>
                                    <th class="py-2 px-4 border-b">End Date</th>
                                    <th class="py-2 px-4 border-b">Amount</th>
                                    <th class="py-2 px-4 border-b">Security Amount</th>
                                    <th class="py-2 px-4 border-b">Ejari</th>
                                    <th class="py-2 px-4 border-b">Validity</th>
                                    <th class="py-2 px-4 border-b text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($contracts as $contract)
                                    <tr class="text-gray-700 text-sm hover:bg-gray-50">
                                        <td class="py-2 px-4 border-b">{{ $loop->iteration }}</td>
                                        <td class="py-2 px-4 border-b">{{ $contract->name }}</td>
                                        <td class="py-2 px-4 border-b">{{ $contract->tenant->fname }}</td>
                                        <td class="py-2 px-4 border-b">{{ $contract->property->name }}</td>
                                        <td class="py-2 px-4 border-b">{{ $contract->cstart }}</td>
                                        <td class="py-2 px-4 border-b">{{ $contract->cend }}</td>
                                        <td class="py-2 px-4 border-b">{{ number_format($contract->amount, 2) }}</td>
                                        <td class="py-2 px-4 border-b">{{ number_format($contract->sec_amt, 2) }}</td>
                                        <td class="py-2 px-4 border-b">{{ $contract->ejari }}</td>
                                        <td class="py-2 px-4 border-b">{{ $contract->validity }}</td>
                                        <td class="py-2 px-4 border-b text-right space-x-2">
                                            @can('view contracts')
                                                <a href="{{ route('contracts.show', $contract->id) }}" class="text-blue-500 hover:underline">View</a>
                                            @endcan

                                            @can('edit contracts')
                                                @if($contract->validity === 'YES')
                                                    <a href="{{ route('contracts.edit', $contract->id) }}" class="text-yellow-500 hover:underline">Edit</a>
                                                @else
                                                    <span class="text-gray-400 cursor-not-allowed" title="Cannot edit a terminated or renewed contract">Edit</span>
                                                @endif
                                            @endcan

                                            @can('delete contracts')
                                                <form action="{{ route('contracts.destroy', $contract->id) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Are you sure you want to delete this contract?')">
                                                        Delete
                                                    </button>
                                                </form>
                                            @endcan

                                            @can('create contracts')
                                            @if($contract->validity == 'NO')
                                                <span class="text-gray-500 bg-gray-200 px-2 py-1 rounded">N/A</span>
                                            @else
                                                <a href="{{ route('contracts.renew-form', $contract->id) }}"
                                                    class="text-blue-500 hover:underline">
                                                     Renew
                                                </a>
                                            @endif
                                            @endcan

                                            @can('create contracts')
                                                @if($contract->validity == 'YES')
                                                    <form action="{{ route('contracts.terminate', $contract->id) }}" method="POST" class="inline-block">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Are you sure you want to terminate this contract?')">
                                                            Terminate
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="text-gray-500 bg-gray-200 px-2 py-1 rounded">Terminated</span>
                                                @endif
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                                @if($contracts->isEmpty())
                                    <tr>
                                        <td colspan="11" class="py-4 text-center text-gray-500">
                                            No Contracts found.
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $contracts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
