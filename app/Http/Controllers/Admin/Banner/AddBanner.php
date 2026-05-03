<?php

namespace App\Http\Controllers\Admin\Banner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Admin_Panel\Banner;
use App\Models\Admin_Panel\Gallery;
use App\Models\Admin_Panel\GadgetGallery;
use App\Models\Admin_Panel\StoreImage;
use App\Models\Admin_Panel\EventBanner;
use App\Models\Admin_Panel\AdsBanner;
use App\Models\Admin_Panel\HomeHeading;

class AddBanner extends Controller
{
    public function add_banner(){
        return view('admin_pages.banner.add_banner');
    }

    public function banner_list(){
        $banners=Banner::paginate(20);
        // return $banners;
        return view('admin_pages.banner.banner_list',compact('banners'));
    }

    public function new_banner_added(Request $req){
        if($req->banner_name!='mainslider'){
            DB::table('banners')->where('banner_name', '=', $req->banner_name)->delete();
        }
        $folderName = public_path('assets/banner_images/'); // Use $vendor_id[0] to get the ID as an integer.

        if ($req->hasFile('banner_image')) {
            $image = $req->file('banner_image');
            $imageName = uniqid() . '.' . $image->getClientOriginalName();
            $image->move($folderName, $imageName);

            $user = new Banner;
            $user->banner_name	 = $req->banner_name;
            $user->banner_image = 'assets/banner_images/' . $imageName; // Update the image path.
            $result = $user->save();

            if ($result) {
                toastr()->success('Banner Added Successfully!');
                return redirect('banner_list');
            } else {
                toastr()->error('Banner Adding Failed!');
                return redirect('banner_list');
            }
        } else {
            toastr()->error('Image Not Found!');
            return redirect('banner_list');
        }
        return $req->input();
    }
    
    public function update_events_banner_gallery_submit(Request $req){
        $gallery_details=EventBanner::where('event_banner_id',$req->gallery_id)->get();      
        $folderName = public_path('assets/events_banner_images/'); // Use $vendor_id[0] to get the ID as an integer.

        if ($req->hasFile('gallery_image')) {
            $image = $req->file('gallery_image');
            $imageName = uniqid() . '.' . $image->getClientOriginalName();
            $image->move($folderName, $imageName);

            $gallery = EventBanner::find($gallery_details[0]->event_banner_id);
            // return $gallery;
            $gallery->event_banner_image = 'assets/events_banner_images/' . $imageName; // Update the image path.
            $result = $gallery->save();
            toastr()->success('Events Banner Updated Successfully!');
            return redirect()->route('events_banner');
        }else{
            toastr()->success('Events Banner Updated Successfully!');
            return redirect()->route('events_banner');
        }
    }

    public function update_bannner($banner_id){
        $banner_details=Banner::where('banner_id',$banner_id)->get();
        // return $banner_details[0]->banner_name;
        return view('admin_pages.banner.update_banner',compact('banner_details'));
    }
    
    public function events_banner(){
        $events_banner=EventBanner::paginate(20);
        return view('admin_pages.gallery.events_banner_list',compact('events_banner'));
        // return $events_banner;
    }
    
    public function update_eventsbanner_gallery($gallery_id){
        $gallery_details=EventBanner::where('event_banner_id',$gallery_id)->get();
        return view('admin_pages.gallery.update_eventsbanner_gallery',compact('gallery_details'));
        // return $gallery_details;
    }
    
    public function new_events_banner_image_added(Request $req){
        $folderName = public_path('assets/events_banner_images/'); // Use $vendor_id[0] to get the ID as an integer.

        if ($req->hasFile('gallery_image')) {
            $image = $req->file('gallery_image');
            $imageName = uniqid() . '.' . $image->getClientOriginalName();
            $image->move($folderName, $imageName);

            $user = new EventBanner;
            $user->event_banner_name = $req->gallery_name;
            $user->event_banner_image = 'assets/events_banner_images/' . $imageName; // Update the image path.
            $result = $user->save();

            if ($result) {
                toastr()->success('Events Banner Image Added Successfully!');
                return redirect('events_banner');
            } else {
                toastr()->error('Events Banner Image Adding Failed!');
                return redirect('events_banner');
            }
        } else {
            toastr()->error('Image Not Found!');
            return redirect('events_banner');
        }
    }

