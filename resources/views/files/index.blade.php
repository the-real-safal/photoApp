<!-- Create Document Blade Template -->

@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-2xl font-bold mb-4">Upload Image</h2>
                    <meta name="csrf-token" content="{{ csrf_token() }}">

                    <!-- Centered Camera Viewport with Border Radius -->
                    <div class="relative flex justify-center items-center border rounded overflow-hidden mb-4">
                        <video id="cameraView" width="640" height="480" autoplay
                            class="border border-gray-300 dark:border-gray-600 rounded"></video>
                    </div>

                    <!-- Capture Button -->
                    <button id="captureBtn" class="mb-4 p-2 bg-blue-500 text-white rounded-md">Capture Image</button>

                    <!-- Captured Images Container -->
                    <div id="capturedImagesContainer" class="flex space-x-4 mb-4"></div>

                    <!-- Save Images Button -->
                    <button id="saveBtn" class="bg-green-500 text-white px-4 py-2 rounded">Save Images</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Include JavaScript to access the camera and handle image capturing -->
    <script>
      document.addEventListener('DOMContentLoaded', function () {
    let camera = document.getElementById('cameraView');
    let captureBtn = document.getElementById('captureBtn');
    let capturedImagesContainer = document.getElementById('capturedImagesContainer');
    let saveBtn = document.getElementById('saveBtn');

    let capturedImages = [];

    navigator.mediaDevices.getUserMedia({
        video: {
            width: 640,
            height: 480
        }
    })
    .then(function (stream) {
        camera.srcObject = stream;
    })
    .catch(function (error) {
        console.error('Error accessing the camera:', error);
    });

    // Capture Button Click Event
    captureBtn.addEventListener('click', function () {
        captureImage();
    });

    saveBtn.addEventListener('click', function () {
        const formData = new FormData();

        capturedImages.forEach((imageDataURL, index) => {
            const blob = dataURLtoBlob(imageDataURL);
            formData.append(`capturedImages[${index}]`, blob, `image_${index}.png`);
        });

        // Include CSRF token in the headers
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

        // Use fetch API to send the form data to the server
        fetch('/upload', {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            // Access the returned message
            console.log(data.message);

            // Redirect to another page after saving images
            window.location.href = '/upload'; // Change the path to your desired route
        })
        .catch(error => {
            console.error('Error sending images to server:', error);
        });
    });

    // Function to convert data URL to Blob
    function dataURLtoBlob(dataURL) {
        const arr = dataURL.split(',');
        const mime = arr[0].match(/:(.*?);/)[1];
        const bstr = atob(arr[1]);
        let n = bstr.length;
        const u8arr = new Uint8Array(n);

        while (n--) {
            u8arr[n] = bstr.charCodeAt(n);
        }

        return new Blob([u8arr], { type: mime });
    }

    function captureImage() {
        const canvas = document.createElement('canvas');
        canvas.width = camera.videoWidth;
        canvas.height = camera.videoHeight;
        const ctx = canvas.getContext('2d');
        ctx.drawImage(camera, 0, 0, canvas.width, canvas.height);
        const imageDataURL = canvas.toDataURL('image/png');

        capturedImages.push(imageDataURL);
        displayCapturedImages();
    }

    function displayCapturedImages() {
        capturedImagesContainer.innerHTML = '';

        capturedImages.forEach((imageDataURL, index) => {
            const imageContainer = document.createElement('div');
            imageContainer.classList.add('relative', 'flex-shrink-0');

            const image = document.createElement('img');
            image.src = imageDataURL;
            image.alt = 'Captured Image';

            const removeBtn = document.createElement('button');
            removeBtn.classList.add('absolute', 'top-2', 'right-2', 'p-2', 'bg-red-500',
                'text-white', 'rounded-full');
            removeBtn.innerText = 'X';
            removeBtn.addEventListener('click', () => removeCapturedImage(index));

            imageContainer.appendChild(image);
            imageContainer.appendChild(removeBtn);
            capturedImagesContainer.appendChild(imageContainer);
        });
    }

    function removeCapturedImage(index) {
        capturedImages.splice(index, 1);
        displayCapturedImages();
    }
});

    </script>
@endsection
