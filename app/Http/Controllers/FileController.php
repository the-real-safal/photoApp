<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Models\Files;
use Barryvdh\DomPDF\Facade as Pdf;
use ZipArchive;





class FileController extends Controller
{
    public function index()
    {
        $files = Files::all();
        return view('files.index', compact('files'));
    }

    public function displayImages()
    {
            $username = auth()->user()->name;
             $imagesPath = Storage::path('public/assets/' . $username . '/images/');
            $images = File::files($imagesPath);
        
            return view('files.image', compact('images', 'username'));
        }
        
        public function processImages(Request $request)
        {
            // Validate the form submission if needed
    
            $selectedImages = $request->input('selected_images', []);
    
            foreach ($selectedImages as $imageName) {
                // Build the full path to the image
                $imagePath = 'public/assets/' . auth()->user()->name . '/images/' . $imageName;
    
                // Delete the image from storage
                Storage::delete($imagePath);
            }
    
            return redirect()->route('files.image')->with('success', 'Selected images deleted successfully.');
        }

        public function exportSelectedImages(Request $request)
{
    try {
        $selectedImages = $request->input('selected_images', []);
        $zip = new ZipArchive();
        $userName = auth()->user()->name;
        $randomNumber = rand(1000, 9999);
        $file_name = $userName . '_selected_images_' . $randomNumber . '.zip';

        if ($zip->open(public_path($file_name), ZipArchive::CREATE) === true) {
            foreach ($selectedImages as $imageName) {
                $imagePath = public_path('storage/assets/' . $userName . '/images/' . $imageName);

                // Check if the file exists before adding it to the ZIP archive
                if (file_exists($imagePath)) {
                    $relativeName = basename($imagePath);
                    $zip->addFile($imagePath, $relativeName);
                } else {
                    // Log an error or handle the missing file
                    return redirect()->back()->with('error', 'Error creating or downloading ZIP archive. File not found.');
                }
            }

            $zip->close();
            return response()->download(public_path($file_name))->deleteFileAfterSend(true);
        } else {
            return redirect()->back()->with('error', 'Error creating or downloading ZIP archive.');
        }
    } catch (\Exception $e) {
        return redirect()->back()->with('error', $e->getMessage());
    }
}


           


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
         $username = auth()->user()->name;
             $imagesPath = Storage::path('public/assets/' . $username . '/images/');
            $images = File::files($imagesPath);
            return redirect()->route('files.image', compact('images', 'username'));
        // Return a success response
        return response()->json(['message' => 'Images uploaded successfully']);
    } catch (\Exception $e) {
        // Return an error response
        return response()->json(['error' => $e->getMessage()], 500);
    }
}


    


    public function download($id)
    {
        // Implement file download logic here
    }

    public function delete($id)
    {
        // Implement file delete logic here
    }
}