    public function update_banner(Request $req){
        
        $banner_details=Banner::where('banner_id',$req->banner_id)->get();
        $folderName = public_path('assets/banner_images/'); // Use $vendor_id[0] to get the ID as an integer.
        $banner = Banner::find($banner_details[0]->banner_id);
        $banner->banner_url=$req->banner_url;
        if ($req->hasFile('banner_image')) {
            $image = $req->file('banner_image');
            $imageName = uniqid() . '.' . $image->getClientOriginalName();
            $image->move($folderName, $imageName);

            // $banner = Banner::find($banner_details[0]->banner_id);
            $banner->banner_image = 'assets/banner_images/' . $imageName; // Update the image path.
            $result = $banner->save();
            toastr()->success('Banner Updated Successfully!');
            return redirect()->route('banner_list');
        }else{
            $result = $banner->save();
            toastr()->success('Banner Updated Successfully!');
            return redirect()->route('banner_list');
        }
    }

    public function add_gallery(){
        return view('admin_pages.gallery.add_gallery');
    }
    
    public function add_events_banner(){
        return view('admin_pages.gallery.add_events_banner');
    }

    public function add_gadget_gallery(){
        return view('admin_pages.gallery.add_gadget_gallery');
    }

    public function add_store_image(){
        return view('admin_pages.gallery.add_store_image');
    }

    public function add_ads_banner(){
        return view('admin_pages.gallery.add_ads_banner');
    }
    
    public function home_heading_name(){
        return view('admin_pages.gallery.home_heading_name');
    }

    public function new_gallery_added(Request $req){
        $folderName = public_path('assets/galley_images/'); // Use $vendor_id[0] to get the ID as an integer.

        if ($req->hasFile('gallery_image')) {
            $image = $req->file('gallery_image');
            $imageName = uniqid() . '.' . $image->getClientOriginalName();
            $image->move($folderName, $imageName);

            $user = new Gallery;
            $user->gallery_name	 = $req->gallery_name;
            $user->gallery_image = 'assets/galley_images/' . $imageName; // Update the image path.
            $result = $user->save();

            if ($result) {
                toastr()->success('Gallery Image Added Successfully!');
                return redirect('gallery_list');
            } else {
                toastr()->error('Gallery Image Adding Failed!');
                return redirect('gallery_list');
            }
        } else {
            toastr()->error('Image Not Found!');
            return redirect('gallery_list');
        }
    }


    public function new_gadget_gallery_added(Request $req){
        $folderName = public_path('assets/gadget_gallery_images/'); // Use $vendor_id[0] to get the ID as an integer.

        if ($req->hasFile('gallery_image')) {
            $image = $req->file('gallery_image');
            $imageName = uniqid() . '.' . $image->getClientOriginalName();
            $image->move($folderName, $imageName);

            $user = new GadgetGallery;
            $user->gadget_gallery_name	 = $req->gallery_name;
            $user->gadget_gallery_image = 'assets/gadget_gallery_images/' . $imageName; // Update the image path.
            $result = $user->save();

            if ($result) {
                toastr()->success('Gallery Image Added Successfully!');
                return redirect('gadget_gallery_list');
            } else {
                toastr()->error('Gallery Image Adding Failed!');
                return redirect('gadget_gallery_list');
            }
        } else {
            toastr()->error('Image Not Found!');
            return redirect('gadget_gallery_list');
        }
    }


    public function new_store_image_added(Request $req){
        $folderName = public_path('assets/store_images/'); // Use $vendor_id[0] to get the ID as an integer.

        if ($req->hasFile('gallery_image')) {
            $image = $req->file('gallery_image');
            $imageName = uniqid() . '.' . $image->getClientOriginalName();
            $image->move($folderName, $imageName);

            $user = new StoreImage;
            $user->store_name = $req->gallery_name;
            $user->store_image = 'assets/store_images/' . $imageName; // Update the image path.
            $result = $user->save();

            if ($result) {
                toastr()->success('Gallery Image Added Successfully!');
                return redirect('store_images_list');
            } else {
                toastr()->error('Gallery Image Adding Failed!');
                return redirect('store_images_list');
            }
        } else {
            toastr()->error('Image Not Found!');
            return redirect('store_images_list');
        }
    }


