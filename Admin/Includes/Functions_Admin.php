<?php
include("../Includes/Connection.php");

#Functions_Admin.php For Functioning and Linking or Interacting Admin Panel / Backend Contents with Databse Including Crud Operations


date_default_timezone_set("Asia/Karachi");


//Login User /Admin/Login
if (isset($_POST['Login'])) {
    $Email = $_POST['Email'];
    $Password = $_POST['Password'];

    if (!$Email) {
        $EmailError = "<p class='text-danger'>Please Enter Your Email</p>";
    } //!$Email
    else {
        $Email = ValidateFormData($Email);
    }

    if (!$Password) {
        $PasswordError = "<p class='text-danger'>Please Enter Your Password</p>";
    } //!$Password

    if (!empty($_POST['RememberMe'])) {
        $RememberMe = $_POST['RememberMe'];
    } //!empty($_POST['RememberMe'])

    if ($Email && $Password) {
        $Query = "SELECT * FROM account WHERE Email = '$Email'";
        $Result = $Connection->query($Query);

        if ($Result->num_rows > 0) {
            while ($Row = $Result->fetch_assoc()) {
                $SessionEmail = $Row['Email'];
                $SessionID = $Row['ID'];
                $SessionName = $Row['Username'];
                $HashPassword = $Row['Password'];

                //Verify Password
                if (password_verify($Password, $HashPassword)) {  // Using password_verify for hashing compatibility
                    session_start();
                    $_SESSION['LoggedInEmail'] = $SessionEmail;
                    $_SESSION['LoggedInName'] = $SessionName;
                    $_SESSION['LoggedInID'] = $SessionID;

                    //Remember Me Functionality
                    if (!isset($RememberMe)) {
                        //Cookie for 24 Hours
                        $OneDayCookie = time() + (24 * 60 * 60);
                        setcookie('LoggedIn', $_SESSION['LoggedInEmail'], $OneDayCookie);
                        setcookie('LoggedInEmail', $_SESSION['LoggedInEmail'], $OneDayCookie);
                        setcookie('LoggedInName', str_rot13($_SESSION['LoggedInName']), $OneDayCookie);
                        setcookie('LoggedInID', str_rot13($_SESSION['LoggedInID']), $OneDayCookie);
                    } else {
                        //Cookie for one Week
                        $OneWeekCookie = time() + (7 * 24 * 60 * 60);
                        setcookie('RememberMeLogIn', $_SESSION['LoggedInEmail'], $OneWeekCookie);
                        setcookie('LoggedInEmail', $_SESSION['LoggedInEmail'], $OneWeekCookie);
                        setcookie('LoggedInName', str_rot13($_SESSION['LoggedInName']), $OneWeekCookie);
                        setcookie('LoggedInID', str_rot13($_SESSION['LoggedInID']), $OneWeekCookie);
                    }

                    header("Location: index.php");
                    die();
                } else {
                    // Invalid password
                    $LoginError = "<p class='text-danger'>Incorrect Password. Please try again.</p>";
                }
            } // $Row = $Result->fetch_assoc()
        } else {
            // No account found with the provided email
            $LoginError = "<p class='text-danger'>Incorrect Email or Password. Please try again.</p>";
        }
    } // $Email && $Password
} // isset($_POST['Login'])

//Register New User
// Check if the registration form is submitted
if (isset($_POST['register'])) {
    // Get the form inputs
    $Fullname = $_POST['Fullname'];
    $Email = $_POST['Email'];
    $Username = $_POST['Username'];
    $Phone = $_POST['Phone'];
    $Country = $_POST['Country'];
    $Role = $_POST['Role'];
    $Password = $_POST['Password'];

    // Hash the password
    $hashed_password = password_hash($Password, PASSWORD_DEFAULT);

    // Check if user already exists
    $sql = "SELECT * FROM account WHERE Email = ? OR Username = ?";
    $stmt = $Connection->prepare($sql);
    $stmt->bind_param("ss", $Email, $Username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $error_message = "Email or Username already exists!";
    } else {
        // Insert new user into the database
        $sql = "INSERT INTO account (Fullname, Email, Username, Phone, Country, Role, Password) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $Connection->prepare($sql);
        $stmt->bind_param("sssssss", $Fullname, $Email, $Username, $Phone, $Country, $Role, $hashed_password);

        if ($stmt->execute()) {
            // Redirect or show success message
            $_SESSION['success_message'] = "Registration successful! You can now log in.";
            header("Location: login.php");
            exit();
        } else {
            $error_message = "Error: " . $stmt->error;
        }
    }
}


//Form Validation / XSS / SQLi
function ValidateFormData($FormData)
{
    $FormData = trim(stripslashes(htmlspecialchars(strip_tags(str_replace(array('(', ')'), '', $FormData)), ENT_QUOTES)));
    return $FormData;
}


