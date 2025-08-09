<?php

/**
 * Plugin Name: Send Test Mail (MU)
 */

/**
 * @param PHPMailer $phpmailer
 * @return void
 *
 * @see https://developer.wordpress.org/reference/hooks/phpmailer_init/
 */
add_action('phpmailer_init', function ($phpmailer) {
    $phpmailer->isSMTP();
    $phpmailer->Host         = 'mailhog'; // ← composeサービス名
    $phpmailer->Port         = 1025;
    $phpmailer->SMTPAuth     = false;
    $phpmailer->SMTPSecure   = '';        // ← 無しにする
    $phpmailer->SMTPAutoTLS  = false;     // ← 自動TLSを無効化
});

// 失敗理由をログ出し
add_action('wp_mail_failed', function ($e) {
    error_log('[mu] mail_failed: ' . $e->get_error_message());
});

// Fromを明示（必須ではないが安定）
add_filter('wp_mail_from', fn() => 'no-reply@example.local');
add_filter('wp_mail_from_name', fn() => 'WP Test');

add_action('init', function () {
    if (!isset($_GET['sendmail'])) return;

    $upload = wp_upload_dir();
    $file = $upload['basedir'] . '/sample.txt';
    if (!file_exists($file)) file_put_contents($file, 'Hello MailHog');

    $ok = wp_mail('test@example.com', '添付テスト', '本文です', [], [$file]);
    wp_die($ok ? '送信しました。MailHogで確認してください。' : '送信失敗');
});
