<!-- Upload Blade Template -->

@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-2xl font-bold mb-4">Upload Images</h2>

                    <!-- Display uploaded images here -->

                    @if(isset($capturedImages))
                        @foreach($capturedImages as $imageDataURL)
                            <img src="{{ $imageDataURL }}" alt="Captured Image" class="mb-4">
                        @endforeach

                        <!-- Add your upload form or processing logic here -->
                        <form action="{{ route('save.images') }}" method="post">
                            @csrf
                            <input type="hidden" name="capturedImages" value="{{ json_encode($capturedImages) }}">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save Images</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
