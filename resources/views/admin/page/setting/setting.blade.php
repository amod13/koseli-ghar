@extends('admin.main.app')
@section('content')
    @include('alert.message')

    <!-- Page Title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Site Settings</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Settings</a></li>
                        <li class="breadcrumb-item active">Site Settings</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- End Page Title -->

    <form action="{{ route('setting.update', $data['setting']->id ?? '') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-lg-3">
                <h5 class="fs-16">General Settings</h5>
            </div>
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-lg-6">
                                <label for="site_name" class="form-label">Site Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="site_name" name="site_name"
                                    value="{{ old('site_name', $data['setting']->site_name ?? '') }}">
                            </div>
                            <div class="col-lg-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ old('email', $data['setting']->email ?? '') }}">
                            </div>
                            <div class="col-lg-6">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="number" class="form-control" id="phone" name="phone"
                                    value="{{ old('phone', $data['setting']->phone ?? '') }}">
                            </div>
                            <div class="col-lg-6">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" name="address"
                                    value="{{ old('address', $data['setting']->address ?? '') }}">
                            </div>
                            <div class="col-lg-12">
                                <label for="google_map" class="form-label">Google Map Embed Code</label>
                                <textarea class="form-control" id="google_map" name="google_map" rows="3" placeholder="https://">{{ old('google_map', $data['setting']->google_map ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Social Media Links -->
        <div class="row">
            <div class="col-lg-3">
                <h5 class="fs-16">Social Media Links</h5>
            </div>
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-lg-6">
                                <label for="facebook" class="form-label">Facebook</label>
                                <input type="text" class="form-control" id="facebook" name="facebook"
                                    value="{{ old('facebook', $data['setting']->facebook ?? '') }}" placeholder="https://">
                            </div>
                            <div class="col-lg-6">
                                <label for="twitter" class="form-label">Twitter</label>
                                <input type="text" class="form-control" id="twitter" name="twitter"
                                    value="{{ old('twitter', $data['setting']->twitter ?? '') }}" placeholder="https://">
                            </div>
                            <div class="col-lg-6">
                                <label for="instagram" class="form-label">Instagram</label>
                                <input type="text" class="form-control" id="instagram" name="instagram"
                                    value="{{ old('instagram', $data['setting']->instagram ?? '') }}"
                                    placeholder="https://">
                            </div>
                            <div class="col-lg-6">
                                <label for="youtube" class="form-label">YouTube</label>
                                <input type="text" class="form-control" id="youtube" name="youtube"
                                    value="{{ old('youtube', $data['setting']->youtube ?? '') }}" placeholder="https://">
                            </div>
                            <div class="col-lg-6">
                                <label for="tiktok" class="form-label">TikTok</label>
                                <input type="text" class="form-control" id="tiktok" name="tiktok"
                                    value="{{ old('tiktok', $data['setting']->tiktok ?? '') }}" placeholder="https://">
                            </div>
                            <div class="col-lg-6">
                                <label for="whatsapp" class="form-label">WhatsApp</label>
                                <input type="text" class="form-control" id="whatsapp" name="whatsapp"
                                    value="{{ old('whatsapp', $data['setting']->whatsapp ?? '') }}"
                                    placeholder="https://">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SEO Settings -->
        <div class="row">
            <div class="col-lg-3">
                <h5 class="fs-16">SEO Settings</h5>
            </div>
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-lg-6">
                                <label for="meta_title" class="form-label">Meta Title</label>
                                <input type="text" class="form-control" id="meta_title" name="meta_title"
                                    value="{{ old('meta_title', $data['setting']->meta_title ?? '') }}">
                            </div>
                            <div class="col-lg-6">
                                <label for="meta_tags" class="form-label">Meta Tags</label>
                                <input type="text" class="form-control" id="meta_tags" name="meta_tags"
                                    value="{{ old('meta_tags', $data['setting']->meta_tags ?? '') }}">
                            </div>
                            <div class="col-lg-12">
                                <label for="meta_description" class="form-label">Meta Description</label>
                                <textarea class="form-control" id="meta_description" name="meta_description" rows="3">{{ old('meta_description', $data['setting']->meta_description ?? '') }}</textarea>
                            </div>
                            <div class="col-lg-12">
                                <label for="meta_keywords" class="form-label">Meta Keywords</label>
                                <textarea class="form-control" id="meta_keywords" name="meta_keywords" rows="3">{{ old('meta_keywords', $data['setting']->meta_keywords ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Product Settings -->
        <div class="row">
            <div class="col-lg-3">
                <h5 class="fs-16">Product Setting</h5>
            </div>
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-lg-4">
                                <label for="limit_title" class="form-label">Title Limit</label>
                                <input type="number" class="form-control" id="limit_title" name="limit_title"
                                    value="{{ old('limit_title', $data['setting']->limit_title ?? '') }}">
                            </div>
                            <div class="col-lg-4">
                                <label for="is_display_cart" class="form-label">Display Cart</label>
                                <select name="is_display_cart" id="" class="form-select">
                                    <option value="1"
                                        {{ old('is_display_cart', $data['setting']->is_display_cart ?? '') == 1 ? 'selected' : '' }}>
                                        Yes</option>
                                    <option value="0"
                                        {{ old('is_display_cart', $data['setting']->is_display_cart ?? '') == 0 ? 'selected' : '' }}>
                                        No</option>
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label for="is_display_wishlist" class="form-label">Display Wishlist</label>
                                <select name="is_display_wishlist" id="" class="form-select">
                                    <option value="1"
                                        {{ old('is_display_wishlist', $data['setting']->is_display_wishlist ?? '') == 1 ? 'selected' : '' }}>
                                        Yes</option>
                                    <option value="0"
                                        {{ old('is_display_wishlist', $data['setting']->is_display_wishlist ?? '') == 0 ? 'selected' : '' }}>
                                        No</option>
                                </select>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3">
                <h5 class="fs-16">Brand Setting</h5>
            </div>
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-body">
                        <div class="row g-3">

                            <div class="col-lg-4">
                                <label for="is_display_brand_slider" class="form-label">Display Brand In Slider</label>
                                <select name="is_display_brand_slider" id="" class="form-select">
                                    <option value="1"
                                        {{ old('is_display_brand_slider', $data['setting']->is_display_brand_slider ?? '') == 1 ? 'selected' : '' }}>
                                        Yes</option>
                                    <option value="0"
                                        {{ old('is_display_brand_slider', $data['setting']->is_display_brand_slider ?? '') == 0 ? 'selected' : '' }}>
                                        No</option>
                                </select>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Theme Color Setting --}}
          <div class="row">
            <div class="col-lg-3">
                <h5 class="fs-16">Theme Color Settings</h5>
            </div>
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-lg-6">
                                <label for="Theme Color" class="form-label">Theme Color</label>
                                <input type="color" class="form-control" id="theme_color" name="theme_color"
                                    value="{{ old('theme_color', $data['setting']->theme_color ?? '') }}">
                            </div>
                            <div class="col-lg-6">
                                <label for="Hover Color" class="form-label">Hover Color</label>
                                <input type="color" class="form-control" id="hover_color" name="hover_color"
                                    value="{{ old('hover_color', $data['setting']->hover_color ?? '') }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Logo & Favicon -->
        <div class="row">
            <div class="col-lg-3">
                <h5 class="fs-16">Site Logo & Favicon</h5>
            </div>
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-body">
                        <div class="row g-3">
                            <!-- Site Logo -->
                            <div class="col-lg-4">
                                <label class="form-label">Site Logo</label>
                                <input type="file" class="form-control" name="logo" id="logoInput">
                                <div class="mt-2">
                                    @if (!empty($data['setting']->logo))
                                        <img id="logoPreview"
                                            src="{{ asset('uploads/images/site/' . $data['setting']->logo) }}"
                                            alt="Site Logo" height="50">
                                    @else
                                        <img id="logoPreview" style="display: none;" height="50">
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Favicon</label>
                                <input type="file" class="form-control" name="favicon" id="faviconInput">
                                <div class="mt-2">
                                    @if (!empty($data['setting']->favicon))
                                        <img id="faviconPreview"
                                            src="{{ asset('uploads/images/site/' . $data['setting']->favicon) }}"
                                            alt="Favicon" height="50">
                                    @else
                                        <img id="faviconPreview" style="display: none;" height="50">
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Default Image</label>
                                <input type="file" class="form-control" name="default_image" id="DefaultImage">
                                <div class="mt-2">
                                    @if (!empty($data['setting']->default_image))
                                        <img id="faviconPreview"
                                            src="{{ asset('uploads/images/site/' . $data['setting']->default_image) }}"
                                            alt="Default Image" height="50">
                                    @else
                                        <img id="DefaultImage" style="display: none;" height="50">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="text-end mt-4">
            <button type="submit" class="btn btn-primary">Update Settings</button>
        </div>
    </form>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function previewImage(input, previewID) {
                if (input.files && input.files[0]) {
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById(previewID).src = e.target.result;
                        document.getElementById(previewID).style.display = "block";
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            document.getElementById("logoInput").addEventListener("change", function() {
                previewImage(this, "logoPreview");
            });
            document.getElementById("DefaultImage").addEventListener("change", function() {
                previewImage(this, "DefaultImage");
            });

            document.getElementById("faviconInput").addEventListener("change", function() {
                previewImage(this, "faviconPreview");
            });

            document.getElementById("removeLogo")?.addEventListener("click", function() {
                document.getElementById("logoPreview").style.display = "none";
                document.getElementById("logoInput").value = "";
            });

            document.getElementById("removeFavicon")?.addEventListener("click", function() {
                document.getElementById("faviconPreview").style.display = "none";
                document.getElementById("faviconInput").value = "";
            });
            document.getElementById("removeDefaultImage")?.addEventListener("click", function() {
                document.getElementById("DefaultImage").style.display = "none";
                document.getElementById("DefaultImage").value = "";
            });
        });
    </script>
@endsection
