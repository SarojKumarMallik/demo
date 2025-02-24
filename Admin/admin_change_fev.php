<?php
define("TITLE", "Tags");
include("Includes/Header.php");

if (isset($_GET['Delete'])) {
    $Delete = ValidateFormData($_GET['Delete']);
    RemoveTags($Delete);
}

?>
<?php
// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "website_db";

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newTitle = $conn->real_escape_string($_POST['title'] ?? '');
    $titleSql = "UPDATE website_meta SET meta_value = '$newTitle' WHERE meta_key = 'title'";
    if ($conn->query($titleSql) === TRUE) {
        $message = "Title updated successfully!";
    } else {
        $message = "Error updating title: " . $conn->error;
    }

    if (isset($_FILES['favicon']) && $_FILES['favicon']['error'] === UPLOAD_ERR_OK) {
        // Read the file content and convert it to Base64
        $fileContent = file_get_contents($_FILES['favicon']['tmp_name']);
        $base64Favicon = base64_encode($fileContent);

        // Update database with new favicon Base64 string
        $faviconSql = "UPDATE website_meta SET meta_value = '$base64Favicon' WHERE meta_key = 'favicon'";
        if ($conn->query($faviconSql) === TRUE) {
            $message .= " Favicon updated successfully!";
        } else {
            $message .= " Error updating favicon in database: " . $conn->error;
        }
    }
}

// Fetch current values
$sqlTitle = "SELECT meta_value FROM website_meta WHERE meta_key = 'title' LIMIT 1";
$currentTitle = ($resultTitle = $conn->query($sqlTitle)) ? $resultTitle->fetch_assoc()['meta_value'] : "Default Title";

$sqlFavicon = "SELECT meta_value FROM website_meta WHERE meta_key = 'favicon' LIMIT 1";
$currentFaviconBase64 = ($resultFavicon = $conn->query($sqlFavicon)) ? $resultFavicon->fetch_assoc()['meta_value'] : null;
$currentFavicon = $currentFaviconBase64 ? 'data:image/x-icon;base64,' . $currentFaviconBase64 : null;

// Close the connection
$conn->close();
?>
<!-- ============================================================== -->
<!-- Page Content -->
<!-- ============================================================== -->
<div
    style="display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; padding: 0; font-family: 'Poppins', sans-serif;">
    <div
        style="background: #ffffff; padding: 30px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); width: 100%; max-width: 400px; text-align: center;">
        <h1 style="font-size: 24px; color: #333; margin-bottom: 20px;">Manage Website Settings</h1>

        <?php if ($message): ?>
            <div
                style="margin-bottom: 16px; padding: 12px; border-radius: 8px; font-size: 14px; color: white; background: <?php echo strpos($message, 'Error') !== false ? '#dc3545' : '#28a745'; ?>;">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="" enctype="multipart/form-data">
            <label for="title"
                style="font-size: 14px; color: #555; text-align: left; display: block; margin-bottom: 8px; font-weight: 600;">Website
                Title:</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($currentTitle); ?>"
                placeholder="Enter website title" required
                style="width: 100%; padding: 12px; font-size: 14px; border: 1px solid #ddd; border-radius: 8px; margin-bottom: 16px; box-sizing: border-box; transition: border-color 0.3s ease, box-shadow 0.3s ease;">

            <label for="favicon"
                style="font-size: 14px; color: #555; text-align: left; display: block; margin-bottom: 8px; font-weight: 600;">Website
                Favicon:</label>
            <input type="file" id="favicon" name="favicon" accept="image/x-icon, image/png"
                style="width: 100%; padding: 12px; font-size: 14px; border: 1px solid #ddd; border-radius: 8px; margin-bottom: 16px; box-sizing: border-box; transition: border-color 0.3s ease, box-shadow 0.3s ease;">

            <?php if ($currentFavicon): ?>
                <div style="margin-top: 16px; text-align: center;">
                    <p style="font-size: 12px; color: #666; margin-top: 8px;">Current Favicon:</p>
                    <img src="<?php echo htmlspecialchars($currentFavicon); ?>" alt="Current Favicon"
                        style="width: 48px; height: 48px; border-radius: 6px; border: 1px solid #ddd;">
                </div>
            <?php endif; ?>

            <button type="submit"
                style="width: 100%; padding: 14px; background: linear-gradient(135deg, #6c63ff, #5a58d8); color: white; font-size: 16px; font-weight: bold; border: none; border-radius: 8px; cursor: pointer; transition: background 0.3s ease, transform 0.2s ease;"
                onmouseover="this.style.background = 'linear-gradient(135deg, #5a58d8, #6c63ff)'; this.style.transform = 'translateY(-2px)';"
                onmouseout="this.style.background = 'linear-gradient(135deg, #6c63ff, #5a58d8)'; this.style.transform = 'none';">
                Save Changes
            </button>
        </form>
    </div>
</div>

<!-- ============================================================== -->
<!-- End Page Content -->
<!-- ============================================================== -->

<?php

include("Includes/Footer.php");

?>

<script>
    //Remove Parameters                                     
    $(document).ready(function () {
        var uri = window.location.toString();
        if (uri.indexOf("?") > 0) {
            var clean_uri = uri.substring(0, uri.indexOf("?"));
            window.history.replaceState({}, document.title, clean_uri);
        }
    });
</script>