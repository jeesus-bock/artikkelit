<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\Image;

class ImageController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function upload(): Response
    {
        return Inertia::render('Images/Upload');
        
    }
    public function index(): Response
    {
        $images = Image::all();
        foreach($images as $image) {
            $image->user;
        }
        return Inertia::render('Images/All', [ 'images' => $images ]);
        
    }
    public function ownindex(Request $request): Response
    {
        $images = Image::where('user_id', $request->user()->id)->get();
        foreach($images as $image) {
            $image->user;
        }
        return Inertia::render('Images/Own', [ 'images' => $images ]);
        
    }
    public function store(Request $request): RedirectResponse
    {   
        $manager = new ImageManager(new Driver());
        $validated = $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:92048',
            'desc' => 'string'
        ]);
        error_log($request->hasFile('image'));
        $image = $request->file('image');
        $imageName = time().'.'.$image->extension();
       
        $destinationPathThumbnail = public_path('/thumbnail');
        if (!file_exists( $destinationPathThumbnail)) {
            mkdir( $destinationPathThumbnail, 755, true);
        }
        $img = $manager->read($image->path());
        $imgwidth = $img->width();
        $imgheight = $img->height();
        
        $img->resize(100, 100, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPathThumbnail.'/'.$imageName);
     
        $destinationPath = public_path('/imgs');
        if (!file_exists( $destinationPath)) {
            mkdir( $destinationPath, 755, true);
        }
        $image->move($destinationPath, $imageName);
        error_log($request->input('desc').'-'.$request->user()->id);
        Image::create(['desc' => $request->input('desc'), 'filename' => $imageName, 'user_id' => $request->user()->id, 'width' => $imgwidth, 'height' => $imgheight]);
     
        return back()
            ->with('success','Kuva ladattu onnistuneesti')
            ->with('imageName',$imageName);
    }
}