<?php
include_once 'header.php';
include 'db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    // Retrieve form data
    $user_id = $_POST['user_id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    
    // Update user record in the database
    $stmt = $conn->prepare("UPDATE user SET first_name=?, last_name=?, username=?, email=? WHERE user_id=?");
    $stmt->bind_param("sssss", $firstname, $lastname, $username, $email, $user_id);
    $stmt->execute();
    $stmt->close();

    header('Location:admin.php?stat=Updated_successfully');
    exit();
}

// Fetch user information for display
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM user WHERE user_id = ?");
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
}
?>


        <p class="nav_logo1">Admin Dashboard</p>
        <ul class="nav_items">
          <li class="nav_item">
            <a href="admin.php"><button class="button2">Home</button></a>
            <button class="button2" id="logoutBtn">Logout</button>
          </li>
        </ul>
      </nav>
    </header>
    <main class="body1">
      <main class="table" data-aos="zoom-in">
        <section class="table_header">
          <h1>Edit User</h1>
        </section>
        <section class="table_body">
          <table>
              <thead>
                  <tr>
                    <th>User ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Action</th>
                  </tr>
              </thead>
              <tbody>
                <tr>
                  <form id="editForm" action="edit_user.php" method="post">
                    <td><?php echo isset($user['user_id']) ? htmlspecialchars($user['user_id']) : ''; ?></td>
                    <td><input type="text" class="rounded-input" name="firstname" id="firstname" value="<?php echo isset($user['first_name']) ? htmlspecialchars($user['first_name']) : ''; ?>" required></td>
                    <td><input type="text" class="rounded-input" name="lastname" id="lastname" value="<?php echo isset($user['last_name']) ? htmlspecialchars($user['last_name']) : ''; ?>" required></td>
                    <td><input type="text" class="rounded-input" name="username" id="username" value="<?php echo isset($user['username']) ? htmlspecialchars($user['username']) : ''; ?>" required></td>
                    <td><input type="email" class="rounded-input" name="email" id="email" value="<?php echo isset($user['email']) ? htmlspecialchars($user['email']) : ''; ?>" required></td>
                    <td><a href="#" id="updateLink">Update</a></td>
                    <input type="hidden" name="user_id" value="<?php echo isset($user['user_id']) ? htmlspecialchars($user['user_id']) : ''; ?>">
                  </form>
                </tr>
              </tbody>
          </table>
        </section>
      </main>
    </main>
  
  <script>
    document.getElementById("updateLink").addEventListener("click", function(event) {
        event.preventDefault();
        document.getElementById('editForm').submit();
    });
  </script>


<?php
include_once 'footer.php';
$conn->close();
?>
