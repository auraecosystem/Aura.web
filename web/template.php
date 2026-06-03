<?php
// Assume these helpers exist:
// auth_user(), auth_check(), e(), csrf_token(), get_uri(), get_user_uri()

$user = auth_user(); // returns user array or null
$isLoggedIn = $user !== null;

$lang = $LANG ?? 'en';
$titleText = !empty($title) ? " - " . e($title) : "";

$currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
?>

<!DOCTYPE html>
<html lang="<?= e($lang) ?>">
<head>
    <meta charset="UTF-8">

    <title>AURA (<?= e($lang) ?>)<?= $titleText ?></title>

    <link rel="stylesheet" href="/css/archweb.css">
    <link rel="stylesheet" href="/css/aurweb.css">
    <link rel="icon" href="/images/favicon.ico">

    <link rel="alternate" type="application/rss+xml"
          title="Newest Packages RSS"
          href="<?= get_uri('/rss/') ?>">

    <?php if (!empty($details['Description'])): ?>
        <meta name="description" content="<?= e($details['Description']) ?>">
    <?php endif; ?>

    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>

<div id="archnavbar" class="anb-aur">
    <div id="archnavbarlogo">
        <h1><a href="<?= get_uri('/') ?>">Arch Linux User Repository</a></h1>
    </div>

    <nav id="archnavbarmenu">
        <ul id="archnavbarlist">
            <li><a href="https://www.archlinux.org/">Home</a></li>
            <li><a href="https://www.archlinux.org/packages/">Packages</a></li>
            <li><a href="https://bbs.archlinux.org/">Forums</a></li>
            <li><a href="https://wiki.archlinux.org/">Wiki</a></li>
            <li><a href="https://bugs.archlinux.org/">Bugs</a></li>
            <li><a href="https://security.archlinux.org/">Security</a></li>
            <li><a href="<?= get_uri('/') ?>">AUR</a></li>
            <li><a href="https://www.archlinux.org/download/">Download</a></li>
        </ul>
    </nav>
</div>

<div id="content">

<!-- Language Switcher -->
<div id="lang_sub">
    <form method="post" action="">
        <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">

        <fieldset>
            <select name="setlang">
                <?php foreach ($SUPPORTED_LANGS as $code => $name): ?>
                    <option value="<?= e($code) ?>" <?= $code === $lang ? 'selected' : '' ?>>
                        <?= e($name) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit">Go</button>
        </fieldset>
    </form>
</div>

<!-- Main Navbar -->
<div id="archdev-navbar">
    <ul>

        <?php if ($isLoggedIn): ?>

            <li><a href="<?= get_uri('/') ?>">Dashboard</a></li>
            <li><a href="<?= get_uri('/packages/') ?>">Packages</a></li>

            <?php if (has_credential(CRED_PKGREQ_LIST)): ?>
                <li><a href="<?= get_uri('/requests/') ?>">Requests</a></li>
            <?php endif; ?>

            <?php if (has_credential(CRED_ACCOUNT_SEARCH)): ?>
                <li><a href="<?= get_uri('/accounts/') ?>">Accounts</a></li>
            <?php endif; ?>

            <li>
                <a href="<?= get_user_uri($user['Username']) ?>edit/">
                    My Account
                </a>
            </li>

            <?php if (has_credential(CRED_TU_LIST_VOTES)): ?>
                <li><a href="<?= get_uri('/tu/') ?>">Trusted User</a></li>
            <?php endif; ?>

            <li><a href="<?= get_uri('/logout/') ?>">Logout</a></li>

        <?php else: ?>

            <li><a href="<?= get_uri('/') ?>">AUR Home</a></li>
            <li><a href="<?= get_uri('/packages/') ?>">Packages</a></li>
            <li><a href="<?= get_uri('/register/') ?>">Register</a></li>

            <li><a href="<?= get_uri('/login/') ?>">Login</a></li>

        <?php endif; ?>

    </ul>
</div>

<!-- Main Content -->
