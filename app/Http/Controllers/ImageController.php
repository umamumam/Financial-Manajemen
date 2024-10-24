<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Reminder;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    // Method to display the page with uploaded images
    public function index()
    {
        // Get all images from the database
        $images = Image::all();

        // Send image data to the view
        $unpaidReminders = Reminder::where('is_paid', false)->get();
        return view('home', compact('images', 'unpaidReminders'));
    }

    public function showImages()
    {
        $images = Image::all(); // Mengambil semua data gambar dari database
        $unpaidReminders = Reminder::where('is_paid', false)->get();
        return view('images.index', compact('images', 'unpaidReminders')); // Mengirim data gambar ke tampilan
    }
    // Method to handle image upload
    public function store(Request $request)
{
    $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $path = $request->file('image')->store('images', 'public');

    return back()->with('success', 'Gambar berhasil diupload!');
}
}
