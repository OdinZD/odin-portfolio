<?php

/**
 * ONE-OFF cPanel deploy diagnostic — read-only, changes nothing.
 *
 * WHY: cPanel's "Deploy HEAD Commit" button is greyed out. This probe reports the
 * exact state of the server clone (branch vs detached HEAD, dirty working tree,
 * .cpanel.yml presence, stuck deploy logs) so we can see what blocks deployment.
 *
 * HOW TO USE (no terminal needed):
 *   1. Upload this file into public_html/ via cPanel File Manager.
 *   2. Visit:  https://odinwolf.eu/diagnose.php?key=da30ef434c6347c9
 *   3. Copy the whole plain-text output back to me.
 *   4. DELETE this file from public_html/ afterwards.
 */

header('Content-Type: text/plain; charset=utf-8');

$SECRET = 'da30ef434c6347c9';
if (!hash_equals($SECRET, (string) ($_GET['key'] ?? ''))) {
    http_response_code(403);
    exit("Forbidden. Append ?key=... to the URL.\n");
}

function line(string $label, string $value = ''): void { echo str_pad($label, 28) . $value . "\n"; }
function hr(): void { echo str_repeat('-', 64) . "\n"; }

// --- Resolve the app/repo path -----------------------------------------------
$repo = isset($_GET['path']) ? (string) $_GET['path'] : '';
if ($repo === '') {
    $idx = __DIR__ . '/index.php';
    if (is_file($idx) && preg_match("/\\\$base\\s*=\\s*'([^']+)'/", (string) file_get_contents($idx), $m)) {
        $repo = $m[1];
    }
}
if ($repo === '') {
    $repo = (getenv('HOME') ?: '') . '/repositories/odin-portfolio';
}

hr(); echo "cPANEL DEPLOY DIAGNOSTIC\n"; hr();
line('Time (UTC):', gmdate('Y-m-d H:i:s'));
line('PHP version:', PHP_VERSION);
line('Running as user:', function_exists('posix_geteuid') ? (posix_getpwuid(posix_geteuid())['name'] ?? '?') : get_current_user());
line('HOME:', (string) (getenv('HOME') ?: '(unset)'));
line('Script dir:', __DIR__);
line('Resolved repo path:', $repo);
line('Repo dir exists:', is_dir($repo) ? 'yes' : 'NO');
line('.git dir exists:', is_dir("$repo/.git") ? 'yes' : 'NO');

// --- exec availability -------------------------------------------------------
$disabled = array_filter(array_map('trim', explode(',', (string) ini_get('disable_functions'))));
$canExec  = function_exists('exec')       && !in_array('exec', $disabled, true);
$canShell = function_exists('shell_exec') && !in_array('shell_exec', $disabled, true);
$canProc  = function_exists('proc_open')  && !in_array('proc_open', $disabled, true);
line('exec() available:', $canExec ? 'yes' : 'no');
line('shell_exec() available:', $canShell ? 'yes' : 'no');
line('proc_open() available:', $canProc ? 'yes' : 'no');
if ($disabled) { line('disable_functions:', implode(',', $disabled)); }

$run = function (string $cmd) use ($canExec, $canShell, $canProc): ?string {
    if ($canExec)  { $out = []; @exec($cmd . ' 2>&1', $out); return implode("\n", $out); }
    if ($canShell) { return (string) @shell_exec($cmd . ' 2>&1'); }
    if ($canProc)  {
        $p = @proc_open($cmd . ' 2>&1', [1 => ['pipe', 'w']], $pipes);
        if (is_resource($p)) { $o = (string) stream_get_contents($pipes[1]); fclose($pipes[1]); proc_close($p); return $o; }
    }
    return null;
};

// --- Filesystem state (works even if exec is disabled) -----------------------
hr(); echo "FILESYSTEM STATE (no exec needed)\n"; hr();
line('vendor/autoload.php:', is_file("$repo/vendor/autoload.php") ? 'present' : 'MISSING');
line('.env:', is_file("$repo/.env") ? 'present' : 'MISSING');
line('.cpanel.yml on disk:', is_file("$repo/.cpanel.yml") ? 'present' : 'MISSING');
line('composer.phar (in repo):', is_file("$repo/composer.phar") ? 'PRESENT (would dirty the tree!)' : 'absent');

