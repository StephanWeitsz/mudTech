@if(session('danger'))
    <div class="bg-red-100 p-4 mb-2 rounded-md shadow-md">
        <span class='bg-ground-red-400 text-yellow-200'> {{ session('danger') }} </span>
    </div>
@endif