    public function new_ads_banner_image_added(Request $req){
        $folderName = public_path('assets/galley_images/'); // Use $vendor_id[0] to get the ID as an integer.

        if ($req->hasFile('gallery_image')) {
            $image = $req->file('gallery_image');
            $imageName = uniqid() . '.' . $image->getClientOriginalName();
            $image->move($folderName, $imageName);

            $user = new AdsBanner;
            $user->ads_banner_name = $req->gallery_name;
            $user->ads_banner_image = 'assets/galley_images/' . $imageName; // Update the image path.
            $result = $user->save();

            if ($result) {
                toastr()->success('Ads Banner Image Added Successfully!');
                return redirect('ads_banner');
            } else {
                toastr()->error('Ads Banner Image Adding Failed!');
                return redirect('ads_banner');
            }
        } else {
            toastr()->error('Image Not Found!');
            return redirect('ads_banner');
        }
    }

    public function new_home_heading_add(Request $req){
        $home_heading=new HomeHeading();
        $home_heading->home_page_name=$req->gallery_name;
        $home_heading->heading=$req->homeheading;
        $home_heading->save();
        toastr()->success('New Heading Added!');
        return redirect()->route('home_heading_list');
    }

    public function gallery_list(){
        $gallery_detail=Gallery::paginate(20);
        // return $gallery_images;
        return view('admin_pages.gallery.gallery_list',compact('gallery_detail'));
    }


    public function gadget_gallery_list(){
        $gallery_detail=GadgetGallery::paginate(20);
        // return $gallery_images;
        return view('admin_pages.gallery.gadget_gallery_list',compact('gallery_detail'));
    }

    public function ads_banner(){
        $ads_banner=AdsBanner::paginate(20);
        // return $ads_banner;
        return view('admin_pages.gallery.ads_banner_list',compact('ads_banner'));

    }

    public function home_heading_list(){
        $ads_banner=HomeHeading::paginate(20);
        // return $ads_banner;
        return view('admin_pages.gallery.home_heading_list',compact('ads_banner'));

    }

    public function store_images_list(){
        $gallery_detail=StoreImage::paginate(20);
        // return $gallery_images;
        return view('admin_pages.gallery.store_images_list',compact('gallery_detail'));
    }


    public function ads_banner_list(){
        // $gallery_detail=AdsBanner::paginate(20);
        return "Ads Banner List";
        return view('admin_pages.gallery.ads_banner_list',compact('gallery_detail'));
    }


    public function update_gallery($gallery_id){
        $gallery_details=Gallery::where('gallery_id',$gallery_id)->get();
        // return $gallery_details;
        return view('admin_pages.gallery.update_gallery',compact('gallery_details'));
    }

    public function update_gadget_gallery($gallery_id){
        $gallery_details=GadgetGallery::where('gadget_gallery_id',$gallery_id)->get();
        // return $gallery_details;
        return view('admin_pages.gallery.update_gadget_gallery',compact('gallery_details'));
    }

    public function update_store_gallery($gallery_id){
        $gallery_details=StoreImage::where('store_id',$gallery_id)->get();
        // return $gallery_details;
        return view('admin_pages.gallery.update_store_gallery',compact('gallery_details'));
    }

    public function update_adsbanner_gallery($gallery_id){
        $gallery_details=AdsBanner::where('ads_banner_id',$gallery_id)->get();
        // return $gallery_details;
        return view('admin_pages.gallery.update_adsbanner_gallery',compact('gallery_details'));
    }


    public function update_heading_name($heading_id){
        $gallery_details=HomeHeading::where('id',$heading_id)->get();
        // return $gallery_details;
        return view('admin_pages.gallery.update_home_heading_name',compact('gallery_details'));
    }

