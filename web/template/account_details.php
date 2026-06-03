<?php
$accountTypes = [
    "User" => __("User"),
    "Trusted User" => __("Trusted User"),
    "Developer" => __("Developer"),
    "Trusted User & Developer" => __("Trusted User & Developer"),
];

$username = htmlspecialchars($row["Username"] ?? "", ENT_QUOTES, 'UTF-8');
$email = htmlspecialchars($row["Email"] ?? "", ENT_QUOTES, 'UTF-8');
$realName = htmlspecialchars($row["RealName"] ?? "", ENT_QUOTES, 'UTF-8');
$ircNick = htmlspecialchars($row["IRCNick"] ?? "", ENT_QUOTES, 'UTF-8');

$homepage = filter_var($row["Homepage"] ?? "", FILTER_VALIDATE_URL);
?>

<table class="arch-bio-entry">
    <tr>
        <td>
            <h3><?= $username ?></h3>

            <table class="bio">
                <tr>
                    <th><?= __("Username") ?>:</th>
                    <td><?= $username ?></td>
                </tr>

                <tr>
                    <th><?= __("Account Type") ?>:</th>
                    <td><?= $accountTypes[$row["AccountType"]] ?? __("Unknown") ?></td>
                </tr>

                <tr>
                    <th><?= __("Email Address") ?>:</th>
                    <td>
                        <?php if (($row["HideEmail"] ?? 0) == 1 && !has_credential(CRED_ACCOUNT_SEARCH)): ?>
                            <em><?= __("hidden") ?></em>
                        <?php else: ?>
                            <a href="mailto:<?= $email ?>"><?= $email ?></a>
                        <?php endif; ?>
                    </td>
                </tr>

                <tr>
                    <th><?= __("Real Name") ?>:</th>
                    <td><?= $realName ?></td>
                </tr>

                <tr>
                    <th><?= __("Homepage") ?>:</th>
                    <td>
                        <?php if ($homepage): ?>
                            <a
                                href="<?= htmlspecialchars($homepage, ENT_QUOTES, 'UTF-8') ?>"
                                rel="nofollow noopener noreferrer"
                                target="_blank">
                                <?= htmlspecialchars($homepage, ENT_QUOTES, 'UTF-8') ?>
                            </a>
                        <?php else: ?>
                            <em><?= __("Not specified") ?></em>
                        <?php endif; ?>
                    </td>
                </tr>

                <tr>
                    <th><?= __("IRC Nick") ?>:</th>
                    <td><?= $ircNick ?></td>
                </tr>

                <tr>
                    <th><?= __("PGP Key Fingerprint") ?>:</th>
                    <td><?= html_format_pgp_fingerprint($row["PGPKey"] ?? "") ?></td>
                </tr>

                <tr>
                    <th><?= __("Status") ?>:</th>
                    <td>
                        <?=
                        !empty($row["InactivityTS"])
                            ? __("Inactive since") . " " .
                              date("Y-m-d H:i", (int)$row["InactivityTS"])
                            : __("Active")
                        ?>
                    </td>
                </tr>

                <tr>
                    <th><?= __("Registration date") ?>:</th>
                    <td>
                        <?php if (!empty($row["RegistrationTS"])): ?>
                            <?= (new DateTime($row["RegistrationTS"]))->format('Y-m-d') ?>
                        <?php else: ?>
                            <?= __("unknown") ?>
                        <?php endif; ?>
                    </td>
                </tr>

                <?php if (has_credential(CRED_ACCOUNT_LAST_LOGIN)): ?>
                <tr>
                    <th><?= __("Last Login") ?>:</th>
                    <td>
                        <?= !empty($row["LastLogin"])
                            ? date("Y-m-d", (int)$row["LastLogin"])
                            : __("Never") ?>
                    </td>
                </tr>
                <?php endif; ?>

                <tr>
                    <th><?= __("Links") ?>:</th>
                    <td>
                        <ul>
                            <li>
                                <a href="<?= get_uri('/packages/') ?>?K=<?= urlencode($row['Username']) ?>&SeB=m">
                                    <?= __("View this user's packages") ?>
                                </a>
                            </li>

                            <?php if (can_edit_account($row)): ?>
                            <li>
                                <a href="<?= get_user_uri($row['Username']) ?>edit">
                                    <?= __("Edit this user's account") ?>
                                </a>
                            </li>
                            <?php endif; ?>

                            <?php if (has_credential(CRED_ACCOUNT_LIST_COMMENTS, [$row['ID']])): ?>
                            <li>
                                <a href="<?= get_user_uri($row['Username']) ?>comments">
                                    <?= __("List this user's comments") ?>
                                </a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
