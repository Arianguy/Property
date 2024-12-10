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
                                            @can('view tenants')
                                            <a href="javascript:void(0);"
                                               class="text-blue-500 hover:underline"
                                               id="openModal"
                                               onclick="loadModalContent('{{ route('tenants.show', $tenant->id) }}')">View</a>
                                            @endcan

                                            @can('edit tenants')
                                            <a href="{{ route('tenants.edit', $tenant->id) }}"
                                               class="text-yellow-500 hover:underline">Edit</a>
                                            @endcan

                                            @can('delete tenants')
                                            <form action="{{ route('tenants.destroy', $tenant->id) }}" method="POST" class="inline-block" id="deleteForm-{{ $tenant->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="text-red-500 hover:underline" onclick="openDeleteModal('{{ $tenant->id }}')">
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

    <!-- Simple Modal -->
    <div id="myModal" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close" style="cursor: pointer;">&times;</span>
            <h2>Tenant Details</h2>
            <div id="modalContent">
                <!-- Content will be loaded dynamically -->
            </div>
            <button id="closeModal" style="padding: 10px 20px; background-color: #dc3545; color: white; border: none; border-radius: 5px; cursor: pointer;">Close</button>
        </div>
    </div>

    <style>
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1000; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgba(0, 0, 0, 0.5); /* Black w/ opacity */
            justify-content: center; /* Center modal horizontally */
            align-items: center; /* Center modal vertically */
            display: flex; /* Use flex to center */
        }
        .modal-content {
            background-color: #fff; /* White background */
            margin: auto; /* Center the modal */
            padding: 20px; /* Some padding */
            border: 1px solid #888; /* Gray border */
            width: 80%; /* Could be more or less, depending on screen size */
            max-width: 700px; /* Max width */
            border-radius: 8px; /* Rounded corners */
        }
        .close {
            color: #aaa; /* Gray color */
            float: right; /* Float to the right */
            font-size: 28px; /* Large font size */
            font-weight: bold; /* Bold text */
        }
        .close:hover,
        .close:focus {
            color: black; /* Change color on hover */
            text-decoration: none; /* No underline */
            cursor: pointer; /* Pointer cursor */
        }
    </style>

    <script>
        // Get the modal
        var modal = document.getElementById("myModal");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // Get the close button
        document.getElementById("closeModal").onclick = function() {
            modal.style.display = "none";
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        function loadModalContent(url) {
            console.log("Loading URL:", url); // Log the URL
            const modalContent = document.getElementById('modalContent');
            modalContent.innerHTML = '<div class="text-center">Loading...</div>'; // Show loading message
            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.text();
                })
                .then(html => {
                    modalContent.innerHTML = html;
                    modal.style.display = "flex"; // Show the modal
                })
                .catch(error => {
                    console.error('Error loading content:', error);
                    modalContent.innerHTML = '<div class="text-red-500">Failed to load content.</div>';
                });
        }

        // Open modal when the "View" link is clicked
        document.querySelectorAll('[id="openModal"]').forEach(button => {
            button.addEventListener('click', function() {
                modal.style.display = "flex"; // Show the modal
            });
        });

        function openDeleteModal(tenantId) {
            const confirmation = confirm("Are you sure you want to delete this tenant?");
            if (confirmation) {
                document.getElementById('deleteForm-' + tenantId).submit(); // Submit the form to delete
            }
        }
    </script>

</x-app-layout>
