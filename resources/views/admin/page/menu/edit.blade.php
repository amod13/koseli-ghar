@extends('admin.main.app')
@include('alert.message')
@section('content')
    <div class="row">
        <div class="col-xl-12 mx-auto">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            Add Menu
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('menu.index') }}">
                                <span class="back d-flex" style="flex-direction: row-reverse"><span
                                        class="btn btn-light m-1 px-5" style="font-size:13px;"><i
                                            class="fa-solid fa-angles-left"></span></i></span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form class="row g-3" action="{{ route('menu.update', $data['menu']->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="col-md-3 mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" id="title"
                                value="{{ old('title', $data['menu']->title) }}">
                            <span class="text-danger">
                                @error('title')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="url" class="form-label">url</label>
                            <input type="text" name="url" class="form-control" id="url"
                                value="{{ old('url', $data['menu']->url) }}">
                            <span class="text-danger">
                                @error('url')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="parent_id" class="form-label">Parent Menu</label>
                            <select name="parent_id" class="form-control single-select" id="parent_id">
                                <option disabled selected>---Choose Parent Menu---</option>
                                <option value="">None</option>
                                @foreach ($data['parent'] as $parentMenu)
                                    <option value="{{ $parentMenu->id }}"
                                        {{ $data['menu']->parent_id == $parentMenu->id ? 'selected' : '' }}>
                                        {{ $parentMenu->title }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="text-danger">
                                @error('parent_id')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="position" class="form-label">position</label>
                            <input type="text" name="position" class="form-control" id="position"
                                value="{{ old('position', $data['menu']->position) }}">
                            <span class="text-danger">
                                @error('position')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <!-- Submit Button -->
                        <div class="col-12 button_submit">
                            <button type="submit" class="btn btn-primary px-5">Submit</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
