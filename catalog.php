<?php
require_once __DIR__.'/../config/config.php';
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');

$provided = $_SERVER['HTTP_X_API_KEY'] ?? '';
if (!hash_equals((string)CHATBOT_API_KEY, (string)$provided)) {
    http_response_code(401);
    echo json_encode(['error'=>'Unauthorized'], JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    $pdo = db();
    $settings = $pdo->query('SELECT site_name,phone,whatsapp,email,hero_title,hero_text,updated_at FROM settings WHERE id=1')->fetch();
    $products = $pdo->query('SELECT p.id,p.name,p.category,p.description,p.price,p.available,p.updated_at FROM products p WHERE p.available=1 ORDER BY p.id DESC')->fetchAll();
    foreach ($products as &$p) {
        $q = $pdo->prepare('SELECT image,caption,sort_order FROM product_images WHERE product_id=? ORDER BY sort_order,id');
        $q->execute([$p['id']]);
        $p['images'] = $q->fetchAll();
    }
    unset($p);
    $kits = $pdo->query('SELECT id,name,description,price,content,available,updated_at FROM kits WHERE available=1 ORDER BY id DESC')->fetchAll();
    $trainings = $pdo->query('SELECT id,title,description,content,updated_at FROM trainings WHERE published=1 ORDER BY id DESC')->fetchAll();
    $testimonials = $pdo->query('SELECT id,name,role,content,image,created_at FROM testimonials WHERE published=1 ORDER BY id DESC')->fetchAll();
    $faqs = $pdo->query('SELECT id,question,answer,created_at FROM faqs WHERE published=1 ORDER BY id DESC')->fetchAll();

    $last = $pdo->query("SELECT GREATEST(
        COALESCE((SELECT MAX(updated_at) FROM settings),'1970-01-01'),
        COALESCE((SELECT MAX(updated_at) FROM products),'1970-01-01'),
        COALESCE((SELECT MAX(created_at) FROM product_images),'1970-01-01'),
        COALESCE((SELECT MAX(updated_at) FROM kits),'1970-01-01'),
        COALESCE((SELECT MAX(updated_at) FROM trainings),'1970-01-01'),
        COALESCE((SELECT MAX(created_at) FROM testimonials),'1970-01-01'),
        COALESCE((SELECT MAX(created_at) FROM faqs),'1970-01-01')
    ) AS last_modified")->fetchColumn();

    echo json_encode([
        'updated_at' => date('c'),
        'last_modified' => $last ? date('c', strtotime($last)) : date('c'),
        'business' => $settings,
        'products' => $products,
        'kits' => $kits,
        'trainings' => $trainings,
        'testimonials' => $testimonials,
        'faqs' => $faqs,
    ], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['error'=>'Server error'], JSON_UNESCAPED_UNICODE);
}
