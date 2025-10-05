<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config/database.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin-login');
    exit;
}

$db = getDatabaseConnection();
$success = '';
$error = '';

// Handle promotion actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    try {
        if ($action === 'create') {
            $stmt = $db->prepare("INSERT INTO promotions (promotion_id, title, message, target_audience, start_date, end_date, discount_percentage, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                uniqid('promo_'),
                $_POST['title'],
                $_POST['message'],
                $_POST['target_audience'],
                $_POST['start_date'] ?: null,
                $_POST['end_date'] ?: null,
                $_POST['discount_percentage'] ?: 0,
                isset($_POST['is_active']) ? 1 : 0
            ]);
            $success = 'Promotion created successfully!';
        } elseif ($action === 'update') {
            $stmt = $db->prepare("UPDATE promotions SET title = ?, message = ?, target_audience = ?, start_date = ?, end_date = ?, discount_percentage = ?, is_active = ? WHERE id = ?");
            $stmt->execute([
                $_POST['title'],
                $_POST['message'],
                $_POST['target_audience'],
                $_POST['start_date'] ?: null,
                $_POST['end_date'] ?: null,
                $_POST['discount_percentage'] ?: 0,
                isset($_POST['is_active']) ? 1 : 0,
                $_POST['promotion_id']
            ]);
            $success = 'Promotion updated successfully!';
        } elseif ($action === 'delete') {
            // Soft delete: marquer comme supprimé au lieu de supprimer définitivement
            $stmt = $db->prepare("UPDATE promotions SET deleted_at = NOW(), is_active = 0 WHERE id = ?");
            $stmt->execute([$_POST['promotion_id']]);
            $success = 'Promotion deleted successfully!';
        } elseif ($action === 'restore') {
            // Restaurer une promotion supprimée
            $stmt = $db->prepare("UPDATE promotions SET deleted_at = NULL WHERE id = ?");
            $stmt->execute([$_POST['promotion_id']]);
            $success = 'Promotion restored successfully!';
        } elseif ($action === 'permanent_delete') {
            // Suppression permanente (admin seulement)
            $stmt = $db->prepare("DELETE FROM promotions WHERE id = ?");
            $stmt->execute([$_POST['promotion_id']]);
            $success = 'Promotion permanently deleted!';
        } elseif ($action === 'toggle_status') {
            $stmt = $db->prepare("UPDATE promotions SET is_active = NOT is_active WHERE id = ?");
            $stmt->execute([$_POST['promotion_id']]);
            $success = 'Promotion status updated!';
        }
    } catch (PDOException $e) {
        $error = 'Database error: ' . $e->getMessage();
    }
}

// Récupérer le filtre depuis l'URL
$filter = $_GET['filter'] ?? 'active';

