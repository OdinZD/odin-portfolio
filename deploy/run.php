<?php

/**
 * ONE-OFF manual deploy runner for cPanel — bypasses the greyed "Deploy HEAD
 * Commit" button by running the deploy steps directly (this host allows exec()).
 *
 * Token-gated, read/write. DELETE this file when finished.
 *
 * USAGE (upload into public_html/, then hit each URL in order):
 *   https://odinwolf.eu/run.php?key=da30ef434c6347c9&step=sync
 *   https://odinwolf.eu/run.php?key=da30ef434c6347c9&step=composer
 *   https://odinwolf.eu/run.php?key=da30ef434c6347c9&step=app
 *   https://odinwolf.eu/run.php?key=da30ef434c6347c9&step=publish
 * (No step, or step=status, just reports state.)
 */

@set_time_limit(0);
@ignore_user_abort(true);
header('Content-Type: text/plain; charset=utf-8');
while (ob_get_level() > 0) { @ob_end_flush(); }
@ob_implicit_flush(true);

$SECRET = 'da30ef434c6347c9';
if (!hash_equals($SECRET, (string) ($_GET['key'] ?? ''))) {
    http_response_code(403);
    exit("Forbidden. Append ?key=... to the URL.\n");
}

// --- Resolve HOME (web SAPI has it unset), repo path, web root, PHP 8.3 CLI ---
$pw   = function_exists('posix_geteuid') ? posix_getpwuid(posix_geteuid()) : null;
$HOME = $pw['dir'] ?? '/home/odinwolf';
putenv("HOME=$HOME");
putenv("COMPOSER_HOME=$HOME/.composer");
$_ENV['HOME'] = $HOME;

$WEBROOT = __DIR__; // this file lives in public_html

$repo = isset($_GET['path']) ? (string) $_GET['path'] : '';
if ($repo === '') {
    $idx = "$WEBROOT/index.php";
    if (is_file($idx) && preg_match("/\\\$base\\s*=\\s*'([^']+)'/", (string) file_get_contents($idx), $m)) {
        $repo = $m[1];
    }
}
if ($repo === '') { $repo = "$HOME/repositories/odin-portfolio2"; }

$PHP = 'php';
foreach ([
    '/opt/alt/php84/usr/bin/php', '/opt/cpanel/ea-php84/root/usr/bin/php', 'php84', 'ea-php84',
    '/opt/alt/php83/usr/bin/php', '/opt/cpanel/ea-php83/root/usr/bin/php', 'php83', 'ea-php83', 'php',
] as $c) {
    $v = @shell_exec(escapeshellarg($c) . ' -v 2>&1');
    if ($v && preg_match('/PHP 8\.[34]\./', $v)) { $PHP = $c; break; } // prefer newest (8.4) if present
}

function sh(string $cmd): int
{
    echo "\n\$ $cmd\n";
    $out = []; $code = 0;
    @exec($cmd . ' 2>&1', $out, $code);
    echo ($out ? implode("\n", $out) : '(no output)') . "\n[exit $code]\n";
    return $code;
}

$git  = 'git -C ' . escapeshellarg($repo);
$art  = escapeshellarg($PHP) . ' ' . escapeshellarg("$repo/artisan");
$step = isset($_GET['step']) ? (string) $_GET['step'] : 'status';

echo str_repeat('=', 64) . "\n";
echo "MANUAL DEPLOY RUNNER\n";
echo "web SAPI PHP (serves the live site): " . PHP_VERSION . "\n";
echo "repo: $repo\nCLI PHP (used by this runner): $PHP\nHOME: $HOME\nstep: $step\n";
echo str_repeat('=', 64) . "\n";

