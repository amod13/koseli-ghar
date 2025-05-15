<?php

namespace App\Http\Controllers\Site\User;

use App\Http\Controllers\Controller;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use App\Repositories\UserDetailRepo;
use App\Repositories\UserRepo;
use Illuminate\Support\Facades\Hash;

class UserDetailController extends Controller
{
    private $view;
    protected $repo, $userRepo;
    public function __construct(UserDetailRepo $repo,UserRepo $userRepo)
    {
        $this->repo = $repo;
        $this->userRepo = $userRepo;
    }


    /**
     * Update the specified user detail in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function update(Request $request, $id)
    {

        // Validate the request, including the password fields
        $request->validate([
            'first_name' => 'nullable|string',
            'middle_name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'email' => 'nullable|email',
            'password' => 'nullable|min:8|confirmed',
            'old_password' => 'nullable',
            'phone' => 'nullable|numeric|digits:10',
            'designation' => 'nullable|string',
            'website' => 'nullable|string',
            'address' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'facebook' => 'nullable|string',
            'whatsapp' => 'nullable|string',
            'twitter' => 'nullable|string',
            'exclusive_offers' => 'nullable|in:0,1',
            'daily_messages' => 'nullable|in:0,1',
            'weekly_summary' => 'nullable|in:0,1',
        ]);


        // Fetch user using repository
        $user = $this->userRepo->editRecord($id);

        // Check if the user is trying to update the password
        if ($request->filled('old_password') && $request->filled('new_password')) {
            // Verify the old password
            if (!Hash::check($request->old_password, $user->password)) {
                return back()->withErrors(['old_password' => 'The provided old password is incorrect.']);
            }

            // Update password
            $user->update([
                'password' => Hash::make($request->new_password),
            ]);
        }

        // Prepare user details data
        $userDetailData = $request->only([
            'first_name', 'middle_name', 'last_name', 'email', 'phone', 'designation', 'website', 'address', 'facebook',
            'whatsapp', 'twitter', 'exclusive_offers', 'daily_messages', 'weekly_summary', 'image'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageExtension = $image->getClientOriginalExtension();
            $imageFilename = time() . '_profile.' . $imageExtension;

            // Directory for storing user profile images
            $imageDirectory = public_path('uploads/images/user/profile');
            if (!file_exists($imageDirectory)) {
                mkdir($imageDirectory, 0777, true);
            }

            // Move the image to the directory
            $image->move($imageDirectory, $imageFilename);

            // Add the image path to user detail data
            $userDetailData['image'] = $imageFilename;
        }

        // Update or create user details
        UserDetail::updateOrCreate(
            ['user_id' => $id],
            $userDetailData
        );

        return redirect()->route('site.user.profile')->with('success', 'User Detail Updated Successfully');
    }

}
