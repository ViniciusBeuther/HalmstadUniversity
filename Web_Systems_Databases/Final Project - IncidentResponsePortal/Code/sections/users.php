<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__ . '../../config/db_connection.php';
require_once __DIR__ . '../../classes/controller/PortalUserController.php';

$userController = new PortalUserController($mysqli);

$username = $_SESSION['username'];
$role_id = $userController->getPermission($_SESSION['username']);

if(assert($role_id) && assert($username)){
    $users = $userController->getAllUsers($role_id, $username);
}
?>
<style>
    @import url('../css/global.css');
    section{
        display: block;
    }
    table {
            border-collapse: collapse;
            width: 98%;
            margin: 20px auto;
        }
        th, td {
            padding: 5px;
            border: 1px solid #ccc;
            text-align: left;
        }
        tr:nth-child(odd){
            background-color:#f0f0f0;
        }
        tr:nth-child(even){
            background-color:#eaeaea;
        }
        th {
            background-color: var(--primary);
        }
        h1.user_h1{
            font-size: x-large;
            padding: 12px 0px 0px 12px;
        }
        h2.user_h2{
            font-size: larger;
            padding: 12px 0px 0px 12px;
        }
        .table_actions{
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
        }
        a.table_actions_a{
            padding: 0;
            margin: 0;
            font-size: 14px;
        }
        button.table_actions_button{
            padding: 10px;
            border: none;
            border-radius: 15%;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 2px;
        }
        button.table_actions_button:hover{
            cursor: pointer;
        }
        .actions_delete{
            background-color: oklch(70.4% 0.191 22.216);
        }
        .actions_delete:hover{
            background-color: oklch(63.7% 0.237 25.331);

        }
        .actions_edit{
            background-color:oklch(79.2% 0.209 151.711);
        }
        .actions_edit:hover{
            background-color:oklch(72.3% 0.219 149.579);

        }
        img.user_icon{
            width: 1.25rem;
            height: 1.25rem;
        }
</style>
<section class="user_container">
    <h1 class="user_h1">User Management</h1>
    <h2 class="user_h2">List of users</h2>

    <?php if (!empty($users)): ?>
        <table>
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['user_id']) ?></td>
                        <td><?= htmlspecialchars($user['username']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= htmlspecialchars($user['role_id']) ?></td>
                        <td class="table_actions">
                            <button class="table_actions_button actions_edit">
                                <img src="/project/assets/pencil_icon.svg" alt="pencil" class="user_icon">
                                <a class="table_actions_a" href="?action=edit&id=<?= $user['user_id'] ?>">Edit</a>
                            </button>
                            <button class="table_actions_button actions_delete">
                                <img src="/project/assets/trash_icon.svg" alt="trashcan" class="user_icon">
                                <a class="table_actions_a" href="?action=delete&id=<?= $user['user_id'] ?>" onclick="return confirm('Are you sure that you want to delete this user?')">Delete</a>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="text-align: center;">No users found.</p>
    <?php endif; ?>
</section>