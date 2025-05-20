<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__ . '../../config/db_connection.php';
require_once __DIR__ . '../../classes/controller/PortalUserController.php';

$userController = new PortalUserController($mysqli);

$username = $_SESSION['username'];
$role_id = $userController->getPermission($_SESSION['username']);

// Return the role description
function getRoleDescription($role_id)
{
    switch ($role_id) {
        case 1:
            return "Administrator";
        case 2:
            return "Incident Reporter";
        case 3:
            return "Incident Responder";
        default:
            return "Unknown Role";
    }
}

// Load all users
if (assert($role_id) && assert($username)) {
    $users = $userController->getAllUsers($role_id, $username);
}

// handle request to register a new user
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create_user') {
    var_dump($_POST);
    $new_username = trim($_POST['username']);
    $new_password = $_POST['password'];
    $new_email = trim($_POST['email']);
    $new_role_id = intval($_POST['role_id']);

    $userController->register($new_username, $new_password, $new_email, $new_role_id);

    header("Location: " . $_SERVER['PHP_SELF'] . "?section=users");
}

// handle request to delete an user
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    // var_dump($_GET['id']);
    $userController->deleteUser($_GET['id']);
    header("Location: " . $_SERVER['PHP_SELF'] . "?section=users");    

}


?>
<style>
    @import url('../css/global.css');

    section {
        display: block;
    }
    .user_container{
        background-color: white;
    }

    table {
        border-collapse: collapse;
        width: 98%;
        margin: 20px auto;
    }

    th,
    td {
        padding: 5px;
        text-align: left;
    }

    tr:nth-child(odd) {
        background-color:#f4f3f3;
    }

    tr:nth-child(even) {
        background-color: #eaeaea;
    }

    th {
        background-color: var(--primary);
    }

    h1.user_h1 {
        font-size: x-large;
        padding: 12px 0px 0px 12px;
    }
    p.user_management{
        padding: 5px 0px 0px 12px;
    }

    h2.user_h2 {
        font-size: larger;
        padding: 12px 0px 0px 12px;
    }

    .table_actions {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 15px;
    }

    a.table_actions_a {
        padding: 0;
        margin: 0;
        font-size: 14px;
    }

    button.table_actions_button {
        padding: 5px;
        border: none;
        border-radius: 15%;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 2px;
    }

    button.table_actions_button:hover {
        cursor: pointer;
    }

    .actions_delete {
        background-color: oklch(70.4% 0.191 22.216);
    }

    .actions_delete:hover {
        background-color: oklch(63.7% 0.237 25.331);
    }

    .actions_edit {
        background-color: oklch(79.2% 0.209 151.711);
    }

    .actions_edit:hover {
        background-color: oklch(72.3% 0.219 149.579);

    }

    img.user_icon {
        width: 1.25rem;
        height: 1.25rem;
    }

    button.add_user_btn{
        padding: 12px 16px; 
        color: black; 
        border: none; 
        border-radius: 5px;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        background-color: var(--primary);
    }
    
    button.add_user_btn:hover{
        cursor: pointer;
        background-color: #a49e8e;
    }
    
    button.primary_button{
        background-color: var(--primary); 
    }
    
    button.primary_button:hover{
        background-color: #a49e8e;
        cursor: pointer;
    }
    
    button.red_button{
        background-color: oklch(70.4% 0.191 22.216);
    }
    
    button.red_button:hover {
        background-color: oklch(63.7% 0.237 25.331);
    }
    
    .user_modal_inputs{
        width: 90%;
        border-radius: 10px;
        border: none;
        outline: none;
        padding: 15px;
        background-color: #eaeaea;
        margin-top: 10px;
    }
    
    div.user_modal_container{
        background-color: white; 
        padding: 20px; 
        border-radius: 8px; 
        min-width: 300px;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
    }

    div.user_modal{
        display: none; 
        position: fixed; 
        top: 0; 
        left: 0; 
        width: 100%; 
        height: 100%;
        background: rgba(0, 0, 0, 0.5); 
        justify-content: center; 
        align-items: center;
    }

    #user_role_select{
        width: 50%;
    }

    .users_modal_btn_container{
        display: flex; 
        justify-content: flex-end; 
        gap: 10px;
    }

</style>
<section class="user_container">
    <h1 class="user_h1">User Management</h1>
    <p class="user_management">Welcome, here you can visualize, create and delete users from the system.</p>
    <p class="user_management">Click on the button "Add New User" to create a new account.</p>
    <?php if (!empty($users)): ?>
        <div style="text-align: right; padding: 0 20px;">
            <button onclick="openModal()" class="add_user_btn">
                + Add New User
            </button>
        </div>
        <table>
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th style="text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Render users -->
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['user_id']) ?></td>
                        <td><?= htmlspecialchars($user['username']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= htmlspecialchars(getRoleDescription($user['role_id'])) ?></td>
                        <td class="table_actions">
                            <button class="table_actions_button actions_delete">
                                <img src="/project/assets/trash_icon.svg" alt="trashcan" class="user_icon">
                                <a class="table_actions_a" 
                                    href="/project/classes/view/dashboard.php?section=users&action=delete&id=<?= $user['user_id'] ?>" 
                                    onclick="return confirm('Are you sure that you want to delete this user?')">
                                    Delete
                                </a>

                            </button>
                        </td>
                    </tr>
                    
                    <?php endforeach; ?>

                    <div id="userModal" class="user_modal">

                        <div class="user_modal_container">
                            <h2>Add New User</h2>
                            <form method="POST">
                                <input type="hidden" name="action" value="create_user">

                                <label class="user_modal_label">Username:</label><br>
                                <input type="text" name="username" class="user_modal_inputs" required><br><br>

                                <label class="user_modal_label">Password:</label><br>
                                <input type="password" name="password" class="user_modal_inputs" required><br><br>

                                <label class="user_modal_label">Email:</label><br>
                                <input type="email" name="email" class="user_modal_inputs" required><br><br>

                                <label class="user_modal_label">Role:</label><br>
                                <select name="role_id" required class="user_modal_inputs" id="user_role_select">
                                    <option value="1">Administrator</option>
                                    <option value="2">Incident Reporter</option>
                                    <option value="3">Incident Responder</option>
                                </select><br><br>

                                <div class="users_modal_btn_container">
                                    <button type="button" onclick="closeModal()" class="add_user_btn red_button">Cancel</button>
                                    <button type="submit" class="primary_button add_user_btn" >Create</button>
                                </div>
                            </form>
                        </div>
                    </div>
            </tbody>
        </table>
    <?php else: ?>
        <p style="text-align: center;">No users found.</p>
    <?php endif; ?>
</section>
<script>
    function openModal() {
        document.getElementById('userModal').style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('userModal').style.display = 'none';
    }

    window.addEventListener('click', function(event) {
        const modal = document.getElementById('userModal');
        if (event.target === modal) {
            closeModal();
        }
    });
</script>