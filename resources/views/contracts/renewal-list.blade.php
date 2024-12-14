<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Select Contract to Renew') }}
            </h2>
            <a href="{{ route('contracts.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Back to List') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if($validContracts->isEmpty())
                        <div class="text-center py-4">
                            <p class="text-gray-500">No contracts available for renewal.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-200">
                                <thead class="bg-gray-100">
                                    <tr class="text-left text-gray-600 text-sm font-medium">
                                        <th class="py-2 px-4 border-b">Contract No</th>
                                        <th class="py-2 px-4 border-b">Tenant</th>
                                        <th class="py-2 px-4 border-b">Property</th>
                                        <th class="py-2 px-4 border-b">Start Date</th>
                                        <th class="py-2 px-4 border-b">End Date</th>
                                        <th class="py-2 px-4 border-b">Rent</th>
                                        <th class="py-2 px-4 border-b">Sec Deposit</th>
                                        <th class="py-2 px-4 border-b">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($validContracts as $contract)
                                        <tr class="text-gray-700 text-sm hover:bg-gray-50">
                                            <td class="py-2 px-4 border-b">{{ $contract->name }}</td>
                                            <td class="py-2 px-4 border-b">{{ $contract->tenant->fname }}</td>
                                            <td class="py-2 px-4 border-b">{{ $contract->property->name }}</td>
                                            <td class="py-2 px-4 border-b">{{ $contract->cstart }}</td>
                                            <td class="py-2 px-4 border-b">{{ $contract->cend }}</td>
                                            <td class="py-2 px-4 border-b">{{ number_format($contract->amount, 2) }}</td>
                                            <td class="py-2 px-4 border-b">{{ number_format($contract->sec_amt, 2) }}</td>
                                            <td class="py-2 px-4 border-b">
                                                <a href="{{ route('contracts.renew-form', $contract->id) }}"
                                                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                                    Renew
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination Links -->
                        <div class="mt-4">
                            {{ $validContracts->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