//Grab Image From Gravatar
function GravatarImage($Email)
{
    $Size = 200;
    $Default = "";
    $Grav_Url = "https://www.gravatar.com/avatar/" . md5(strtolower(trim($Email))) . "?d=" . urlencode($Default) . "&s=" . $Size;
    return $Grav_Url;
}

//Insert Tags to Databse in /Admin/Tags
if (isset($_POST['Submit'])) {
    $Tag = $_POST['Tag'];

    if (!$Tag) {
        $TagError = "<p class='text-danger'>Please Add Tag</p>";
    } //!$Tag
    else {
        $Tag = ValidateFormData($Tag);

        //Insert Tag to Database
        $Query = "INSERT INTO tags(Tag) VALUES('$Tag')";
        if ($Connection->query($Query) === TRUE) {
            $TagsMessage = '<div class="animated bounceInDown alert alert-success alert-dismissible show" role="alert"><strong>' . $Tag . '</strong> Added Successfully.<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
        } //$Connection->query($Query) === TRUE
        else {
            $TagsMessage = '<div class="animated bounceInDown alert alert-warning alert-dismissible show" role="alert"> Error: ' . $Connection->error . '<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
        }
    }
} //isset($_POST['Submit'])


//Displaying and Showing Tags in /Admin/Tags
function DisplayTags()
{
    global $Connection;

    //Select All Tags From Databse
    $Query = "SELECT * FROM tags";
    $Result = $Connection->query($Query);

    if ($Result->num_rows > 0) {

        while ($Row = $Result->fetch_assoc()) {
            echo '<div class="col-sm-6 col-md-4 col-lg-3"><i class="fa fa-tag"></i>' . $Row['Tag'] . '<a href="?Delete=' . $Row['Tag_ID'] . '"><i class="fa fa-times DelTag" title="Delete Tag"></i></a></div>';
        } //$Row = $Result->fetch_assoc()
    } //$Result->num_rows > 0
}


//Remove Tags /Admin/Tags
function RemoveTags($Delete)
{
    global $Connection;

    //Delete Tag From Databse
    $Query = "DELETE FROM tags WHERE Tag_ID = '$Delete'";
    if ($Connection->query($Query) === TRUE) {
        global $TagsMessage;
        $TagsMessage = '<div class="animated bounceInDown alert alert-success alert-dismissible show" role="alert">Tag Removed Successfully.<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
    } //$Connection->query($Query) === TRUE
    else {
        $TagsMessage = '<div class="animated bounceInDown alert alert-warning alert-dismissible show" role="alert"> Error: ' . $Connection->error . '<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
    }
}




//Update Footer Link & Footer Text /Admin/Settings
if (isset($_POST['UpdateFooter'])) {

    $FooterText = $_POST['FooterText'];
    $FooterLink = $_POST['FooterLink'];

    if (!$FooterText) {
        $FooterTextError = "<p class='text-danger'>Please Add Footer Text</p>";
    } //!$FooterText
    else {
        $FooterText = ValidateFormData($FooterText);
    }

    if (!$FooterLink) {
        $FooterLinkError = "<p class='text-danger'>Please Add Footer Link</p>";
    } //!$FooterLink
    else {
        $FooterLink = ValidateFormData($FooterLink);
    }

    if ($FooterText && $FooterLink) {
        //Update Footer In Database
        $Query = "UPDATE homepage SET Homepage_Footer_Link = '$FooterLink', Homepage_Footer_Text='$FooterText'";
        if ($Connection->query($Query) === TRUE) {
            $SettingsMsg = '<div class="animated bounceInDown alert alert-success alert-dismissible show" role="alert">Footer Updated Successfully.<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
        } //$Connection->query($Query) === TRUE
        else {
            $SettingsMsg = '<div class="animated bounceInDown alert alert-warning alert-dismissible show" role="alert"> Error: ' . $Connection->error . '<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
        }

    } //$FooterText && $FooterLink
} //isset($_POST['UpdateFooter'])


//Display  Contents /Admin/Settings
function DisplayHomepageSettings()
{
    global $Connection;
    global $Description;
    global $FooterLink;
    global $FooterText;
    global $Name;
    global $Img;
    global $Msg;

    $Query = "SELECT * FROM homepage";
    $Result = $Connection->query($Query);

    if ($Result->num_rows > 0) {
        while ($Row = $Result->fetch_assoc()) {
            $Description = $Row['Homepage_Description'];
            $Img = $Row['Homepage_Image'];
            $Name = $Row['Homepage_Name'];
            $Msg = $Row['Homepage_Message'];
            $FooterLink = $Row['Homepage_Footer_Link'];
            $FooterText = $Row['Homepage_Footer_Text'];
        } //$Row = $Result->fetch_assoc()
    } //$Result->num_rows > 0
}


