<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tenants') }}
            </h2>
            @can('create tenants')
    <a href="{{ route('tenants.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded inline-flex items-center">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Add Tenant
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
                                    <th class="py-2 px-4 border-b">First Name</th>
                                    <th class="py-2 px-4 border-b">Emirates ID</th>
                                    <th class="py-2 px-4 border-b">Nationality</th>
                                    <th class="py-2 px-4 border-b">Email</th>
                                    <th class="py-2 px-4 border-b">Mobile</th>
                                    <th class="py-2 px-4 border-b">Visa</th>
                                    <th class="py-2 px-4 border-b">Passport No</th>
                                    <th class="py-2 px-4 border-b text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tenants as $tenant)
                                    <tr class="text-gray-700 text-sm hover:bg-gray-50">
                                        <td class="py-2 px-4 border-b">{{ $loop->iteration }}</td>
                                        <td class="py-2 px-4 border-b">{{ $tenant->fname }}</td>
                                        <td class="py-2 px-4 border-b">{{ $tenant->eid }}</td>
                                        <td class="py-2 px-4 border-b">{{ $tenant->nationality }}</td>
                                        <td class="py-2 px-4 border-b">{{ $tenant->email }}</td>
                                        <td class="py-2 px-4 border-b">{{ $tenant->mobile }}</td>
                                        <td class="py-2 px-4 border-b">{{ $tenant->visa }}</td>
                                        <td class="py-2 px-4 border-b">{{ $tenant->passportno }}</td>
                                        <td class="py-2 px-4 border-b text-right space-x-2">
                                            <!-- Trigger Modal -->
                                            @can('view tenant')
                                            <a href="javascript:void(0);"
                                               class="text-blue-500 hover:underline"
                                               data-modal-toggle="viewPropertyModal"
                                               onclick="loadModalContent('{{ route('tenants.show', $tenant->id) }}')">View</a>
                                            @endcan

                                            @can('edit tenant')
                                            <a href="{{ route('tenants.edit', $tenant->id) }}"
                                               class="text-yellow-500 hover:underline">Edit</a>
                                            @endcan
                                            @can('delete tenant')
                                            <form action="{{ route('tenants.destroy', $tenant->id) }}" method="POST" class="inline-block">
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
                                @if($tenants->isEmpty())
                                    <tr>
                                        <td colspan="8" class="py-4 text-center text-gray-500">
                                            No Tenants found.
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $tenants->links() }}
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