switch ($step) {
    case 'sync': // clean the working tree + pull latest -> also un-greys cPanel's Deploy
        sh("$git fetch origin --prune");
        sh("$git reset --hard origin/main");
        sh("$git clean -fd");           // removes untracked non-ignored (error_log); keeps .env & vendor (ignored)
        echo "\n>>> working tree after clean (should be empty):\n";
        sh("$git status --porcelain");
        sh("$git log -1 --oneline");
        echo "\nNEXT -> &step=composer\n";
        break;

    case 'composer': // install vendor/
        $cphar = "$HOME/composer.phar";
        if (!is_file($cphar)) {
            if (trim((string) @shell_exec('command -v curl 2>/dev/null')) !== '') {
                sh('curl -sS https://getcomposer.org/download/latest-stable/composer.phar -o ' . escapeshellarg($cphar));
            } elseif (ini_get('allow_url_fopen')) {
                echo "\nDownloading composer.phar via PHP copy()...\n";
                echo @copy('https://getcomposer.org/download/latest-stable/composer.phar', $cphar) ? "downloaded\n" : "DOWNLOAD FAILED\n";
            } else {
                echo "No curl and allow_url_fopen is off — cannot fetch composer.phar.\n";
            }
        } else {
            echo "\ncomposer.phar already present: $cphar\n";
        }
        sh(escapeshellarg($PHP) . ' -d memory_limit=-1 ' . escapeshellarg($cphar)
            . ' install --working-dir=' . escapeshellarg($repo)
            . ' --no-dev --optimize-autoloader --no-interaction --no-scripts');
        sh("$art package:discover --ansi");
        echo "\nvendor/autoload.php now " . (is_file("$repo/vendor/autoload.php") ? 'PRESENT [OK]' : 'STILL MISSING') . "\n";
        echo "\nNEXT -> &step=app\n";
        break;

    case 'app': // key + migrate/seed + caches
        $env = (string) @file_get_contents("$repo/.env");
        if ($env !== '' && !preg_match('/^APP_KEY=base64:/m', $env)) {
            sh("$art key:generate --force");
        } else {
            echo "\nAPP_KEY already set (or .env unreadable) — skipping key:generate\n";
        }
        sh("$art migrate --force --seed");
        sh("$art config:cache");
        sh("$art route:cache");
        sh("$art view:cache");
        sh('/bin/chmod -R 775 ' . escapeshellarg("$repo/storage") . ' ' . escapeshellarg("$repo/bootstrap/cache"));
        echo "\nNEXT -> &step=publish\n";
        break;

    case 'publish': // copy public/ into web root + point index.php at this repo
        // Preserve the live .htaccess (it carries cPanel's PHP handler line).
        $keepHt = is_file("$WEBROOT/.htaccess") ? (string) file_get_contents("$WEBROOT/.htaccess") : null;
        sh('/bin/rm -f ' . escapeshellarg("$WEBROOT/index.html") . ' ' . escapeshellarg("$WEBROOT/index.htm"));
        sh('/bin/rm -rf ' . escapeshellarg("$WEBROOT/build"));
        sh('/bin/cp -R ' . escapeshellarg("$repo/public/.") . ' ' . escapeshellarg("$WEBROOT/"));
        if ($keepHt !== null) {
            file_put_contents("$WEBROOT/.htaccess", $keepHt);
            echo "\n.htaccess preserved (kept the live PHP handler line).\n";
        }
        $tpl = @file_get_contents("$repo/deploy/index.php");
        if ($tpl !== false) {
            file_put_contents("$WEBROOT/index.php", str_replace('__APP_BASE__', $repo, $tpl));
            echo "\nindex.php rewritten -> base = $repo\n";
        } else {
            echo "\nWARNING: could not read $repo/deploy/index.php\n";
        }
        echo "\nDONE. Load https://odinwolf.eu/ — then DELETE run.php and diagnose.php from public_html.\n";
        break;

    case 'phpcheck': // list PHP CLI binaries available on this host + versions
        foreach ([
            '/opt/alt/php84/usr/bin/php', '/opt/cpanel/ea-php84/root/usr/bin/php', 'php84', 'ea-php84',
            '/opt/alt/php83/usr/bin/php', '/opt/cpanel/ea-php83/root/usr/bin/php', 'php83', 'ea-php83', 'php',
        ] as $c) {
            $v = @shell_exec(escapeshellarg($c) . ' -v 2>&1');
            $first = $v ? strtok($v, "\n") : 'not found';
            echo str_pad($c, 44) . $first . "\n";
        }
        echo "\nRunner will use: $PHP\n";
        break;

    case 'webcheck': // what PHP + handler is actually serving the site
        echo "web SAPI version : " . PHP_VERSION . "\n";
        echo "php_sapi_name()  : " . php_sapi_name() . "   (fpm-fcgi = FPM controls version; litespeed/cgi/apache = .htaccess handler controls it)\n";
        $ht = "$WEBROOT/.htaccess";
        $c  = is_file($ht) ? (string) file_get_contents($ht) : '';
        echo "\n--- public_html/.htaccess handler lines ---\n";
        $found = false;
        foreach (explode("\n", $c) as $l) {
            if (stripos($l, 'Handler') !== false || stripos($l, 'x-httpd') !== false || stripos($l, 'ea-php') !== false) { echo "$l\n"; $found = true; }
        }
        echo $found ? "" : "(no PHP handler line — domain falls back to cPanel default)\n";
        break;

    case 'phpfix': // write an ea-php84 handler into .htaccess (for non-FPM hosts)
        $ht  = "$WEBROOT/.htaccess";
        $cur = is_file($ht) ? (string) file_get_contents($ht) : '';
        if (stripos($cur, 'x-httpd-ea-php84') !== false) {
            echo "ea-php84 handler already present in .htaccess — nothing to do.\n";
        } else {
            // strip any older cPanel handler block, then prepend the 8.4 one
            $cur = preg_replace('/# php -- BEGIN cPanel-generated handler.*?# php -- END cPanel-generated handler, do not edit\s*/s', '', $cur);
            $block = "# php -- BEGIN cPanel-generated handler, do not edit\n"
                   . "# Set the \"ea-php84\" package as the default \"PHP\" programming language.\n"
                   . "<IfModule mime_module>\n"
                   . "  AddHandler application/x-httpd-ea-php84 .php .php8 .phtml\n"
                   . "</IfModule>\n"
                   . "# php -- END cPanel-generated handler, do not edit\n\n";
            file_put_contents($ht, $block . $cur);
            echo "Wrote ea-php84 AddHandler to public_html/.htaccess.\n";
        }
        echo "\nNow reload https://odinwolf.eu/ . If it's STILL 8.3, the domain uses PHP-FPM\n";
        echo "and ignores .htaccess — enable PHP-FPM + ea-php84 in MultiPHP Manager instead.\n";
        break;

    default: // status
        sh("ls -la " . escapeshellarg(dirname($repo)));
        sh("$git status --porcelain");
        sh("$git log -1 --oneline");
        echo "\nvendor/autoload.php: " . (is_file("$repo/vendor/autoload.php") ? 'present' : 'MISSING') . "\n";
        echo ".env: " . (is_file("$repo/.env") ? 'present' : 'MISSING') . "\n";
        echo "\nRun in order:\n  &step=sync\n  &step=composer\n  &step=app\n  &step=publish\n";
}