//Save Favicon to Folder /Admin/Settings
if (isset($_POST['UpdateFavicon'])) {
    $Favicon = $_POST['Favicon'];
    $Headers = get_headers($Favicon, 1);

    //URL Check and Image Validation Check
    if (filter_var($Favicon, FILTER_VALIDATE_URL) && strpos($Headers['Content-Type'], 'image/') !== false) {
        $Content = file_get_contents($Favicon);
        $SaveFav = 'plugins/images/favicon.png';

        //Save Favicon in Directory.
        if (file_put_contents($SaveFav, $Content)) {
            $SettingsMsg = '<div class="animated bounceInDown alert alert-success alert-dismissible show" role="alert">Favicon Updated Successfully. Please Refresh Browser or clear cache and cookies.<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
        } //file_put_contents($SaveFav, $Content)
    } //filter_var($Favicon, FILTER_VALIDATE_URL) && strpos($Headers['Content-Type'], 'image/') !== false
    else {
        $FaviconError = "<p class='text-danger'>Please Only Use Image URL for Favicon.</p>";
    }
} //isset($_POST['UpdateFavicon'])


//Update User Profile Details /Admin/Profile
if (isset($_POST['UpdateUserProfile'])) {

    $Name = $_POST['Fullname'];
    //$Email      = $_POST['Email'];
    $Phone = $_POST['Phone'];
    $Country = $_POST['Country'];

    /* //Get Email From Databse
    $DBEmail     = ValidateFormData($Email);
    $QueryEmail  = "SELECT * FROM account WHERE Email = '$DBEmail'";
    $ResultEmail = $Connection->query($QueryEmail);*/


    if (!$Name) {
        $NameError = "<p class='text-danger'>Please Enter Your Name</p>";
    } //!$Name
    else {
        $Name = ValidateFormData($Name);
    }

    /*  //Check if whether Emails Exists or not.
    if(!$Email){
    $EmailError = "<p class='text-danger'>Please Enter Your Email</p>";
    } elseif(!filter_var($Email, FILTER_VALIDATE_EMAIL)){
    $EmailError = "<p class='text-danger'>Please Use Valid Email</p>";
    } elseif($ResultEmail->num_rows > 0){
    $EmailError = "<p class='text-danger'>Account With This Email Already Exists. Please Try Another One.</p>";
    } else {
    $Email = ValidateFormData($Email);
    }  */

    if (!$Phone) {
        $PhoneError = "<p class='text-danger'>Please Enter Your Phone Number</p>";
    } //!$Phone
    elseif (preg_match("/^[0-9]{11}$/", $Phone)) {
        $Phone = ValidateFormData($Phone);
    } //preg_match("/^[0-9]{11}$/", $Phone)
    else {
        $Phone = "";
        $PhoneError = "<p class='text-danger'>Please Use Your Valid Phone Number</p>";
    }

    if (!$Country) {
        $CountryError = "<p class='text-danger'>Please Select Your Country</p>";
    } //!$Country
    else {
        $Country = ValidateFormData($Country);
    }

    //Check if whether Username Exists or not.
    if (isset($_POST['Username'])) {
        $Username = $_POST['Username'];
        if ($Username) {

            //Get Username From Databse
            $DBUsername = ValidateFormData($Username);
            $QueryUsername = "SELECT * FROM account WHERE Username = '$DBUsername'";
            $ResultUsername = $Connection->query($QueryUsername);

            if ($ResultUsername->num_rows > 0) {
                $UsernameError = "<p class='text-danger'>Username Already Exists. Please User Another one.</p>";
            } //$ResultUsername->num_rows > 0
            else {
                $UsernameFinal = ValidateFormData(strtok($Username, ' '));

                //Insert Data Into Databse
                if ($Name && $UsernameFinal && $Phone && $Country) {

                    $Query = "UPDATE account SET Fullname = '$Name', Username = '$UsernameFinal', Phone = '$Phone', Country = '$Country' WHERE Email = '" . $_COOKIE['LoggedInEmail'] . "'";
                    if ($Connection->query($Query) === TRUE) {
                        $ProfileMsg = '<div class="animated bounceInDown alert alert-success alert-dismissible show" role="alert">Profile Updated Successfully.<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
                    } //$Connection->query($Query) === TRUE
                    else {
                        $ProfileMsg = '<div class="animated bounceInDown alert alert-warning alert-dismissible show" role="alert"> Error: ' . $Connection->error . '<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
                    }
                } //$Name && $UsernameFinal && $Phone && $Message && $Country
            }
            //If There's No Username Insert All Other Data to Databse
        } //$Username
        else {
            //Insert Data Into Databse
            if ($Name && $Phone && $Country) {

                $Query = "UPDATE account SET Fullname = '$Name', Phone = '$Phone', Country = '$Country' WHERE Email = '" . $_COOKIE['LoggedInEmail'] . "'";
                if ($Connection->query($Query) === TRUE) {
                    $ProfileMsg = '<div class="animated bounceInDown alert alert-success alert-dismissible show" role="alert">Profile Updated Successfully.<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
                } //$Connection->query($Query) === TRUE
                else {
                    $ProfileMsg = '<div class="animated bounceInDown alert alert-warning alert-dismissible show" role="alert"> Error: ' . $Connection->error . '<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
                }
            } //$Name && $Phone && $Message && $Country
        }
    } //isset($_POST['Username'])
} //isset($_POST['UpdateUserProfile'])


