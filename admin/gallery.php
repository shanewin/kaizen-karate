<?php
define('KAIZEN_ADMIN', true);
session_start();
require_once __DIR__ . '/error-handling.php';
require_once 'config.php';

// Require login
require_login();

$message = '';

/**
 * Find the array index of a gallery by its id. Returns null if not found.
 */
function find_gallery_index($galleries, $id) {
    foreach ($galleries as $i => $g) {
        if (($g['id'] ?? '') === $id) {
            return $i;
        }
    }
    return null;
}

/**
 * Build a unique, URL-safe slug from a title.
 */
function make_gallery_slug($title, $existing_ids) {
    $slug = strtolower(trim($title));
    $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
    $slug = trim($slug, '-');
    if ($slug === '') {
        $slug = 'gallery';
    }
    $base = $slug;
    $c = 1;
    while (in_array($slug, $existing_ids, true)) {
        $slug = $base . '-' . $c;
        $c++;
    }
    return $slug;
}

// Load current gallery data (draft mode for editing)
$data = load_json_data('galleries', 'draft');
if (empty($data) || !isset($data['galleries'])) {
    $data = ['galleries' => []];
}

// ----- Handle actions -----
if ($_POST) {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        $message = error_message('Security token invalid. Please try again.');
    } else {
        $action = $_POST['action'] ?? '';

        switch ($action) {

            case 'create_gallery':
                $title = sanitize_input($_POST['title'] ?? '');
                if ($title === '') {
                    $message = error_message('Please enter a gallery name.');
                    break;
                }
                $existing_ids = array_column($data['galleries'], 'id');
                $new_id = make_gallery_slug($title, $existing_ids);
                $data['galleries'][] = [
                    'id'          => $new_id,
                    'title'       => $title,
                    'description' => sanitize_input($_POST['description'] ?? ''),
                    'order'       => count($data['galleries']) + 1,
                    'images'      => [],
                ];
                if (save_json_data('galleries', $data, 'draft', ['action' => 'Created gallery: ' . $title])) {
                    $message = success_message('Gallery "' . htmlspecialchars($title) . '" created. Now add some photos below.');
                    $_GET['g'] = $new_id;
                } else {
                    $message = error_message('Failed to save gallery.');
                }
                break;

            case 'update_gallery':
                $gid = $_POST['gallery_id'] ?? '';
                $idx = find_gallery_index($data['galleries'], $gid);
                if ($idx === null) {
                    $message = error_message('Gallery not found.');
                    break;
                }
                $data['galleries'][$idx]['title']       = sanitize_input($_POST['title'] ?? $data['galleries'][$idx]['title']);
                $data['galleries'][$idx]['description'] = sanitize_input($_POST['description'] ?? '');
                if (save_json_data('galleries', $data, 'draft', ['action' => 'Updated gallery details'])) {
                    $message = success_message('Gallery details updated.');
                } else {
                    $message = error_message('Failed to save changes.');
                }
                $_GET['g'] = $gid;
                break;

            case 'delete_gallery':
                $gid = $_POST['gallery_id'] ?? '';
                $idx = find_gallery_index($data['galleries'], $gid);
                if ($idx === null) {
                    $message = error_message('Gallery not found.');
                    break;
                }
                // Remove all image files for this gallery
                foreach ($data['galleries'][$idx]['images'] as $img) {
                    delete_uploaded_file($img['full']);
                    if (!empty($img['thumb']) && $img['thumb'] !== $img['full']) {
                        delete_uploaded_file($img['thumb']);
                    }
                }
                $title = $data['galleries'][$idx]['title'];
                array_splice($data['galleries'], $idx, 1);
                if (save_json_data('galleries', $data, 'draft', ['action' => 'Deleted gallery: ' . $title])) {
                    $message = success_message('Gallery "' . htmlspecialchars($title) . '" deleted.');
                } else {
                    $message = error_message('Failed to delete gallery.');
                }
                break;

            case 'upload_images':
                $gid = $_POST['gallery_id'] ?? '';
                $idx = find_gallery_index($data['galleries'], $gid);
                if ($idx === null) {
                    $message = error_message('Gallery not found.');
                    break;
                }
                $upload = handle_gallery_uploads('images', $gid);
                if (!empty($upload['images'])) {
                    foreach ($upload['images'] as $img) {
                        $data['galleries'][$idx]['images'][] = $img;
                    }
                    save_json_data('galleries', $data, 'draft', ['action' => count($upload['images']) . ' photo(s) added to ' . $data['galleries'][$idx]['title']]);
                    $msg = count($upload['images']) . ' photo(s) uploaded.';
                    if (!empty($upload['errors'])) {
                        $msg .= ' Skipped: ' . implode('; ', $upload['errors']);
                    }
                    $message = success_message($msg);
                } else {
                    $err = 'No photos were uploaded.';
                    if (!empty($upload['errors'])) {
                        $err .= ' ' . implode('; ', $upload['errors']);
                    }
                    $message = error_message($err);
                }
                $_GET['g'] = $gid;
                break;

            case 'save_images':
                $gid = $_POST['gallery_id'] ?? '';
                $idx = find_gallery_index($data['galleries'], $gid);
                if ($idx === null) {
                    $message = error_message('Gallery not found.');
                    break;
                }
                $old_images = $data['galleries'][$idx]['images'];
                $order      = $_POST['order'] ?? [];     // sequence of original indexes (DOM order)
                $captions   = $_POST['caption'] ?? [];
                $alts       = $_POST['alt'] ?? [];
                $deletes    = $_POST['delete'] ?? [];    // keyed by original index

                $new_images = [];
                foreach ($order as $orig_i) {
                    if (!isset($old_images[$orig_i])) {
                        continue;
                    }
                    if (isset($deletes[$orig_i])) {
                        // Remove files for deleted image
                        delete_uploaded_file($old_images[$orig_i]['full']);
                        if (!empty($old_images[$orig_i]['thumb']) && $old_images[$orig_i]['thumb'] !== $old_images[$orig_i]['full']) {
                            delete_uploaded_file($old_images[$orig_i]['thumb']);
                        }
                        continue;
                    }
                    $img = $old_images[$orig_i];
                    $img['caption'] = sanitize_input($captions[$orig_i] ?? '');
                    $img['alt']     = sanitize_input($alts[$orig_i] ?? '');
                    $new_images[] = $img;
                }
                $data['galleries'][$idx]['images'] = $new_images;
                if (save_json_data('galleries', $data, 'draft', ['action' => 'Updated photos in ' . $data['galleries'][$idx]['title']])) {
                    $message = success_message('Photos saved.');
                } else {
                    $message = error_message('Failed to save photos.');
                }
                $_GET['g'] = $gid;
                break;

            case 'rotate_image':
                $gid = $_POST['gallery_id'] ?? '';
                $idx = find_gallery_index($data['galleries'], $gid);
                if ($idx === null) {
                    $message = error_message('Gallery not found.');
                    break;
                }
                $img_i = (int) ($_POST['image_index'] ?? -1);
                if (!isset($data['galleries'][$idx]['images'][$img_i])) {
                    $message = error_message('Photo not found.');
                    $_GET['g'] = $gid;
                    break;
                }
                // left = 90° CCW, right = 90° CW (270° CCW)
                $degrees = ($_POST['direction'] ?? 'right') === 'left' ? 90 : 270;
                $img = $data['galleries'][$idx]['images'][$img_i];

                $dims = gallery_rotate_file($img['full'], $degrees);
                if ($dims === false) {
                    $message = error_message('Could not rotate this photo.');
                    $_GET['g'] = $gid;
                    break;
                }
                // Rotate the thumbnail too (if it's a separate file)
                if (!empty($img['thumb']) && $img['thumb'] !== $img['full']) {
                    gallery_rotate_file($img['thumb'], $degrees);
                }
                // Record new dimensions of the full image
                $data['galleries'][$idx]['images'][$img_i]['width']  = $dims[0];
                $data['galleries'][$idx]['images'][$img_i]['height'] = $dims[1];

                if (save_json_data('galleries', $data, 'draft', ['action' => 'Rotated a photo in ' . $data['galleries'][$idx]['title']])) {
                    $message = success_message('Photo rotated.');
                } else {
                    $message = error_message('Failed to save rotation.');
                }
                $_GET['g'] = $gid;
                break;
        }
    }
}

