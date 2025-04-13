<x-ezim::ezimeeting>
    @section('content')
    <div class="max-w-3xl mx-auto px-4 py-12">
        <div class="text-center mb-10">
            <h1 class="text-4xl font-bold text-gray-900">Contact Us</h1>
            <p class="mt-4 text-lg text-gray-600">Have questions or want to get in touch? We'd love to hear from you.</p>
        </div>

        @if (session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        {{-- Contact Form --}}
        <form action="{{ route('contact.submit') }}" method="POST" class="bg-white shadow-md rounded-lg p-8 space-y-6">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" id="name" required
                    class="block w-full px-3 py-2 text-gray-900 border border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring-blue-300">
                @error('name') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" required
                    class="block w-full px-3 py-2 text-gray-900 border border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring-blue-300">
                @error('email') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                <textarea name="message" id="message" rows="5" required
                    class="block w-full px-3 py-2 text-gray-900 border border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring-blue-300"></textarea>
            </div>

            <div>
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded hover:bg-blue-700">
                    Send Message
                </button>
            </div>
        </form>

        {{-- Optional contact info section --}}
        <div class="mt-12 text-center text-gray-600 text-sm">
            Or reach us at <a href="mailto:support@example.com" class="text-indigo-600 font-medium hover:underline">support@example.com</a>
        </div>
    </div>
    @endsection
</x-ezim::ezimeeting>