    public function update_gallery_submit(Request $req){
        $gallery_details=Gallery::where('gallery_id',$req->gallery_id)->get();
        $folderName = public_path('assets/galley_images/'); // Use $vendor_id[0] to get the ID as an integer.

        if ($req->hasFile('gallery_image')) {
            $image = $req->file('gallery_image');
            $imageName = uniqid() . '.' . $image->getClientOriginalName();
            $image->move($folderName, $imageName);

            $gallery = Gallery::find($gallery_details[0]->gallery_id);
            $gallery->gallery_image = 'assets/galley_images/' . $imageName; // Update the image path.
            $result = $gallery->save();
            toastr()->success('Gallery Updated Successfully!');
            return redirect()->route('gallery_list');
        }else{
            toastr()->success('Gallery Updated Successfully!');
            return redirect()->route('gallery_list');
        }
    }


    public function update_gadget_gallery_submit(Request $req){
        $gallery_details=GadgetGallery::where('gadget_gallery_id',$req->gallery_id)->get();
        $folderName = public_path('assets/gadget_gallery_images/'); // Use $vendor_id[0] to get the ID as an integer.
        $gallery = GadgetGallery::find($gallery_details[0]->gadget_gallery_id);
        $gallery->gadget_gallery_url=$req->banner_url;
        if ($req->hasFile('gallery_image')) {
            $image = $req->file('gallery_image');
            $imageName = uniqid() . '.' . $image->getClientOriginalName();
            $image->move($folderName, $imageName);

            // $gallery = GadgetGallery::find($gallery_details[0]->gadget_gallery_id);
            $gallery->gadget_gallery_image = 'assets/gadget_gallery_images/' . $imageName; // Update the image path.
            $result = $gallery->save();
            toastr()->success('Gallery Updated Successfully!');
            return redirect()->route('gadget_gallery_list');
        }else{
            $result = $gallery->save();
            toastr()->success('Gallery Updated Successfully!');
            return redirect()->route('gadget_gallery_list');
        }
    }

    public function update_store_gallery_submit(Request $req){
        $gallery_details=StoreImage::where('store_id',$req->gallery_id)->get();
        $folderName = public_path('assets/store_images/'); // Use $vendor_id[0] to get the ID as an integer.

        if ($req->hasFile('gallery_image')) {
            $image = $req->file('gallery_image');
            $imageName = uniqid() . '.' . $image->getClientOriginalName();
            $image->move($folderName, $imageName);

            $gallery = StoreImage::find($gallery_details[0]->store_id);
            $gallery->store_image = 'assets/store_images/' . $imageName; // Update the image path.
            $result = $gallery->save();
            toastr()->success('Gallery Updated Successfully!');
            return redirect()->route('store_images_list');
        }else{
            toastr()->success('Gallery Updated Successfully!');
            return redirect()->route('store_images_list');
        }
    }

    public function update_ads_banner_gallery_submit(Request $req){
        $gallery_details=AdsBanner::where('ads_banner_id',$req->gallery_id)->get();
        $folderName = public_path('assets/galley_images/'); // Use $vendor_id[0] to get the ID as an integer.
        $gallery = AdsBanner::find($gallery_details[0]->ads_banner_id);
        $gallery->ads_banner_url=$req->banner_url;
        if ($req->hasFile('gallery_image')) {
            $image = $req->file('gallery_image');
            $imageName = uniqid() . '.' . $image->getClientOriginalName();
            $image->move($folderName, $imageName);

            // $gallery = AdsBanner::find($gallery_details[0]->ads_banner_id);
            // return $gallery;
            $gallery->ads_banner_image = 'assets/galley_images/' . $imageName; // Update the image path.
            $result = $gallery->save();
            toastr()->success('Ads Banner Updated Successfully!');
            return redirect()->route('ads_banner');
        }else{
            $result = $gallery->save();
            toastr()->success('Ads Banner Updated Successfully!');
            return redirect()->route('ads_banner');
        }
    }

    public function update_home_heading_submit(Request $req){
        // return $req->input();
        $home_heading=HomeHeading::find($req->gallery_id);
        $home_heading->heading=$req->heading_name;
        $home_heading->save();
        toastr()->success('Heading Updated Successfully!');
        return redirect()->route('home_heading_list');
    }
}