//User Detail and their Roles (User Management) /Admin/Users
function DisplayUsers()
{
    global $Connection;

    $Query = "SELECT * FROM account";
    $Result = $Connection->query($Query);

    if ($Result->num_rows > 0) {
        $Number = 0;
        while ($Row = $Result->fetch_assoc()) {
            $Name = $Row['Fullname'];
            $Email = $Row['Email'];
            $Username = $Row['Username'];
            $Role = $Row['Role'];

            echo " <tr>
                        <td>" . ++$Number . "</td>
                        <td><img src='" . GravatarImage($Email) . "' alt='$Name' class='img-circle'></td>
                        <td>$Name</td>
                        <td>@$Username</td>
                        <td>$Role</td>
                   </tr>";
        } //$Row = $Result->fetch_assoc()
    } //$Result->num_rows > 0
}


//Select Account Details of Specific User Session Email or ID
function DisplayAccountDetails()
{
    global $Connection;
    global $Name;
    global $Email;
    global $Username;
    global $Phone;
    global $Country;

    $Query = "SELECT * FROM account WHERE Email = '" . $_COOKIE['LoggedInEmail'] . "'";
    $Result = $Connection->query($Query);

    if ($Result->num_rows > 0) {
        while ($Row = $Result->fetch_assoc()) {
            $Name = $Row['Fullname'];
            $Email = $Row['Email'];
            $Username = $Row['Username'];
            $Phone = $Row['Phone'];
            $Country = $Row['Country'];
        } //$Row = $Result->fetch_assoc()
    } //$Result->num_rows > 0
}


//Select Tags from Databse /Admin/Post
function DisplayTagOption()
{
    global $Connection;

    $Query = "SELECT * FROM tags";
    $Result = $Connection->query($Query);

    if ($Result->num_rows > 0) {
        while ($Row = $Result->fetch_assoc()) {
            echo "<option value='" . $Row['Tag_ID'] . "'>" . $Row['Tag'] . "</option>";
        } //$Row = $Result->fetch_assoc()
    } //$Result->num_rows > 0
}


// Add New Post in Database /Admin/Post
if (isset($_POST['AddPost'])) {

    $PostTitle = $_POST['PostTitle'];
    $PostContent = $_POST['PostContent'];
    $PostTag = $_POST['Tag'];
    $cust_date = $_POST['custdate'];
    $PostSlug = $_POST['PostSlug'];
    //Meta Information
    $MetaKey = $_POST['MetaKey'];
    $MetaDesc = $_POST['MetaDesc'];
    $MetaTitle = $_POST['MetaTitle'];
    

    // Getting Feature Image
    $File = $_FILES['FeatureImage'];
    $FileName = $File['name'];
    $FileTmp = $File['tmp_name'];
    $FileType = $File['type'];
    $FileSize = $File['size'];
    $FileError = $File['error'];
    $FileExt = pathinfo($FileName, PATHINFO_EXTENSION);

    if (!$PostTitle) {
        $PostTitleError = "<p class='text-danger'>Please Add Post Title</p>";
    } else {
        $PostTitle = ValidateFormData($PostTitle);
    }
    // Meta
    // if (!$MetaTitle) {
    //     $MetaTitleError = "<p class='text-danger'>Please Add Meta Title</p>";
    // } else {
    //     $MetaTitle = ValidateFormData($MetaTitle);
    // }
    // if (!$MetaDesc) {
    //     $MetaDescError = "<p class='text-danger'>Please Add Meta Description Title</p>";
    // } else {
    //     $MetaDesc = ValidateFormData($MetaDesc);
    // }
    // if (!$MetaKey) {
    //     $MetaKeyError = "<p class='text-danger'>Please Add Post Title</p>";
    // } else {
    //     $MetaKey = ValidateFormData($MetaKey);
    // }
    // Meta
    if (!$PostSlug) {
        $PostSlugError = "<p class='text-danger'>Please Add Post Slug</p>";
    } else {
        // Convert slug to lowercase and check the format
        $PostSlug = strtolower(trim($PostSlug));

        // Check if the slug format is valid (only lowercase letters, numbers, and hyphens)
        if (!preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $PostSlug)) {
            // If the format is invalid, convert it to a proper format
            $PostSlug = preg_replace('/[^a-z0-9]+/', '-', $PostSlug);  // Replace non-alphanumeric characters with hyphens
            $PostSlug = trim($PostSlug, '-');  // Remove any leading or trailing hyphens
        }
    }

    if (!$PostContent) {
        $PostContentError = "<p class='text-danger'>Please Add Post Content</p>";
    }

    if (!$PostTag) {
        $PostTagError = "<p class='text-danger'>Please Select Post Category</p>";
    } else {
        $PostTag = ValidateFormData($PostTag);
    }

    if (empty($FileName)) {
        $ImageError = "<p class='text-danger'>Please Select Image to Upload</p>";
    }

    // Check if the file size is less than 500KB
    if ($FileSize > 512000) { // 512000 bytes = 500KB
        $ImageError = "<p class='text-danger'>Your file size must be less than 500KB</p>";
        $PostMsg = '<div class="animated bounceInDown alert alert-danger alert-dismissible show position-fixed top-0 start-50 translate-middle-x" role="alert">Your file size must be less than 500KB<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
    } else {
        if ($PostTitle && $FileName && $PostContent && $PostTag && $PostSlug) {
            if (in_array($FileExt, ['png', 'jpg', 'bmp', 'tiff'])) {
                if ($FileSize <= 5242880) { // 5MB limit for other file sizes
                    $FileNewName = uniqid() . '.' . $FileExt;
                    $Dstn = "plugins/images/BlogImages/" . $FileNewName;
                    if (move_uploaded_file($FileTmp, $Dstn)) {

                        // Insert Image Path to Database
                        $ImagePath = 'http://' . $_SERVER["HTTP_HOST"] . '/sonu2/Admin/' . $Dstn;

                        $Query = "INSERT INTO blog_post (Post_Tag, Post_Title, Post_Feature_Image, Post_Content, Posted_By, Post_Date, Post_Slug,MetaTitle,MetaDesc,MetaKey) 
                                  VALUES ('$PostTag', '$PostTitle', '$ImagePath', '$PostContent', '" . $_COOKIE['LoggedInID'] . "', '$cust_date', '$PostSlug','$MetaTitle','$MetaDesc','$MetaKey')";

                        if ($Connection->query($Query) === TRUE) {
                            $PostMsg = '<div class="animated bounceInDown alert alert-success alert-dismissible show" role="alert">New Post Added Successfully<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
                        } else {
                            $PostMsg = '<div class="animated bounceInDown alert alert-warning alert-dismissible show" role="alert"> Error: ' . $Connection->error . '<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
                        }
                    }
                } else {
                    $ImageError = "<p class='text-danger'>Your file size must be less than 5MB</p>";
                }
            } else {
                $ImageError = "<p class='text-danger'>Only .bmp, .jpg, .png, and .tiff Extensions are allowed.</p>";
            }
        }
    }
}



