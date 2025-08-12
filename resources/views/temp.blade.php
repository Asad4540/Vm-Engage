<!-- Upload Image -->
<div class="mb-3">

    @if($campaign->ad_preview)
        <div class="mt-2">
            <img src="{{ asset('images/ad_preview/' . $campaign->ad_preview) }}" alt="Ad Preview" width="80">
        </div>
    @endif
    <br>

    <label class="form-label fw-semibold">Ad Preview image</label>
    <div class="border rounded-3 px-2 py-1">
        <div class="d-flex align-items-center gap-1 mt-1">
            <i class="bi bi-image fs-6 text-muted"></i><br>
            <p class="text-muted mb-0">Upload Image to Replace</p>
        </div>
        <input type="file" name="ad_preview" id="upload" class="form-control mt-2" accept="image/png, image/jpeg">
    </div>
    <small class="text-muted">Accepted formats: JPG, PNG | Max file size: 5MB | pix :
        40x40</small>

</div>