// Determine which gallery is selected for management
$galleries = $data['galleries'];
$selected_id = $_GET['g'] ?? ($galleries[0]['id'] ?? '');
$selected_idx = find_gallery_index($galleries, $selected_id);
$selected = ($selected_idx !== null) ? $galleries[$selected_idx] : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photo Gallery - Kaizen Karate Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root { --kaizen-primary: #a4332b; --kaizen-secondary: #721c24; --sidebar-bg: #2c3e50; --sidebar-hover: #34495e; }
        body { background-color: #f0f2f5; }
        .sidebar { background: var(--sidebar-bg); min-height: 100vh; }
        .sidebar .nav-link { color: #ecf0f1; padding: 1rem 1.5rem; margin: 0.25rem 0; border-radius: 8px; transition: all 0.3s ease; }
        .sidebar .nav-link:hover { background: var(--sidebar-hover); color: white; transform: translateX(5px); }
        .sidebar .nav-link.active { background: var(--kaizen-primary); color: white; }
        .brand-header { background: linear-gradient(45deg, var(--kaizen-primary), var(--kaizen-secondary)); color: white; padding: 1.5rem; text-align: center; }

        /* Cards */
        .content-card { background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); margin-bottom: 1.5rem; overflow: hidden; border: 1px solid rgba(0,0,0,0.06); }
        .card-header-custom { background: linear-gradient(135deg, var(--kaizen-primary) 0%, var(--kaizen-secondary) 100%); color: white; padding: 1.1rem 1.5rem; }
        .card-header-custom h5 { font-size: 1rem; font-weight: 600; letter-spacing: 0.01em; }
        .card-subheader { background: #fafafa; border-bottom: 1px solid #eee; padding: 0.85rem 1.5rem; display: flex; align-items: center; gap: 0.5rem; color: #444; font-size: 0.875rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.04em; }
        .card-subheader i { color: var(--kaizen-primary); font-size: 0.9rem; }
        .content-card .card-body { padding: 1.5rem; }

        /* Buttons */
        .btn-kaizen { background: linear-gradient(135deg, var(--kaizen-primary) 0%, var(--kaizen-secondary) 100%); border: none; color: white; padding: 0.55rem 1.4rem; border-radius: 7px; font-weight: 600; font-size: 0.9rem; transition: all 0.2s; }
        .btn-kaizen:hover { color: white; transform: translateY(-1px); box-shadow: 0 6px 18px rgba(164, 51, 43, 0.35); }
        .form-control:focus, .form-select:focus { border-color: var(--kaizen-primary); box-shadow: 0 0 0 0.2rem rgba(164, 51, 43, 0.18); }

        /* Gallery album tabs */
        .gallery-tabs-bar { background: white; border-radius: 12px; border: 1px solid rgba(0,0,0,0.06); box-shadow: 0 2px 8px rgba(0,0,0,0.06); padding: 1rem 1.25rem 0.6rem; margin-bottom: 1.5rem; display: flex; flex-wrap: wrap; gap: 0.5rem; align-items: center; }
        .gallery-tab { border: 1.5px solid #e2e6ea; border-radius: 7px; padding: 0.45rem 0.9rem; text-decoration: none; color: #555; font-size: 0.875rem; font-weight: 500; display: inline-flex; align-items: center; gap: 0.35rem; transition: all 0.18s; white-space: nowrap; }
        .gallery-tab:hover { border-color: var(--kaizen-primary); color: var(--kaizen-primary); background: #fdf5f5; }
        .gallery-tab.active { background: var(--kaizen-primary); color: white; border-color: var(--kaizen-secondary); box-shadow: 0 3px 10px rgba(164, 51, 43, 0.25); }
        .gallery-tab .badge { font-weight: 500; font-size: 0.75rem; }
        .gallery-tab.active .badge { background: rgba(255,255,255,0.25) !important; color: white !important; }

        /* Photo grid items */
        .photo-item { border: 1.5px solid #e9ecef; border-radius: 10px; padding: 0.85rem; background: #fff; box-shadow: 0 1px 4px rgba(0,0,0,0.05); transition: box-shadow 0.2s; }
        .photo-item:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        .photo-item img { width: 100%; height: 145px; object-fit: cover; border-radius: 7px; }
        .photo-item .drag-handle { cursor: grab; color: #bcc3cc; font-size: 0.8rem; }
        .photo-item .drag-handle:active { cursor: grabbing; }
        .photo-item.marked-delete { opacity: 0.4; outline: 2px solid #dc3545; border-color: #dc3545; }
        .photo-item .photo-controls { display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.65rem; min-height: 2rem; }
        .section-title { color: var(--kaizen-primary); border-bottom: 2px solid var(--kaizen-primary); padding-bottom: 0.5rem; margin-bottom: 1rem; }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-lg-2 sidebar">
                <?php include 'includes/navigation.php'; ?>
            </div>

            <div class="col-md-9 col-lg-10 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1><i class="fas fa-images me-2 text-primary"></i>Photo Gallery</h1>
                    <a href="../gallery.php" target="_blank" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-external-link-alt me-1"></i>View Live Gallery
                    </a>
                </div>

                <?php echo $message; ?>

                <!-- Create a new gallery -->
                <div class="content-card">
                    <div class="card-header-custom"><h5 class="mb-0"><i class="fas fa-folder-plus me-2"></i>Create a New Gallery</h5></div>
                    <div class="card-body">
                        <form method="POST" class="row g-2 align-items-end">
                            <input type="hidden" name="action" value="create_gallery">
                            <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                            <div class="col-md-4">
                                <label class="form-label">Gallery Name</label>
                                <input type="text" name="title" class="form-control" placeholder="e.g. Belt Testing" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Description (optional)</label>
                                <input type="text" name="description" class="form-control" placeholder="Short description shown above the photos">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-kaizen w-100"><i class="fas fa-plus me-1"></i>Create</button>
                            </div>
                        </form>
                    </div>
                </div>

                <?php if (empty($galleries)): ?>
                    <div class="alert alert-info"><i class="fas fa-info-circle me-2"></i>No galleries yet. Create your first one above.</div>
                <?php else: ?>

                    <!-- Gallery selector tabs -->
                    <div class="gallery-tabs-bar">
                        <?php foreach ($galleries as $g): ?>
                            <a href="?g=<?php echo urlencode($g['id']); ?>"
                               class="gallery-tab <?php echo ($g['id'] === $selected_id) ? 'active' : ''; ?>">
                                <i class="fas fa-folder"></i><?php echo htmlspecialchars($g['title']); ?>
                                <span class="badge bg-light text-dark ms-1"><?php echo count($g['images']); ?></span>
                            </a>
                        <?php endforeach; ?>
                    </div>

                    <?php if ($selected): ?>
                        <!-- Selected gallery: details -->
                        <div class="content-card">
                            <div class="card-header-custom d-flex justify-content-between align-items-center">
                                <h5 class="mb-0"><i class="fas fa-folder-open me-2"></i><?php echo htmlspecialchars($selected['title']); ?></h5>
                                <form method="POST" onsubmit="return confirm('Delete this entire gallery and all its photos? This cannot be undone.');" class="m-0">
                                    <input type="hidden" name="action" value="delete_gallery">
                                    <input type="hidden" name="gallery_id" value="<?php echo htmlspecialchars($selected['id']); ?>">
                                    <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-light"><i class="fas fa-trash me-1"></i>Delete Gallery</button>
                                </form>
                            </div>
                            <div class="card-body">
                                <form method="POST" class="row g-2 align-items-end mb-0">
                                    <input type="hidden" name="action" value="update_gallery">
                                    <input type="hidden" name="gallery_id" value="<?php echo htmlspecialchars($selected['id']); ?>">
                                    <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                                    <div class="col-md-4">
                                        <label class="form-label">Name</label>
                                        <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($selected['title']); ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Description</label>
                                        <input type="text" name="description" class="form-control" value="<?php echo htmlspecialchars($selected['description'] ?? ''); ?>">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-kaizen w-100"><i class="fas fa-save me-1"></i>Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Upload photos -->
                        <div class="content-card">
                            <div class="card-subheader"><i class="fas fa-cloud-upload-alt"></i>Add Photos</div>
                            <div class="card-body">
                                <form method="POST" enctype="multipart/form-data" id="uploadForm">
                                    <input type="hidden" name="action" value="upload_images">
                                    <input type="hidden" name="gallery_id" value="<?php echo htmlspecialchars($selected['id']); ?>">
                                    <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                                    <div class="mb-3">
                                        <input type="file" name="images[]" id="galleryFiles" class="form-control" multiple accept="image/jpeg,image/png,image/webp,image/heic,image/heif,.heic,.heif" required>
                                        <div class="form-text">Select multiple photos at once. JPG, PNG, WEBP, or iPhone <strong>HEIC</strong> &mdash; all formats are accepted and resized automatically.</div>
                                        <div id="heicStatus" class="small mt-2"></div>
                                    </div>
                                    <button type="submit" class="btn btn-kaizen" id="uploadBtn"><i class="fas fa-upload me-1"></i>Upload</button>
                                </form>
                            </div>
                        </div>

                        <!-- Manage photos -->
                        <div class="content-card">
                            <div class="card-subheader"><i class="fas fa-th"></i>Photos (<?php echo count($selected['images']); ?>) &mdash; drag to reorder</div>
                            <div class="card-body">
                                <?php if (empty($selected['images'])): ?>
                                    <p class="text-muted mb-0">No photos in this gallery yet. Use the upload box above.</p>
                                <?php else: ?>
                                    <form method="POST">
                                        <input type="hidden" name="action" value="save_images">
                                        <input type="hidden" name="gallery_id" value="<?php echo htmlspecialchars($selected['id']); ?>">
                                        <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">

                                        <div class="row g-3" id="photoGrid">
                                            <?php foreach ($selected['images'] as $i => $img): ?>
                                                <div class="col-sm-6 col-md-4 col-lg-3 photo-col">
                                                    <div class="photo-item">
                                                        <input type="hidden" name="order[]" value="<?php echo $i; ?>">
                                                        <div class="photo-controls">
                                                            <span class="drag-handle"><i class="fas fa-grip-vertical"></i></span>
                                                            <div class="btn-group btn-group-sm" role="group">
                                                                <button type="button" class="btn btn-outline-secondary rotate-btn" data-index="<?php echo $i; ?>" data-dir="left" title="Rotate left"><i class="fas fa-rotate-left"></i></button>
                                                                <button type="button" class="btn btn-outline-secondary rotate-btn" data-index="<?php echo $i; ?>" data-dir="right" title="Rotate right"><i class="fas fa-rotate-right"></i></button>
                                                            </div>
                                                            <div class="form-check m-0">
                                                                <input class="form-check-input delete-check" type="checkbox" name="delete[<?php echo $i; ?>]" value="1" id="del<?php echo $i; ?>">
                                                                <label class="form-check-label small text-danger" for="del<?php echo $i; ?>">Delete</label>
                                                            </div>
                                                        </div>
                                                        <img src="../<?php echo htmlspecialchars($img['thumb'] ?? $img['full']); ?>" alt="">
                                                        <div class="mt-2">
                                                            <input type="text" name="caption[<?php echo $i; ?>]" class="form-control form-control-sm mb-1" placeholder="Caption" value="<?php echo htmlspecialchars($img['caption'] ?? ''); ?>">
                                                            <input type="text" name="alt[<?php echo $i; ?>]" class="form-control form-control-sm" placeholder="Alt text (accessibility)" value="<?php echo htmlspecialchars($img['alt'] ?? ''); ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>

                                        <button type="submit" class="btn btn-kaizen mt-3"><i class="fas fa-save me-1"></i>Save Photo Changes</button>
                                    </form>

                                    <!-- Hidden form used by the per-photo rotate buttons -->
                                    <form method="POST" id="rotateForm" class="d-none">
                                        <input type="hidden" name="action" value="rotate_image">
                                        <input type="hidden" name="gallery_id" value="<?php echo htmlspecialchars($selected['id']); ?>">
                                        <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                                        <input type="hidden" name="image_index" id="rotateIndex">
                                        <input type="hidden" name="direction" id="rotateDir">
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

                <div class="alert alert-secondary mt-2">
                    <i class="fas fa-info-circle me-2"></i>
                    Changes are saved as a <strong>draft</strong>. Use the <strong>Publish Changes</strong> button (Dashboard) to make them live on the public gallery page.
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        // Drag-to-reorder photos
        var grid = document.getElementById('photoGrid');
        if (grid && window.Sortable) {
            Sortable.create(grid, {
                handle: '.drag-handle',
                animation: 150,
                ghostClass: 'bg-light'
            });
        }
        // Visual cue when marking a photo for deletion
        document.querySelectorAll('.delete-check').forEach(function (cb) {
            cb.addEventListener('change', function () {
                this.closest('.photo-item').classList.toggle('marked-delete', this.checked);
            });
        });
        // Per-photo rotation: submit the dedicated rotate form
        document.querySelectorAll('.rotate-btn').forEach(function (btn) {
            btn.addEventListener('click', function () {
                document.getElementById('rotateIndex').value = this.dataset.index;
                document.getElementById('rotateDir').value = this.dataset.dir;
                document.getElementById('rotateForm').submit();
            });
        });

        // HEIC conversion is handled server-side via Imagick + libheif.
        // No browser-side conversion needed.
    </script>
</body>
</html>
