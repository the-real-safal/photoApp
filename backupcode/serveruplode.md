# Image Upload and Storage

## index.blade.php (view where the user captures an image and submits)

```javascript
saveBtn.addEventListener('click', function() {
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
```


## web.php (rout code where system redirect to upload method)
```php
Route::post('/upload', [FileController::class, 'upload']);
```


## FileController.php (where user captured images will be saved and further actin will be performed)
```php
public function upload(Request $request)
{
try {
// Validate the request if needed
$request->validate([
'capturedImages.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
]);

        // Get the authenticated user's name
        $userName = auth()->user()->name;

        // Define the path for the user's folder
        $userFolder = 'public/assets/' . $userName . '/images';

        // Create the folder if it doesn't exist
        if (!Storage::exists($userFolder)) {
            Storage::makeDirectory($userFolder);
        }

        // Process the uploaded images
        if ($request->hasFile('capturedImages')) {
            foreach ($request->file('capturedImages') as $file) {
                // Generate a unique filename
                $filename = uniqid('image_') . '.' . $file->getClientOriginalExtension();

                // Move the file to the user's folder
                $file->storeAs($userFolder, $filename);
            }
        }

        // Return a success response
        return response()->json(['message' => 'Images uploaded successfully']);
    } catch (\Exception $e) {
        // Return an error response
        return response()->json(['error' => $e->getMessage()], 500);
    }

}
```
