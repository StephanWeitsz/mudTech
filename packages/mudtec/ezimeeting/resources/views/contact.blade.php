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

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" id="name" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div>
                <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                <textarea name="message" id="message" rows="5" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
            </div>

            <div>
                <button type="submit"
                    class="w-full bg-indigo-600 text-white py-3 px-6 rounded-md font-semibold hover:bg-indigo-700 transition">
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