// --- .git/HEAD: branch vs detached (a classic greying cause) -----------------
$headFile = "$repo/.git/HEAD";
if (is_file($headFile)) {
    $head = trim((string) file_get_contents($headFile));
    if (str_starts_with($head, 'ref:')) {
        line('HEAD state:', 'on branch -> ' . trim(substr($head, 4)));
    } else {
        line('HEAD state:', 'DETACHED -> ' . $head . '  <-- can grey out Deploy');
    }
}
$branchDir = "$repo/.git/refs/heads";
if (is_dir($branchDir)) {
    $branches = array_values(array_filter(scandir($branchDir) ?: [], fn ($f) => $f[0] !== '.'));
    line('local branches:', implode(', ', $branches) ?: '(none)');
}

// --- Git commands (if exec available) ----------------------------------------
hr(); echo "GIT STATE\n"; hr();
if ($canExec || $canShell || $canProc) {
    $gitBin = 'git';
    foreach (['git', '/usr/local/cpanel/3rdparty/bin/git', '/usr/bin/git', '/bin/git'] as $cand) {
        $v = $run(escapeshellarg($cand) . ' --version');
        if ($v !== null && stripos($v, 'git version') !== false) { $gitBin = $cand; break; }
    }
    line('git binary:', $gitBin . '  (' . trim((string) $run(escapeshellarg($gitBin) . ' --version')) . ')');
    $git = escapeshellarg($gitBin) . ' -C ' . escapeshellarg($repo);

    foreach ([
        'branch (abbrev)'        => "$git rev-parse --abbrev-ref HEAD",
        'symbolic-ref (empty=detached)' => "$git symbolic-ref -q HEAD",
        'HEAD commit'            => "$git log -1 --pretty=%h\\ %s",
        'upstream tracking'      => "$git rev-parse --abbrev-ref --symbolic-full-name '@{u}'",
        'remote origin'          => "$git config --get remote.origin.url",
        '.cpanel.yml at HEAD'    => "$git ls-tree -r --name-only HEAD -- .cpanel.yml",
    ] as $label => $cmd) {
        line($label . ':', trim((string) $run($cmd)));
    }

    echo "\n>>> git status --porcelain  (ANY line below = dirty tree = greyed Deploy):\n";
    $status = (string) $run("$git status --porcelain");
    echo ($status === '') ? "    (clean — no uncommitted changes)\n" : $status . "\n";
} else {
    echo "exec/shell_exec/proc_open all disabled — cannot run git directly.\n";
    echo "Rely on the FILESYSTEM STATE + HEAD reads above.\n";
}

// --- cPanel deploy logs (spot a stuck/errored deploy) ------------------------
hr(); echo "cPANEL DEPLOY LOGS (newest first — look for stuck/errored deploy)\n"; hr();
$logDir = (getenv('HOME') ?: '') . '/.cpanel/logs';
if (is_dir($logDir)) {
    $files = glob("$logDir/*") ?: [];
    usort($files, fn ($a, $b) => filemtime($b) <=> filemtime($a));
    $shown = 0;
    foreach ($files as $f) {
        $base = basename($f);
        if (stripos($base, 'deploy') === false && stripos($base, 'git') === false && stripos($base, 'version') === false) {
            continue;
        }
        line('log:', $base . '  (' . gmdate('Y-m-d H:i', (int) filemtime($f)) . ' UTC)');
        echo "----- last 25 lines -----\n";
        $lines = @file($f, FILE_IGNORE_NEW_LINES) ?: [];
        echo ($lines ? implode("\n", array_slice($lines, -25)) : '(empty)') . "\n\n";
        if (++$shown >= 3) { break; }
    }
    if ($shown === 0) { echo "(no deploy/git logs found in $logDir)\n"; }
} else {
    line('log dir:', "$logDir not found");
}

hr(); echo "DONE. Now DELETE public_html/diagnose.php.\n"; hr();
