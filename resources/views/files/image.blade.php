@extends('layouts.app')

@section('content')
<style>
    .image-container {
        overflow: hidden;
    }

    .image-container:hover {
        overflow: auto;
    }
    ::-webkit-scrollbar {
        width: 5px;
    }

    ::-webkit-scrollbar-track {
        background: #ffffff00;
    }

    ::-webkit-scrollbar-thumb {
        background-color: #8c6dff;
        border-radius: 6px;
    }

    /* For Firefox */
    /* scrollbar-width: thin;
    scrollbar-color: #888 #f1f1f1; */
</style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="post" action="{{ route('process_images') }}">
                        @csrf
                        <div class="flex image-container">
                            @foreach ($images as $image)
                                <div class="m-2" style="flex: 0 0 calc(25% - 1rem); box-sizing: border-box;">
                                    <img src="{{ asset('storage/assets/' . $username . '/images/' . $image->getFilename()) }}" alt="{{ $image->getFilename() }}" class="w-full h-auto">
                                    <div class="mt-2">
                                        <input type="checkbox" name="selected_images[]" value="{{ $image->getFilename() }}"> Delete
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="deleteSelected()">Delete Selected</button>
                            <button type="submit" class="bg-yellow-700 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded" formaction="{{ route('export_selected_images') }}">Export Selected</button>
                        </div>
                    </form>
                    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

                </div>
            </div>
        </div>
    </div>
    <script>
        function deleteSelected() {
            // Your delete logic here
            alert('Deleting selected images...');
        }

        function exportSelected() {
            // Your export logic here
            alert('Exporting selected images...');
        }
    </script>
@endsection
