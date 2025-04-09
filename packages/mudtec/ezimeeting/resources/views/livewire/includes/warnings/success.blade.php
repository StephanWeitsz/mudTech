@if(session('success'))
    <div class="bg-green-100 p-4 mb-2 rounded-md shadow-md">
        <span class='text-green-800'> {{ session('success') }} </span>
    </div>
@endif