//Update Post in Databse /Admin/Edit
function EditPost()
{
    global $Connection;
    global $PostTag;
    global $PostTitle;
    global $PostSlug;
    global $PostContent;
    global $PostMsg;
    global $PostTitleError;
    global $PostContentError;
    global $PostTagError;
    // Meta
    global $MetaTitle;
    global $MetaDesc;
    global $MetaKey;
    // Meta

    if (isset($_GET['Edit'])) {
        $EditPostID = $_GET['Edit'];

        // Check if there's a post with the parameter ID
        $Query = "SELECT * FROM blog_post WHERE Post_ID = '$EditPostID'";
        $Result = $Connection->query($Query);

        if ($Result->num_rows > 0) {
            $Row = $Result->fetch_assoc();
            $PostTag = $Row['Post_Tag'];
            $PostSlug = $Row['Post_Slug'];
            $PostTitle = $Row['Post_Title'];
            $PostContent = $Row['Post_Content'];
            $ExistingFeatureImage = $Row['Post_Feature_Image'];
            $ExistingDate = $Row['Post_Date'];
            //Meta
            $MetaTitle=$Row['MetaTitle'];
            $MetaDesc=$Row['MetaDesc'];
            $MetaKey=$Row['MetaKey'];
            // Meta
            // Function to display Post_Tag name from the database
            function DisplayPostTag()
            {
                global $Connection, $PostTag;

                $Query = "SELECT * FROM tags WHERE Tag_ID = '$PostTag'";
                $Result = $Connection->query($Query);

                if ($Result->num_rows > 0) {
                    while ($Row = $Result->fetch_assoc()) {
                        echo "<option selected value='" . $Row['Tag_ID'] . "'>" . $Row['Tag'] . "</option>";
                    }
                }
            }

            // Update the post
            if (isset($_POST['UpdatePost'])) {
                $PostTitle = $_POST['PostTitle'];
                // Added Code For Slug
                $PostSlug = $_POST['PostSlug'];
                // Added Code For Slug
                $PostContent = $_POST['PostContent'];
                $PostTag = $_POST['Tag'];
                $cust_date = !empty($_POST['custdate']) ? $_POST['custdate'] : $ExistingDate;
                //Meta
            $MetaTitle=$_POST['MetaTitle'];
            $MetaDesc=$_POST['MetaDesc'];
            $MetaKey=$_POST['MetaKey'];
            // Meta
                // Handling feature image
                $File = $_FILES['FeatureImage'];
                $FileName = $File['name'];
                $FileTmp = $File['tmp_name'];
                $FileType = $File['type'];
                $FileSize = $File['size'];
                $FileError = $File['error'];
                $FileExt = pathinfo($FileName, PATHINFO_EXTENSION);

                // Validation
                if (!$PostTitle) {
                    $PostTitleError = "<p class='text-danger'>Please add a post title</p>";
                } else {
                    $PostTitle = ValidateFormData($PostTitle);
                }
                // Added Code For Slug
                if (!$PostSlug) {
                    $PostSlugError = "<p class='text-danger'>Please Add Post Slug</p>";
                } else {
                    // Convert slug to lowercase and check the format
                    $PostSlug = strtolower(trim($PostSlug));
            
                    // Check if the slug format is valid (only lowercase letters, numbers, and hyphens)
                    if (!preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $PostSlug)) {
                        // If the format is invalid, convert it to a proper format
                        $PostSlug = preg_replace('/[^a-z0-9]+/', '-', $PostSlug);  // Replace non-alphanumeric characters with hyphens
                        $PostSlug = trim($PostSlug, '-');  // Remove any leading or trailing hyphens
                    }
                }
                // Added Code For Slug
                if (!$PostContent) {
                    $PostContentError = "<p class='text-danger'>Please add post content</p>";
                }

                if (!$PostTag) {
                    $PostTagError = "<p class='text-danger'>Please select a post category</p>";
                } else {
                    $PostTag = ValidateFormData($PostTag);
                }
                // Meta
    // if (!$MetaTitle) {
    //     $MetaTitleError = "<p class='text-danger'>Please Add Meta Title</p>";
    // } else {
    //     $MetaTitle = ValidateFormData($MetaTitle);
    // }
    // if (!$MetaDesc) {
    //     $MetaDescError = "<p class='text-danger'>Please Add Meta Description Title</p>";
    // } else {
    //     $MetaDesc = ValidateFormData($MetaDesc);
    // }
    // if (!$MetaKey) {
    //     $MetaKeyError = "<p class='text-danger'>Please Add Post Title</p>";
    // } else {
    //     $MetaKey = ValidateFormData($MetaKey);
    // }
    // Meta

                // Handle image upload only if a file is provided
                if ($FileName) {
                    if (in_array($FileExt, ['png', 'jpg', 'bmp', 'tiff'])) {
                        if ($FileSize <= 5242880) { // 5MB max size
                            $FileNewName = uniqid() . '.' . $FileExt;
                            $Dstn = "plugins/images/BlogImages/" . $FileNewName;
                            if (move_uploaded_file($FileTmp, $Dstn)) {
                                $ImagePath = 'http://' . $_SERVER["HTTP_HOST"] . '/sonu2/Admin/' . $Dstn;
                            } else {
                                $ImagePath = $ExistingFeatureImage; // Keep existing if upload fails
                            }
                        } else {
                            $ImagePath = $ExistingFeatureImage;
                        }
                    } else {
                        $ImagePath = $ExistingFeatureImage;
                    }
                } else {
                    $ImagePath = $ExistingFeatureImage; // Keep the existing image if no file is uploaded
                }

                // Update the post if all fields are valid
                if ($PostTitle && $PostContent && $PostTag) {
                    // Meta
                    $Query = "UPDATE blog_post 
                              SET Post_Tag = '$PostTag', 
                                  Post_Title = '$PostTitle', 
                                  Post_Content = '$PostContent',
                                  Post_Slug = '$PostSlug', 
                                  Posted_By = '" . $_COOKIE['LoggedInID'] . "', 
                                  Post_Date = '$cust_date', 
                                  Post_Feature_Image = '$ImagePath',
                                 MetaTitle='$MetaTitle',
                                MetaDesc='$MetaDesc',
                                MetaKey='$MetaKey'
                              WHERE Post_ID = '$EditPostID'";
                            //   Meta
                    if ($Connection->query($Query) === TRUE) {
                        $PostMsg = '<div class="animated bounceInDown alert alert-success alert-dismissible show" role="alert">Post updated successfully<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
                    } else {
                        $PostMsg = '<div class="animated bounceInDown alert alert-warning alert-dismissible show" role="alert">Error: ' . $Connection->error . '<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
                    }
                }
            }
        } else {
            echo "<script>window.location = 'post.php'</script>";
        }
    } else {
        echo "<script>window.location = 'post.php'</script>";
    }
}


