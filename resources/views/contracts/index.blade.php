<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Contracts') }}
            </h2>
            @can('create contracts')
            <a href="{{ route('contracts.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add Contract
            </a>
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
                                                <a href="{{ route('contracts.edit', $contract->id) }}" class="text-yellow-500 hover:underline">Edit</a>
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
