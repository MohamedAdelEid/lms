@include('partials.admin.header',['title'=>'Add Lecture'])
@include('partials.admin.aside')
@include('partials.admin.nav')

<div class="container-fluid bg-secondary-dark pb-7">
    <div class="container-fluid">
        <div class="card bg-primary-dark">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-3 text-mode">Add Lecture</h5>
                <hr>
                
                <!-- Success/Error Messages -->
                @if (session('success'))
                    <div class="alert alert-success" id="success">
                        {{ session('success') }}
                    </div>
                    <script>
                        $(document).ready(function() {
                            setTimeout(function() {
                                $('#success').fadeOut();
                            }, 3000);
                        });
                    </script>
                @endif
                
                @if (session('error'))
                    <div class="alert alert-danger" id="error">
                        {{ session('error') }}
                    </div>
                    <script>
                        $(document).ready(function() {
                            setTimeout(function() {
                                $('#error').fadeOut();
                            }, 3000);
                        });
                    </script>
                @endif

                <!-- Upload Status Messages -->
                <div id="upload-messages" style="display: none;">
                    <div id="upload-success" class="alert alert-success" style="display: none;">
                        <i class="fas fa-check-circle"></i> <span id="success-message"></span>
                    </div>
                    <div id="upload-error" class="alert alert-danger" style="display: none;">
                        <i class="fas fa-exclamation-circle"></i> <span id="error-message"></span>
                    </div>
                </div>

                <div class="card">
                    <form id="lecture-form" method="POST" action="{{ route('admin.storeLecture') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body row justify-content-between bg-primary-dark">
                            <div class="col-xl-6 col-lg-6 col-md-6">
                                <div class="mb-3">
                                    <label for="lecture_name" class="form-label text-mode">Lecture Name</label>
                                    <input name="lecture_name" value="{{ old('lecture_name') }}" type="text"
                                        placeholder="Enter lecture name"
                                        class="form-control @error('lecture_name') is-invalid @enderror"
                                        id="lecture_name" required>
                                    @error('lecture_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="select-course" class="form-label text-mode">Course</label>
                                    <select name="course_id" id="select-course" class="form-control" required>
                                        <option value="">Select a course</option>
                                        @foreach ($courses as $course)
                                            <option value="{{ $course->id }}">{{ $course->course_title }}</option>
                                        @endforeach
                                    </select>
                                    @error('course_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="lecture_description" class="form-label text-mode">Description</label>
                                    <textarea class="form-control @error('lecture_description') is-invalid @enderror" 
                                        name="lecture_description" placeholder="Enter lecture description" 
                                        id="lecture_description" rows="3" required>{{ old('lecture_description') }}</textarea>
                                    @error('lecture_description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="cover_image" class="form-label text-mode">Cover Image</label>
                                    <input type="file" id="cover_image" name="cover_image"
                                        class="form-control @error('cover_image') is-invalid @enderror"
                                        accept="image/jpeg,image/png,image/jpg,image/gif" required>
                                    @error('cover_image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <small class="form-text text-muted">Max size: 2MB. Formats: JPG, PNG, GIF</small>
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-6">
                                <div class="mb-3">
                                    <label for="select-section" class="form-label text-mode">Section</label>
                                    <select name="section_id" class="form-control @error('section_id') is-invalid @enderror" 
                                        id="select-section" required>
                                        <option value="">Select a section</option>
                                    </select>
                                    @error('section_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="video_path" class="form-label text-mode">Video File</label>
                                    <div class="video-upload-container">
                                        <input type="file" name="video_path" id="video_path"
                                            class="form-control @error('video_path') is-invalid @enderror"
                                            accept="video/mp4,video/avi,video/mov,video/wmv" required>
                                        @error('video_path')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <small class="form-text text-muted">Max size: 500MB. Formats: MP4, AVI, MOV, WMV</small>
                                        
                                        <!-- Video Preview -->
                                        <div id="video-preview" style="display: none; margin-top: 10px;">
                                            <div class="video-info p-3 border rounded">
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="fas fa-video text-primary me-2"></i>
                                                    <span id="video-name" class="fw-bold"></span>
                                                </div>
                                                <div class="video-details">
                                                    <small class="text-muted">
                                                        Size: <span id="video-size"></span> | 
                                                        Duration: <span id="video-duration">Calculating...</span>
                                                    </small>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Upload Progress -->
                                        <div id="upload-progress" style="display: none; margin-top: 15px;">
                                            <div class="upload-status mb-2">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="upload-label">
                                                        <i class="fas fa-cloud-upload-alt text-primary"></i>
                                                        <span id="upload-status-text">Preparing upload...</span>
                                                    </span>
                                                    <button type="button" id="cancel-upload" class="btn btn-sm btn-outline-danger">
                                                        <i class="fas fa-times"></i> Cancel
                                                    </button>
                                                </div>
                                            </div>
                                            
                                            <div class="progress mb-2" style="height: 8px;">
                                                <div id="progress-bar" class="progress-bar progress-bar-striped progress-bar-animated" 
                                                     role="progressbar" style="width: 0%"></div>
                                            </div>
                                            
                                            <div class="upload-details d-flex justify-content-between">
                                                <small class="text-muted">
                                                    <span id="uploaded-size">0 MB</span> of <span id="total-size">0 MB</span>
                                                </small>
                                                <small class="text-muted">
                                                    <span id="upload-speed">0 MB/s</span> | 
                                                    ETA: <span id="eta">--:--</span>
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center">
                                    <button type="submit" id="submit-btn" class="btn btn-primary text-mode">
                                        <i class="fas fa-save"></i> Create Lecture
                                    </button>
                                    <button type="button" id="submit-with-upload" class="btn btn-success text-mode" style="display: none;">
                                        <i class="fas fa-cloud-upload-alt"></i> Upload & Create
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@include('partials.admin.footer')
</div>
</div>
@include('partials.admin.footerScript')

<style>
.video-upload-container {
    position: relative;
}

.upload-status {
    font-size: 14px;
}

.progress {
    background-color: #e9ecef;
    border-radius: 4px;
}

.progress-bar {
    background: linear-gradient(45deg, #007bff, #0056b3);
    transition: width 0.3s ease;
}

.video-info {
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
}

.upload-details {
    font-size: 12px;
}

#cancel-upload:hover {
    background-color: #dc3545;
    color: white;
}

.btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}
</style>

<script>
$(document).ready(function() {
    let uploadInProgress = false;
    let uploadXHR = null;
    let startTime = null;
    
    // Course selection handler
    $('#select-course').on('change', function() {
        var courseId = $(this).val();
        $('#select-section').empty().append('<option value="">Select a section</option>');
        
        if (courseId) {
            $.ajax({
                url: "{{ route('admin.fetchSections') }}",
                method: 'POST',
                data: { course_id: courseId, _token: "{{ csrf_token() }}" },
                success: function(data) {
                    if ($.isEmptyObject(data)) {
                        $('#select-section').append('<option value="">No sections available</option>');
                    } else {
                        $.each(data, function(key, value) {
                            $('#select-section').append('<option value="' + key + '">' + value + '</option>');
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching sections:', xhr.responseText);
                }
            });
        }
    });

    // Video file selection handler
    $('#video_path').on('change', function() {
        const file = this.files[0];
        if (file) {
            displayVideoPreview(file);
            $('#submit-btn').hide();
            $('#submit-with-upload').show();
        } else {
            $('#video-preview').hide();
            $('#submit-btn').show();
            $('#submit-with-upload').hide();
        }
    });

    // Display video preview and info
    function displayVideoPreview(file) {
        const fileName = file.name;
        const fileSize = formatFileSize(file.size);
        
        $('#video-name').text(fileName);
        $('#video-size').text(fileSize);
        $('#video-preview').show();
        
        // Get video duration
        const video = document.createElement('video');
        video.preload = 'metadata';
        video.onloadedmetadata = function() {
            const duration = formatDuration(video.duration);
            $('#video-duration').text(duration);
            window.URL.revokeObjectURL(video.src);
        };
        video.src = URL.createObjectURL(file);
    }

    // Format file size
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    // Format duration
    function formatDuration(seconds) {
        const hours = Math.floor(seconds / 3600);
        const minutes = Math.floor((seconds % 3600) / 60);
        const secs = Math.floor(seconds % 60);
        
        if (hours > 0) {
            return `${hours}:${minutes.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
        }
        return `${minutes}:${secs.toString().padStart(2, '0')}`;
    }

    // Upload with progress tracking
    $('#submit-with-upload').on('click', function(e) {
        e.preventDefault();
        
        if (uploadInProgress) {
            return;
        }

        // Validate form
        if (!validateForm()) {
            return;
        }

        startUpload();
    });

    // Validate form
    function validateForm() {
        let isValid = true;
        const requiredFields = ['lecture_name', 'lecture_description', 'course_id', 'section_id', 'cover_image', 'video_path'];
        
        requiredFields.forEach(function(fieldName) {
            const field = $(`[name="${fieldName}"]`);
            if (!field.val()) {
                field.addClass('is-invalid');
                isValid = false;
            } else {
                field.removeClass('is-invalid');
            }
        });

        if (!isValid) {
            showError('Please fill in all required fields.');
        }

        return isValid;
    }

    // Start upload process
    function startUpload() {
        uploadInProgress = true;
        startTime = Date.now();
        
        // Show progress UI
        $('#upload-progress').show();
        $('#submit-with-upload').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Uploading...');
        
        // Prepare form data
        const formData = new FormData($('#lecture-form')[0]);
        
        // Get file info for progress tracking
        const videoFile = $('#video_path')[0].files[0];
        const totalSize = videoFile.size;
        $('#total-size').text(formatFileSize(totalSize));

        // Create AJAX request
        uploadXHR = $.ajax({
            url: "{{ route('admin.storeLectureAjax') }}",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            xhr: function() {
                const xhr = new window.XMLHttpRequest();
                
                // Upload progress
                xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                        updateProgress(e.loaded, e.total);
                    }
                }, false);
                
                return xhr;
            },
            success: function(response) {
                if (response.success) {
                    showSuccess(response.message);
                    setTimeout(function() {
                        window.location.href = response.redirect_url;
                    }, 2000);
                } else {
                    showError(response.message);
                }
            },
            error: function(xhr) {
                let errorMessage = 'Upload failed. Please try again.';
                
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                    const errors = xhr.responseJSON.errors;
                    errorMessage = Object.values(errors).flat().join(', ');
                }
                
                showError(errorMessage);
            },
            complete: function() {
                uploadInProgress = false;
                $('#submit-with-upload').prop('disabled', false).html('<i class="fas fa-cloud-upload-alt"></i> Upload & Create');
            }
        });
    }

    // Update progress
    function updateProgress(loaded, total) {
        const percentage = Math.round((loaded / total) * 100);
        const loadedSize = formatFileSize(loaded);
        const totalSize = formatFileSize(total);
        
        // Update progress bar
        $('#progress-bar').css('width', percentage + '%').attr('aria-valuenow', percentage);
        
        // Update status text
        $('#upload-status-text').text(`Uploading... ${percentage}%`);
        
        // Update size info
        $('#uploaded-size').text(loadedSize);
        
        // Calculate speed and ETA
        const currentTime = Date.now();
        const elapsedTime = (currentTime - startTime) / 1000; // seconds
        const speed = loaded / elapsedTime; // bytes per second
        const remainingBytes = total - loaded;
        const eta = remainingBytes / speed; // seconds
        
        $('#upload-speed').text(formatFileSize(speed) + '/s');
        $('#eta').text(formatTime(eta));
    }

    // Format time for ETA
    function formatTime(seconds) {
        if (!isFinite(seconds) || seconds < 0) return '--:--';
        
        const minutes = Math.floor(seconds / 60);
        const secs = Math.floor(seconds % 60);
        return `${minutes}:${secs.toString().padStart(2, '0')}`;
    }

    // Cancel upload
    $('#cancel-upload').on('click', function() {
        if (uploadXHR) {
            uploadXHR.abort();
            uploadInProgress = false;
            $('#upload-progress').hide();
            $('#submit-with-upload').prop('disabled', false).html('<i class="fas fa-cloud-upload-alt"></i> Upload & Create');
            showError('Upload cancelled.');
        }
    });

    // Show success message
    function showSuccess(message) {
        $('#upload-messages').show();
        $('#upload-error').hide();
        $('#success-message').text(message);
        $('#upload-success').show();
        $('#upload-progress').hide();
    }

    // Show error message
    function showError(message) {
        $('#upload-messages').show();
        $('#upload-success').hide();
        $('#error-message').text(message);
        $('#upload-error').show();
        $('#upload-progress').hide();
    }

    // Hide messages after 5 seconds
    setTimeout(function() {
        $('#upload-messages').fadeOut();
    }, 5000);
});
</script>
