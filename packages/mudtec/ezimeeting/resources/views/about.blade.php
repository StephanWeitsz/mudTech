<x-ezim::ezimeeting>

    @section('content')
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

            {{-- Page Header --}}
            <div class="text-center mb-12">
                <h1 class="text-4xl font-extrabold text-gray-900">About Us</h1>
                <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">
                    Learn more about who we are, what we do, and the values that drive us.
                </p>
            </div>

            {{-- Story and Mission --}}
            <div class="grid md:grid-cols-2 gap-12 mb-16">
                <div>
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Our Story</h2>
                    <p class="text-gray-600 leading-relaxed">
                        Since our founding in 20XX, we've grown from a small team with a big dream into a company that's making a meaningful impact in the industry. Our commitment to innovation, quality, and people has been at the heart of everything we do.
                    </p>
                </div>

                <div>
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Our Mission</h2>
                    <p class="text-gray-600 leading-relaxed">
                        Our mission is to build reliable and innovative solutions that empower businesses to grow. We prioritize simplicity, performance, and thoughtful design in every project we undertake.
                    </p>
                </div>
            </div>

            {{-- Meet the Team --}}
            <div class="mb-16">
                <h2 class="text-2xl font-semibold text-gray-800 mb-8 text-center">Meet the Team</h2>
                <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-8">
                    @foreach ([
                        ['name' => 'Jane Doe', 'role' => 'CEO & Founder'],
                        ['name' => 'John Smith', 'role' => 'CTO'],
                        ['name' => 'Alex Johnson', 'role' => 'Lead Developer']
                    ] as $member)
                        <div class="bg-white shadow-md rounded-lg p-6 text-center">
                            <img src="https://via.placeholder.com/100" alt="{{ $member['name'] }}" class="w-24 h-24 mx-auto rounded-full mb-4">
                            <h3 class="text-lg font-bold text-gray-800">{{ $member['name'] }}</h3>
                            <p class="text-sm text-gray-500">{{ $member['role'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Call to Action --}}
            <div class="bg-indigo-600 text-white rounded-lg p-8 text-center">
                <h3 class="text-2xl font-semibold mb-2">Want to work with us?</h3>
                <p class="mb-4">We're always looking to connect with driven, creative individuals and forward-thinking partners.</p>
                <a href=" {{ route('contact') }}" class="inline-block bg-white text-indigo-600 font-semibold px-6 py-3 rounded-full shadow hover:bg-gray-100">
                    Contact Us
                </a>
            </div>
        </div>
    @endsection
</x-ezim::ezimeeting>