//Display Recent Posts From Database /Admin/Edit
function DisplayRecentPosts()
{
    global $Connection;
    global $PostTag;
    global $PostTitle;
    global $PostContent;
    global $PostedBy;
    global $PostDate;

    $Query = "SELECT * FROM blog_post ORDER BY Post_ID DESC";
    $Result = $Connection->query($Query);

    if ($Result->num_rows > 0) {
        while ($Row = $Result->fetch_assoc()) {
            $PostTag = $Row['Post_Tag'];
            $PostID = $Row['Post_ID'];
            $PostTitle = $Row['Post_Title'];
            $PostContent = ValidateFormData($Row['Post_Content']);
            $PostedBy = $Row['Posted_By'];
            $PostDate = $Row['Post_Date'];

            $PostDate = date('h:i A, d F Y', strtotime($PostDate));
            $PostContent = substr($PostContent, 0, 350);

            echo '<div class="comment-body">
                    <div class="mail-contnet">
                        <h5><b>' . $PostTitle . '</b></h5><span class="time"><b>' . $PostDate . '</b> By <b>' . PostedBy($PostedBy) . '</b></span>
                        <span class="mail-desc">' . $PostContent . '...</span>
                        <a href="edit.php?Edit=' . $PostID . '" class="btn btn btn-rounded btn-default btn-outline m-r-5"><i class="fa fa-edit"></i> Edit This Post</a>
                        <a href="?Delete=' . $PostID . '" onclick="return confirm(\'Are you sure?\');" class="btn-rounded btn btn-danger btn-outline"><i class="fa fa-trash"></i> Delete This Post</a>
                    </div>
                 </div>';
        } //$Row = $Result->fetch_assoc()
    } //$Result->num_rows > 0
}


