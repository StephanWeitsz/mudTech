<footer class="text-sm space-x-4 flex items-center border-t border-gray-100 flex-wrap justify-center py-4 ">
    <a class="text-gray-500 hover:text-yellow-500" href="">About Us</a>   
    @auth
        <a class="text-gray-500 hover:text-yellow-500" href="">Help</a>
        <a class="text-gray-500 hover:text-yellow-500" href="">Explore</a>
    @else    
        <a class="text-gray-500 hover:text-yellow-500" href="{{ route('login') }}">Login</a>
    @endauth
</footer>