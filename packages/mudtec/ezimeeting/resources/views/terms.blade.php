<x-ezim::ezimeeting>
    @section('content')
    <div class="max-w-4xl mx-auto px-4 py-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-6 text-center">Terms & Conditions</h1>

        <div class="space-y-8 text-gray-700 leading-relaxed">
            <section>
                <h2 class="text-2xl font-semibold text-gray-800 mb-2">1. Introduction</h2>
                <p>
                    By accessing and using our services, you agree to comply with the following terms and conditions. Please read them carefully.
                </p>
            </section>

            <section>
                <h2 class="text-2xl font-semibold text-gray-800 mb-2">2. Use of Service</h2>
                <p>
                    You agree to use our platform responsibly and not to engage in any activity that may disrupt or harm the service or other users.
                </p>
            </section>

            <section>
                <h2 class="text-2xl font-semibold text-gray-800 mb-2">3. Intellectual Property</h2>
                <p>
                    All content and materials on this site, including logos, text, and visuals, are protected by copyright and other intellectual property laws.
                </p>
            </section>

            <section>
                <h2 class="text-2xl font-semibold text-gray-800 mb-2">4. Privacy Policy</h2>
                <p>
                    Your privacy is important to us. Please review our <a href="{{ route('privacy') }}" class="text-indigo-600 hover:underline">Privacy Policy</a> to understand how we collect and use your data.
                </p>
            </section>

            <section>
                <h2 class="text-2xl font-semibold text-gray-800 mb-2">5. Modifications</h2>
                <p>
                    We reserve the right to update or change these terms at any time. Continued use of the service after changes constitutes acceptance of those changes.
                </p>
            </section>

            <section>
                <h2 class="text-2xl font-semibold text-gray-800 mb-2">6. Contact</h2>
                <p>
                    If you have any questions about these terms, please <a href="{{ route('contact') }}" class="text-indigo-600 hover:underline">contact us</a>.
                </p>
            </section>
        </div>
    </div>
    @endsection
</x-ezim::ezimeeting>