// Fetch promotions based on filter
switch ($filter) {
    case 'all':
        $stmt = $db->query("SELECT * FROM promotions WHERE deleted_at IS NULL ORDER BY created_at DESC");
        break;
    case 'deleted':
        $stmt = $db->query("SELECT * FROM promotions WHERE deleted_at IS NOT NULL ORDER BY deleted_at DESC");
        break;
    case 'inactive':
        $stmt = $db->query("SELECT * FROM promotions WHERE deleted_at IS NULL AND is_active = 0 ORDER BY created_at DESC");
        break;
    case 'active':
    default:
        $stmt = $db->query("SELECT * FROM promotions WHERE deleted_at IS NULL AND is_active = 1 ORDER BY created_at DESC");
        break;
}
$promotions = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get statistics
$stats = [
    'total' => $db->query("SELECT COUNT(*) FROM promotions WHERE deleted_at IS NULL")->fetchColumn(),
    'active' => $db->query("SELECT COUNT(*) FROM promotions WHERE is_active = 1 AND deleted_at IS NULL")->fetchColumn(),
    'inactive' => $db->query("SELECT COUNT(*) FROM promotions WHERE is_active = 0 AND deleted_at IS NULL")->fetchColumn(),
    'deleted' => $db->query("SELECT COUNT(*) FROM promotions WHERE deleted_at IS NOT NULL")->fetchColumn(),
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - MastaBaber Promotions</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
        }

        .header {
            background: linear-gradient(135deg, #c79e56 0%, #a67c52 100%);
            color: white;
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .header h1 {
            font-size: 1.8em;
        }

        .header-right {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-logout {
            background: rgba(255,255,255,0.2);
            color: white;
            padding: 8px 20px;
            border: 1px solid white;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-logout:hover {
            background: white;
            color: #c79e56;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 30px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8em;
        }

        .stat-icon.total { background: #e3f2fd; color: #2196f3; }
        .stat-icon.active { background: #e8f5e9; color: #4caf50; }
        .stat-icon.inactive { background: #fff3e0; color: #ff9800; }

        .stat-info h3 {
            color: #666;
            font-size: 0.9em;
            font-weight: 500;
        }

        .stat-info p {
            color: #333;
            font-size: 2em;
            font-weight: bold;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .section-header h2 {
            color: #333;
            font-size: 1.5em;
        }

        .btn-primary {
            background: #c79e56;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 1em;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-primary:hover {
            background: #a67c52;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(199, 158, 86, 0.3);
        }

        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .alert-success {
            background: #e8f5e9;
            color: #2e7d32;
            border: 1px solid #4caf50;
        }

        .alert-error {
            background: #ffebee;
            color: #c62828;
            border: 1px solid #f44336;
        }

        .promotions-grid {
            display: grid;
            gap: 20px;
        }

        .promotion-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
        }

        .promotion-card:hover {
            box-shadow: 0 5px 20px rgba(0,0,0,0.12);
        }

        .promotion-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 15px;
        }

        .promotion-title {
            flex: 1;
        }

        .promotion-title h3 {
            color: #333;
            font-size: 1.3em;
            margin-bottom: 5px;
        }

        .promotion-id {
            color: #999;
            font-size: 0.85em;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: 600;
        }

        .status-badge.active {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .status-badge.inactive {
            background: #ffebee;
            color: #c62828;
        }

        .promotion-content {
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .promotion-content p {
            color: #666;
            line-height: 1.6;
            margin-bottom: 10px;
        }

        .promotion-meta {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 15px;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #666;
            font-size: 0.9em;
        }

        .meta-item i {
            color: #c79e56;
        }

        .promotion-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn-sm {
            padding: 8px 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.9em;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.3s ease;
        }

        .btn-edit {
            background: #2196f3;
            color: white;
        }

        .btn-edit:hover {
            background: #1976d2;
        }

        .btn-toggle {
            background: #ff9800;
            color: white;
        }

        .btn-toggle:hover {
            background: #f57c00;
        }

        .btn-delete {
            background: #f44336;
            color: white;
        }

        .btn-delete:hover {
            background: #d32f2f;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
            overflow-y: auto;
        }

        .modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 20px;
            max-width: 600px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .modal-header h2 {
            color: #333;
            font-size: 1.5em;
        }

        .btn-close {
            background: none;
            border: none;
            font-size: 1.5em;
            cursor: pointer;
            color: #999;
        }

        .btn-close:hover {
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            color: #333;
            font-weight: 500;
            margin-bottom: 8px;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 1em;
            transition: all 0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #c79e56;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .checkbox-wrapper {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .checkbox-wrapper input[type="checkbox"] {
            width: auto;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1><i class="fas fa-tags"></i> Promotion Management</h1>
        <div class="header-right">
            <div class="user-info">
                <i class="fas fa-user-circle" style="font-size: 1.5em;"></i>
                <span><?php echo htmlspecialchars($_SESSION['admin_name']); ?></span>
            </div>
            <a href="admin-logout" class="btn-logout">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </div>

    <div class="container">
        <!-- Statistics -->
        <div class="stats-grid">
            <div class="stat-card" style="cursor: pointer;" onclick="window.location.href='?filter=all'">
                <div class="stat-icon total">
                    <i class="fas fa-tags"></i>
                </div>
                <div class="stat-info">
                    <h3>Total Promotions</h3>
                    <p><?php echo $stats['total']; ?></p>
                </div>
            </div>
            <div class="stat-card" style="cursor: pointer;" onclick="window.location.href='?filter=active'">
                <div class="stat-icon active">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-info">
                    <h3>Active Promotions</h3>
                    <p><?php echo $stats['active']; ?></p>
                </div>
            </div>
            <div class="stat-card" style="cursor: pointer;" onclick="window.location.href='?filter=inactive'">
                <div class="stat-icon inactive">
                    <i class="fas fa-pause-circle"></i>
                </div>
                <div class="stat-info">
                    <h3>Inactive Promotions</h3>
                    <p><?php echo $stats['inactive']; ?></p>
                </div>
            </div>
            <div class="stat-card" style="cursor: pointer;" onclick="window.location.href='?filter=deleted'">
                <div class="stat-icon" style="background: #ffebee; color: #c62828;">
                    <i class="fas fa-trash"></i>
                </div>
                <div class="stat-info">
                    <h3>Deleted Promotions</h3>
                    <p><?php echo $stats['deleted']; ?></p>
                </div>
            </div>
        </div>

        <!-- Alerts -->
        <?php if ($success): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <!-- Section Header -->
        <div class="section-header">
            <h2>All Promotions</h2>
            <button class="btn-primary" onclick="openCreateModal()">
                <i class="fas fa-plus"></i> Create Promotion
            </button>
        </div>

        <!-- Promotions List -->
        <div class="promotions-grid">
            <?php foreach ($promotions as $promo): ?>
                <div class="promotion-card">
                    <div class="promotion-header">
                        <div class="promotion-title">
                            <h3><?php echo htmlspecialchars($promo['title']); ?></h3>
                            <span class="promotion-id">#<?php echo htmlspecialchars($promo['promotion_id']); ?></span>
                        </div>
                        <div style="display: flex; gap: 8px;">
                            <?php if ($promo['deleted_at']): ?>
                                <span class="status-badge" style="background: #ffebee; color: #c62828;">
                                    <i class="fas fa-trash"></i> Deleted
                                </span>
                            <?php else: ?>
                                <span class="status-badge <?php echo $promo['is_active'] ? 'active' : 'inactive'; ?>">
                                    <?php echo $promo['is_active'] ? 'Active' : 'Inactive'; ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="promotion-content">
                        <p><?php echo htmlspecialchars($promo['message']); ?></p>
                    </div>

                    <div class="promotion-meta">
                        <div class="meta-item">
                            <i class="fas fa-users"></i>
                            <span>Target: <?php echo ucfirst($promo['target_audience']); ?></span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-percent"></i>
                            <span>Discount: <?php echo $promo['discount_percentage']; ?>%</span>
                        </div>
                        <?php if ($promo['start_date']): ?>
                            <div class="meta-item">
                                <i class="fas fa-calendar-alt"></i>
                                <span><?php echo date('M d, Y', strtotime($promo['start_date'])); ?> - <?php echo $promo['end_date'] ? date('M d, Y', strtotime($promo['end_date'])) : 'No end'; ?></span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="promotion-actions">
                        <?php if ($promo['deleted_at']): ?>
                            <!-- Actions pour promotions supprimées -->
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="action" value="restore">
                                <input type="hidden" name="promotion_id" value="<?php echo $promo['id']; ?>">
                                <button type="submit" class="btn-sm btn-toggle">
                                    <i class="fas fa-undo"></i> Restore
                                </button>
                            </form>
                            <form method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to PERMANENTLY delete this promotion? This action cannot be undone!');">
                                <input type="hidden" name="action" value="permanent_delete">
                                <input type="hidden" name="promotion_id" value="<?php echo $promo['id']; ?>">
                                <button type="submit" class="btn-sm btn-delete">
                                    <i class="fas fa-trash-alt"></i> Permanent Delete
                                </button>
                            </form>
                        <?php else: ?>
                            <!-- Actions pour promotions actives -->
                            <button class="btn-sm btn-edit" onclick='editPromotion(<?php echo json_encode($promo); ?>)'>
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="action" value="toggle_status">
                                <input type="hidden" name="promotion_id" value="<?php echo $promo['id']; ?>">
                                <button type="submit" class="btn-sm btn-toggle">
                                    <i class="fas fa-<?php echo $promo['is_active'] ? 'pause' : 'play'; ?>"></i>
                                    <?php echo $promo['is_active'] ? 'Deactivate' : 'Activate'; ?>
                                </button>
                            </form>
                            <form method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this promotion? You can restore it later.');">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="promotion_id" value="<?php echo $promo['id']; ?>">
                                <button type="submit" class="btn-sm btn-delete">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Create/Edit Modal -->
    <div class="modal" id="promotionModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modalTitle">Create Promotion</h2>
                <button class="btn-close" onclick="closeModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form method="POST" id="promotionForm">
                <input type="hidden" name="action" id="formAction" value="create">
                <input type="hidden" name="promotion_id" id="promotionId">

                <div class="form-group">
                    <label for="title">Promotion Title *</label>
                    <input type="text" id="title" name="title" required>
                </div>

                <div class="form-group">
                    <label for="message">Message *</label>
                    <textarea id="message" name="message" required></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="target_audience">Target Audience</label>
                        <select id="target_audience" name="target_audience">
                            <option value="all">All Users</option>
                            <option value="new">New Users</option>
                            <option value="loyal">Loyal Customers</option>
                            <option value="inactive">Inactive Users</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="discount_percentage">Discount %</label>
                        <input type="number" id="discount_percentage" name="discount_percentage" min="0" max="100" step="0.01" value="0">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="start_date">Start Date</label>
                        <input type="date" id="start_date" name="start_date">
                    </div>

                    <div class="form-group">
                        <label for="end_date">End Date</label>
                        <input type="date" id="end_date" name="end_date">
                    </div>
                </div>

                <div class="form-group">
                    <div class="checkbox-wrapper">
                        <input type="checkbox" id="is_active" name="is_active" checked>
                        <label for="is_active">Active</label>
                    </div>
                </div>

                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i> Save Promotion
                </button>
            </form>
        </div>
    </div>

    <script>
        function openCreateModal() {
            document.getElementById('modalTitle').textContent = 'Create Promotion';
            document.getElementById('formAction').value = 'create';
            document.getElementById('promotionForm').reset();
            document.getElementById('is_active').checked = true;
            document.getElementById('promotionModal').classList.add('active');
        }

        function editPromotion(promo) {
            document.getElementById('modalTitle').textContent = 'Edit Promotion';
            document.getElementById('formAction').value = 'update';
            document.getElementById('promotionId').value = promo.id;
            document.getElementById('title').value = promo.title;
            document.getElementById('message').value = promo.message;
            document.getElementById('target_audience').value = promo.target_audience;
            document.getElementById('discount_percentage').value = promo.discount_percentage;
            document.getElementById('start_date').value = promo.start_date || '';
            document.getElementById('end_date').value = promo.end_date || '';
            document.getElementById('is_active').checked = promo.is_active == 1;
            document.getElementById('promotionModal').classList.add('active');
        }

        function closeModal() {
            document.getElementById('promotionModal').classList.remove('active');
        }

        // Close modal on background click
        document.getElementById('promotionModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>
</body>
</html>
