@extends('admin.layouts.admin')

@section('content')
<div class="container">
    <div class="card mt-4">
        <div class="card-header bg-primary text-white">
            <h6>Edit Review</h6>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <form action="{{ route('admin.reviews.update', $review) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Rating (1-5)</label>
                    <input type="number" name="rating" class="form-control" value="{{ $review->rating }}" min="1" max="5" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Review</label>
                    <textarea name="review" class="form-control">{{ $review->review }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Approval Status</label>
                    <select name="is_approved" class="form-control">
                        <option value="1" {{ $review->is_approved ? 'selected' : '' }}>Approved</option>
                        <option value="0" {{ !$review->is_approved ? 'selected' : '' }}>Pending</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success">Update Review</button>
            </form>
        </div>
    </div>
</div>
@endsection