//Select User Who Posted the thread /Admin/Edit
function PostedBy($PostedBy)
{
    global $Connection;

    $Query = "SELECT * FROM account WHERE ID = '$PostedBy'";
    $Result = $Connection->query($Query);
    if ($Result->num_rows > 0) {
        while ($Row = $Result->fetch_assoc()) {
            return $Row['Username'];
        } //$Row = $Result->fetch_assoc()
    } //$Result->num_rows > 0
}


//Delete Post /Admin/Post
function DeletePost()
{
    global $Connection;
    global $PostMsg;

    $DeletePost = $_GET['Delete'];

    //Check if Post Exist or not
    $Query = "SELECT * FROM blog_post WHERE Post_ID = '$DeletePost'";
    $Result = $Connection->query($Query);

    if ($Result->num_rows > 0) {

        $Query = "DELETE FROM blog_post WHERE Post_ID = '$DeletePost'";
        if ($Connection->query($Query) === TRUE) {

            $Query = "DELETE FROM comments WHERE CommentPost_ID = '$DeletePost'";
            if ($Connection->query($Query) === TRUE) {

                $PostMsg = '<div class="animated bounceInDown alert alert-success alert-dismissible show" role="alert">Post Deleted Successfully<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
            } //$Connection->query($Query) === TRUE
            else {
                $PostMsg = '<div class="animated bounceInDown alert alert-warning alert-dismissible show" role="alert"> Error: ' . $Connection->error . '<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
            }

        } //$Connection->query($Query) === TRUE
        else {
            $PostMsg = '<div class="animated bounceInDown alert alert-warning alert-dismissible show" role="alert"> Error: ' . $Connection->error . '<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
        }
    } //$Result->num_rows > 0
    else {
        echo "<script>window.location = 'post.php'</script>";
    }
}


//Select Comments /Admin/Comments
function DisplayComments()
{
    global $Connection;
    global $CommentPost;
    global $CommentAuthor;
    global $Comment;
    global $CommentDate;

    $Query = "SELECT * FROM comments ORDER BY Comment_ID DESC";
    $Result = $Connection->query($Query);

    if ($Result->num_rows > 0) {
        while ($Row = $Result->fetch_assoc()) {

            $CommentID = $Row['Comment_ID'];
            $CommentPost = $Row['CommentPost_ID'];
            $CommentAuthor = $Row['Comment_Author'];
            $Comment = $Row['Comment'];
            $CommentDate = $Row['Comment_Date'];

            $CommentDate = date('h:i A, d F Y', strtotime($CommentDate));

            //Display Comments
            echo '<div class="comment-body">
                    <div class="mail-contnet">
                        <h5><b>' . PostTitle($CommentPost) . '</b> By <b>' . $CommentAuthor . '</b></h5>
                        <span class="time">' . $CommentDate . '</span>
                        <span class="mail-desc">' . $Comment . '</span>
                        <a href="?Delete=' . $CommentID . '" onclick="return confirm(\'Are you sure?\');" class="btn-rounded btn btn-danger btn-outline"><i class="fa fa-trash"></i> Delete This Comment</a>
                    </div>
                  </div>';

        } //$Row = $Result->fetch_assoc()
    } //$Result->num_rows > 0
}


//Select Post of The Comment /Admin/Comments
function PostTitle()
{
    global $Connection;
    global $CommentPost;

    $Query = "SELECT * FROM blog_post WHERE Post_ID = '$CommentPost'";
    $Result = $Connection->query($Query);
    if ($Result->num_rows > 0) {
        while ($Row = $Result->fetch_assoc()) {
            $CommentPost = $Row['Post_Title'];
            return $CommentPost;
        } //$Row = $Result->fetch_assoc()
    } //$Result->num_rows > 0
}


