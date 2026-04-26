<x-app-layout>
    <div x-data="{ 
            isModalOpen: false, 
            isRegisterModalOpen: {{ $errors->any() ? 'true' : 'false' }}, 
            selectedFarmer: null 
         }"
         @open-register-modal.window="isRegisterModalOpen = true">

        <x-slot name="header">
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Farmer Directory') }}
                </h2>
                
                <div class="flex space-x-2">
                    <a href="{{ route('admin.farmers.map') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 transition shadow-sm">
                        View Map
                    </a>
                    <a href="{{ route('admin.farmers.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition shadow-sm">
                        + Register Farmer
                    </a>
                </div>
            </div>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                
                @if (session('success'))
                    <div class="mb-4 bg-green-50 border border-green-200 text-green-700 p-4 rounded-md shadow-sm text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="bg-white shadow-sm ring-1 ring-gray-200 sm:rounded-lg relative">
                    
                    <div class="px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4">
                        <form method="GET" action="{{ route('admin.farmers.index') }}" class="flex items-center space-x-2 w-full sm:w-auto">
                            <input type="hidden" name="per_page" value="{{ $perPage }}">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </div>
                                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search name or email..." class="pl-9 pr-4 py-2 border-gray-300 rounded-md shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500 w-full sm:w-64">
                            </div>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-medium text-gray-700 text-sm hover:bg-gray-50 shadow-sm transition">
                                Search
                            </button>
                        </form>

                        <div class="flex items-center space-x-2 w-full sm:w-auto justify-end">
                            <form method="GET" action="{{ route('admin.farmers.index') }}">
                                @if(!empty($search))
                                    <input type="hidden" name="search" value="{{ $search }}">
                                @endif
                                <select name="per_page" onchange="this.form.submit()" class="border-gray-300 rounded-md shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500 py-2 pl-3 pr-8 bg-white cursor-pointer hover:bg-gray-50">
                                    <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                                    <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                                </select>
                            </form>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-widest">Date Joined</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-widest">Farmer Details</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-widest">Account Status</th>
                                    <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-widest">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse ($farmers as $farmer)
                                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $farmer->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-xs uppercase">
                                                    {{ substr($farmer->name, 0, 1) }}
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ $farmer->name }}</div>
                                                    <div class="text-sm text-gray-500">{{ $farmer->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Active</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <button type="button" 
                                                    @click="selectedFarmer = { 
                                                        name: '{{ addslashes($farmer->name) }}', 
                                                        email: '{{ addslashes($farmer->email) }}', 
                                                        phone: '{{ $farmer->phone ?? 'Not provided' }}',
                                                        joined: '{{ $farmer->created_at->format('M d, Y') }}' 
                                                    }; isModalOpen = true" 
                                                    class="text-indigo-600 hover:text-indigo-900 mr-3">View</button>
                                            <form action="{{ route('admin.farmers.destroy', $farmer->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to permanently delete this farmer? This action cannot be undone.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 transition">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="px-6 py-12 text-center text-gray-500">No farmers found.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="px-6 py-4 border-t border-gray-100">{{ $farmers->links() }}</div>

                    <div x-show="isRegisterModalOpen" 
                         x-transition
                         style="display: none;" 
                         class="fixed inset-0 z-[100] overflow-y-auto">
                        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="isRegisterModalOpen = false"></div>
                        <div class="flex min-h-full items-center justify-center p-4">
                            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:w-full sm:max-w-md p-8">
                                <h3 class="text-lg font-bold text-gray-900 mb-6">Register New Farmer</h3>
                                <form method="POST" action="{{ route('admin.farmers.store') }}" class="space-y-5">
                                    @csrf
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                                        <input type="text" name="name" value="{{ old('name') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                        <input type="email" name="email" value="{{ old('email') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                        <input type="text" name="phone" value="{{ old('phone') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                                        <input type="password" name="password" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                        @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                                        <input type="password" name="password_confirmation" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                    </div>
                                    <div class="flex items-center justify-end space-x-3 pt-4">
                                        <button type="button" @click="isRegisterModalOpen = false" class="text-sm font-medium text-gray-600 hover:text-gray-900">Cancel</button>
                                        <button type="submit" class="px-6 py-2 bg-gray-900 text-white rounded-md font-bold text-xs uppercase tracking-widest hover:bg-gray-800 transition">Register</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div x-show="isModalOpen" 
                         x-transition
                         style="display: none;" 
                         class="fixed inset-0 z-[100] overflow-y-auto">
                        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="isModalOpen = false"></div>
                        <div class="flex min-h-full items-center justify-center p-4">
                            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:w-full sm:max-w-md">
                                <div class="bg-white px-6 py-6">
                                    <div class="flex items-center space-x-4 mb-6">
                                        <div class="h-12 w-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600">
                                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        </div>
                                        <h3 class="text-lg font-bold text-gray-900">Farmer Profile</h3>
                                    </div>
                                    <div class="space-y-4">
                                        <div class="flex justify-between border-b border-gray-50 pb-2">
                                            <span class="text-sm text-gray-500">Name</span>
                                            <span class="text-sm font-bold text-gray-900" x-text="selectedFarmer?.name"></span>
                                        </div>
                                        <div class="flex justify-between border-b border-gray-50 pb-2">
                                            <span class="text-sm text-gray-500">Email</span>
                                            <span class="text-sm text-gray-900" x-text="selectedFarmer?.email"></span>
                                        </div>
                                        <div class="flex justify-between border-b border-gray-50 pb-2">
                                            <span class="text-sm text-gray-500">Phone</span>
                                            <span class="text-sm text-gray-900" x-text="selectedFarmer?.phone"></span>
                                        </div>
                                        <div class="flex justify-between pb-2">
                                            <span class="text-sm text-gray-500">Joined</span>
                                            <span class="text-sm text-gray-900" x-text="selectedFarmer?.joined"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-6 py-3 text-right">
                                    <button type="button" @click="isModalOpen = false" class="text-sm font-semibold text-gray-900 px-4 py-2 border border-gray-300 rounded-md bg-white hover:bg-gray-50">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>