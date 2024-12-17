<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Select Contract for Transaction') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="min-w-full">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 border-b">Contract No</th>
                                <th class="px-6 py-3 border-b">Tenant</th>
                                <th class="px-6 py-3 border-b">Property</th>
                                <th class="px-6 py-3 border-b">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contracts as $contract)
                                <tr>
                                    <td class="px-6 py-4 border-b">{{ $contract->name }}</td>
                                    <td class="px-6 py-4 border-b">{{ $contract->tenant->fname }}</td>
                                    <td class="px-6 py-4 border-b">{{ $contract->property->name }}</td>
                                    <td class="px-6 py-4 border-b">
                                        <a href="{{ route('transactions.create', $contract->id) }}"
                                           class="text-blue-600 hover:text-blue-900">
                                            Record Payment
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $contracts->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
