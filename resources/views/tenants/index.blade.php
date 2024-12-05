<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Properties') }}
            </h2>
            @can('create property')
    <a href="{{ route('properties.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded inline-flex items-center">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Add Property
    </a>
@endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                            <thead class="bg-gray-100">
                                <tr class="text-left text-gray-600 text-sm font-medium">
                                    <th class="py-2 px-4 border-b">#</th>
                                    <th class="py-2 px-4 border-b">Name</th>
                                    <th class="py-2 px-4 border-b">Class</th>
                                    <th class="py-2 px-4 border-b">Type</th>
                                    <th class="py-2 px-4 border-b">Community</th>
                                    <th class="py-2 px-4 border-b">Owner</th>
                                    <th class="py-2 px-4 border-b">Purchase Value</th>
                                    <th class="py-2 px-4 border-b">Sales Deed</th>
                                    <th class="py-2 px-4 border-b text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($properties as $property)
                                    <tr class="text-gray-700 text-sm hover:bg-gray-50">
                                        <td class="py-2 px-4 border-b">{{ $loop->iteration }}</td>
                                        <td class="py-2 px-4 border-b">{{ $property->name }}</td>
                                        <td class="py-2 px-4 border-b">{{ $property->class }}</td>
                                        <td class="py-2 px-4 border-b">{{ $property->type }}</td>
                                        <td class="py-2 px-4 border-b">{{ $property->community }}</td>
                                        <td class="py-2 px-4 border-b">{{ $property->owner->name }}</td>
                                        <td class="py-2 px-4 border-b">{{ number_format($property->purchase_value, 0) }}</td>
                                        <td class="py-2 px-4 border-b">
    @if($property->getFirstMedia('salesdeed'))
        <a href="{{ route('properties.downloadSalesDeed', $property->id) }}" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
            Download
        </a>
    @else
        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
            Not Available
        </span>
    @endif
</td>
                                        <td class="py-2 px-4 border-b text-right space-x-2">
                                            <!-- Trigger Modal -->
                                            @can('view property')
                                            <a href="javascript:void(0);"
                                               class="text-blue-500 hover:underline"
                                               data-modal-toggle="viewPropertyModal"
                                               onclick="loadModalContent('{{ route('properties.show', $property->id) }}')">View</a>
                                            @endcan

                                            @can('edit property')
                                            <a href="{{ route('properties.edit', $property->id) }}"
                                               class="text-yellow-500 hover:underline">Edit</a>
                                            @endcan
                                            @can('delete property')
                                            <form action="{{ route('properties.destroy', $property->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:underline"
                                                        onclick="return confirm('Are you sure you want to delete this property?')">
                                                    Delete
                                                </button>
                                            </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                                @if($properties->isEmpty())
                                    <tr>
                                        <td colspan="8" class="py-4 text-center text-gray-500">
                                            No properties found.
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $properties->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>


<!-- Flowbite Modal -->
<div id="viewPropertyModal" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 overflow-y-auto" data-modal-target="viewPropertyModal">
    <div class="flex items-center justify-center min-h-screen px-4 text-center">
        <div class="fixed inset-0 transition-opacity bg-gray-200 opacity-100"></div> <!-- Grey Transparent Backdrop -->
        <div class="relative w-full max-w-4xl p-4 mx-auto bg-white rounded-lg shadow-lg">
            <!-- Modal content -->
            <div class="flex items-start justify-between p-2 border-b rounded-t">
                <h3 class="text-xl font-semibold text-gray-600">
                    Property Details
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="viewPropertyModal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10 9a1 1 0 011 1v3a1 1 0 01-2 0V10a1 1 0 011-1z" clip-rule="evenodd"></path>
                        <path d="M4 10a6 6 0 1112 0 6 6 0 01-12 0z"></path>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div id="modalContent" class="p-4 space-y-3">
                <!-- Content will be loaded dynamically -->
            </div>
            <!-- Modal footer -->
            <div class="flex justify-end p-4 border-t">
                <button type="button" class="text-white bg-red-500 hover:bg-red-600 rounded-lg text-sm px-4 py-2 font-medium" data-modal-toggle="viewPropertyModal">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>


<script>
    function loadModalContent(url) {
        const modalContent = document.getElementById('modalContent');
        modalContent.innerHTML = '<div class="text-center">Loading...</div>'; // Show loading message
        fetch(url)
            .then(response => response.text())
            .then(html => {
                modalContent.innerHTML = html;
            })
            .catch(error => {
                console.error('Error loading content:', error);
                modalContent.innerHTML = '<div class="text-red-500">Failed to load content.</div>';
            });
    }

    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('viewPropertyModal');
        const modalToggle = document.querySelector('[data-modal-toggle="viewPropertyModal"]');

        // Function to toggle modal visibility
        function toggleModal() {
            modal.classList.toggle('hidden');
            modal.classList.toggle('flex');
        }

        if (modalToggle) {
            modalToggle.addEventListener('click', toggleModal);
        }

        // Close modal when clicking outside of the modal content
        modal.addEventListener('click', function (event) {
            if (event.target === modal) {
                toggleModal();
            }
        });
    });
    </script>




</x-app-layout>
