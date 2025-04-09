@if(session('info'))
    <div class="bg-ground-blue-100 p-4 mb-2 rounded-md shadow-md">
        <span class='bg-gound-blue-300 text-white'> {{ session('info') }} </span>
    </div>
@endif