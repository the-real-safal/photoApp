@extends('layouts.app')

@section('content')
    {{-- <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="post" action="{{ route('process_images') }}">
                        @csrf
                        <div class="flex overflow-x-auto">
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
                            <button type="button" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" onclick="exportSelected()">Export Selected</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}

    <section class="text-gray-400 bg-gray-900 body-font">
        <div class="container px-5 py-24 mx-auto">
          <div class="flex flex-col text-center w-full mb-20">
            <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-white">Master Cleanse Reliac Heirloom</h1>
            <p class="lg:w-2/3 mx-auto leading-relaxed text-base">Whatever cardigan tote bag tumblr hexagon brooklyn asymmetrical gentrify, subway tile poke farm-to-table. Franzen you probably haven't heard of them man bun deep jianbing selfies heirloom.</p>
          </div>
          <div class="flex flex-wrap -m-4">
            <div class="lg:w-1/3 sm:w-1/2 p-4">
                <form method="post" action="{{ route('process_images') }}">
                    @csrf
              <div class="flex relative">
                @foreach ($images as $image)
                <img alt="{{ $image->getFilename() }}" class="absolute inset-0 w-auto h-auto object-cover object-center" src="{{ asset('storage/assets/' . $username . '/images/' . $image->getFilename()) }}">
                <div class="mt-2">
                    <input type="checkbox" name="selected_images[]" value="{{ $image->getFilename() }}"> 
                </div>
              </div>
              @endforeach

            </div>
            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="deleteSelected()">Delete Selected</button>
            <button type="button" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" onclick="exportSelected()">Export Selected</button>
          </div>
        </div>
      </section>

    <script>
        function deleteSelected() {
            // Your export logic here
            alert('Deleting selected images...');
        }
        function exportSelected() {
            // Your export logic here
            alert('Exporting selected images...');
        }
    </script>
@endsection
