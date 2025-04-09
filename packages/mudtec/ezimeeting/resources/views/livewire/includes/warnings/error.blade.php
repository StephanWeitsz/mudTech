@if(session('error'))
    <div class="bg-red-100 p-4 mb-2 rounded-md shadow-md">
        <span class='text-yellow'> {{ session('error') }} </span>
    </div>
@endif