@include('partials.admin.header',['title'=>'View Lecture Video'])
@include('partials.admin.aside')
@include('partials.admin.nav')

<div class="container-fluid bg-secondary-dark pb-7">
    <div class="container-fluid">
        <div class="card bg-primary-dark">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title fw-semibold text-mode mb-0">{{ $lecture->lecture_name }}</h5>
                    <a href="{{ route('viewLectures') }}" class="btn btn-outline-secondary">
                        <i class="ti ti-arrow-left me-2"></i>Back to Lectures
                    </a>
                </div>
                <hr>
                
                <div class="row">
                    <div class="col-lg-8">
                        <div class="video-container mb-4">
                            @php
                                // Clean the video path and ensure proper URL generation
                                $videoPath = $selectedVideo->video_path;
                                // Remove any leading slashes and ensure proper path
                                $videoPath = ltrim($videoPath, '/');
                                // Generate the full URL
                                $videoUrl = asset('storage/videos/' . $videoPath);
                            @endphp
                            
                            <video controls class="w-100" style="max-height: 500px; border-radius: 8px;" preload="metadata">
                                <source src="{{ $videoUrl }}" type="video/mp4">
                                <source src="{{ $videoUrl }}" type="video/webm">
                                <source src="{{ $videoUrl }}" type="video/ogg">
                                Your browser does not support the video tag.
                            </video>
                            
                            <!-- Debug info (remove in production) -->
                            <div class="mt-2 small text-muted">
                                <strong>Debug Info:</strong><br>
                                Original Path: {{ $selectedVideo->video_path }}<br>
                                Generated URL: {{ $videoUrl }}<br>
                                File Exists: {{ file_exists(storage_path('app/public/videos/' . $videoPath)) ? 'Yes' : 'No' }}<br>
                                Storage Link: {{ is_link(public_path('storage')) ? 'Yes' : 'No' }}
                            </div>
                        </div>
                        
                        <!-- Alternative download link if video doesn't play -->
                        <div class="alert alert-info">
                            <i class="ti ti-info-circle me-2"></i>
                            If the video doesn't play, you can 
                            <a href="{{ $videoUrl }}" target="_blank" class="alert-link">download it directly</a>
                            or <a href="{{ $videoUrl }}" target="_blank" class="alert-link">open in new tab</a>.
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="card bg-secondary-dark">
                            <div class="card-header">
                                <h6 class="text-mode mb-0">Lecture Details</h6>
                            </div>
                            <div class="card-body">
                                <p class="text-mode"><strong>Name:</strong> {{ $lecture->lecture_name }}</p>
                                <p class="text-mode"><strong>Description:</strong> {{ $lecture->lecture_description }}</p>
                                <p class="text-mode"><strong>Section:</strong> {{ $lecture->section->section_name }}</p>
                                <p class="text-mode"><strong>Course:</strong> {{ $lecture->section->course->course_title }}</p>
                                <p class="text-mode"><strong>Video File:</strong> {{ $selectedVideo->name }}</p>
                                <p class="text-mode"><strong>Uploaded:</strong> {{ $selectedVideo->created_at->format('Y-m-d H:i') }}</p>
                                
                                <!-- File size if available -->
                                @php
                                    $filePath = storage_path('app/public/videos/' . $videoPath);
                                    $fileSize = file_exists($filePath) ? filesize($filePath) : 0;
                                    $fileSizeMB = round($fileSize / 1024 / 1024, 2);
                                @endphp
                                @if($fileSize > 0)
                                    <p class="text-mode"><strong>File Size:</strong> {{ $fileSizeMB }} MB</p>
                                @endif
                            </div>
                        </div>
                        
                        @if($lecture->videos->count() > 1)
                            <div class="card bg-secondary-dark mt-3">
                                <div class="card-header">
                                    <h6 class="text-mode mb-0">Other Videos</h6>
                                </div>
                                <div class="card-body">
                                    @foreach($lecture->videos as $video)
                                        @if($video->id !== $selectedVideo->id)
                                            <a href="{{ route('admin.viewLectureVideo', ['id' => $lecture->id, 'video' => $video->id]) }}" 
                                               class="btn btn-outline-primary btn-sm mb-2 d-block">
                                                {{ $video->name }}
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('partials.admin.footer')
</div>
</div>
@include('partials.admin.footerScript')