//Delete Comment /Admin/Comments
function DeleteComment()
{
    global $Connection;
    global $CommentMsg;

    $DeleteComment = $_GET['Delete'];

    //Check if Post Exist or not
    $Query = "SELECT * FROM comments WHERE Comment_ID = '$DeleteComment'";
    $Result = $Connection->query($Query);

    if ($Result->num_rows > 0) {

        $Query = "DELETE FROM comments WHERE Comment_ID = '$DeleteComment'";
        if ($Connection->query($Query) === TRUE) {
            $CommentMsg = '<div class="animated bounceInDown alert alert-success alert-dismissible show" role="alert">Comment Deleted Successfully<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
        } //$Connection->query($Query) === TRUE
        else {
            $CommentMsg = '<div class="animated bounceInDown alert alert-warning alert-dismissible show" role="alert"> Error: ' . $Connection->error . '<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
        }
    } //$Result->num_rows > 0
}


//Display Recent Posts From Database /Admin/Index
function DisplayRecentPostsIndex()
{
    global $Connection;
    global $PostTag;
    global $PostTitle;
    global $PostContent;
    global $PostedBy;
    global $PostDate;

    $Query = "SELECT * FROM blog_post";
    $Result = $Connection->query($Query);

    if ($Result->num_rows > 0) {
        $Number = 0;
        while ($Row = $Result->fetch_assoc()) {
            $PostTag = $Row['Post_Tag'];
            $PostID = $Row['Post_ID'];
            $PostTitle = $Row['Post_Title'];
            $PostDate = $Row['Post_Date'];

            $PostDate = date('M d, Y', strtotime($PostDate));
            $PostTitle = substr($PostTitle, 0, 35);

            if (strlen($PostTitle) > 30) {
                $PostTitle = $PostTitle . "...";
            } //strlen($PostTitle) > 30
            echo '<tr>
                    <td>' . ++$Number . '</td>
                    <td class="txt-oflo">' . $PostTitle . '</td>
                    <td>' . DisplayTagIndex($PostTag) . '</td>
                    <td class="txt-oflo">' . $PostDate . '</td>
                    <td class="txt-oflo">' . PostVisits($PostID) . '</td>
                  </tr>';
        } //$Row = $Result->fetch_assoc()
    } //$Result->num_rows > 0
}


//Display Post Tag
function DisplayTagIndex($PostTag)
{
    global $Connection;
    global $PostTag;

    $Query = "SELECT * FROM tags WHERE Tag_ID = '$PostTag'";
    $Result = $Connection->query($Query);

    if ($Result->num_rows > 0) {
        while ($Row = $Result->fetch_assoc()) {
            $PostTag = $Row['Tag'];
            return $PostTag;
        } //$Row = $Result->fetch_assoc()
    } //$Result->num_rows > 0
}


//User Logout
if (isset($_REQUEST['LogOut'])) {
    // Unset Cookies
    if (isset($_SERVER['HTTP_COOKIE'])) {
        $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
        foreach ($cookies as $cookie) {
            $parts = explode('=', $cookie);
            $name = trim($parts[0]);
            setcookie($name, '', time() - 1000);
            setcookie($name, '', time() - 1000, '/');
        } //$cookies as $cookie
    } //isset($_SERVER['HTTP_COOKIE'])
    session_unset();
    session_destroy();
    header("Location: Login.php");
    die();
} //isset($_REQUEST['LogOut'])


//Show Post Visits /Index
function PostVisits($PostID)
{
    global $Connection;

    $Query = "SELECT * FROM post_visits WHERE Post_ID = '$PostID'";
    $Result = $Connection->query($Query);
    if ($Result->num_rows > 0) {
        while ($Row = $Result->fetch_assoc()) {
            return $Row['Post_Visits'];
        }
    }
}


//Display Total Posts /Index
function TotalPostsCount()
{
    global $Connection;

    $Query = "SELECT COUNT(*) AS Total FROM blog_post";
    $Result = $Connection->query($Query);
    if ($Result->num_rows > 0) {
        while ($Row = $Result->fetch_assoc()) {
            echo $Row['Total'];
        }
    }
}


//Display Total Visit /Index
function TotalVisit()
{
    global $Connection;

    $Query = "SELECT COUNT(*) AS Total_Visits FROM comments;";
    $Result = $Connection->query($Query);

    if ($Result->num_rows > 0) {
        $Row = $Result->fetch_assoc(); // Fetch the result as an associative array
        echo $Row['Total_Visits']; // Output the total visits
    } else {
        echo 0; // If no rows are found, output 0
    }
}


//Display Total Page Views /Index
function TotalPageViews()
{
    global $Connection;

    $Query = "SELECT SUM(post_visits) AS Total FROM post_visits";
    $Result = $Connection->query($Query);
    if ($Result->num_rows > 0) {
        while ($Row = $Result->fetch_assoc()) {
            echo $Row['Total'];
        }
    }
}

//Close Connection
$Connection->error;

?>