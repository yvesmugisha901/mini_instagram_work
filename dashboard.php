<?php
session_start();
include 'config.php';

if(!isset($_SESSION['user'])){
    header("Location: signin.php");
    exit();
}

$username = $_SESSION['user'];

// Mock posts
$posts = [
    [
        'username' => 'User1',
        'profile' => 'https://randomuser.me/api/portraits/women/5.jpg',
        'image' => 'https://picsum.photos/600/400?random=1',
        'caption' => 'Enjoying the sunny day!'
    ],
    [
        'username' => 'User2',
        'profile' => 'https://randomuser.me/api/portraits/men/6.jpg',
        'image' => 'https://picsum.photos/600/400?random=2',
        'caption' => 'My latest adventure!'
    ]
];

if(isset($_POST['logout'])){
    session_destroy();
    header("Location: signin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Instagram Dashboard - Dark Mode</title>

<style>
/* Reset */
* { margin:0; padding:0; box-sizing:border-box; font-family: Arial, sans-serif; }
body { background:#121212; color:#e0e0e0; }

/* Layout */
.container { display: flex; width:100%; min-height:100vh; }

/* Left Sidebar */
.sidebar-left {
    width: 220px;
    background:#1e1e1e;
    border-right:1px solid #333;
    display:flex;
    flex-direction:column;
    padding:20px 10px;
}
.sidebar-left a {
    display:flex;
    align-items:center;
    margin-bottom:15px;
    text-decoration:none;
    color:#e0e0e0;
    font-weight:500;
    font-size:14px;
    padding:5px;
    border-radius:5px;
}
.sidebar-left a img { width:24px; margin-right:15px; filter: invert(1); }
.sidebar-left a:hover, .sidebar-left a.active { background:#333; }
.sidebar-left form button {
    margin-top:20px; 
    padding:5px 10px; 
    border:none; 
    background:#ed4956; 
    color:white; 
    border-radius:3px; 
    cursor:pointer;
}

/* Main Feed */
.main { flex:1; display:flex; justify-content:center; padding:20px; }
.feed { width:600px; }
.stories { display:flex; background:#1e1e1e; border:1px solid #333; border-radius:5px; padding:10px; margin-bottom:20px; overflow-x:auto; }
.story { margin-right:10px; text-align:center; }
.story img { width:60px; height:60px; border-radius:50%; border:2px solid #c13584; }

/* Posts */
.post { background:#1e1e1e; border:1px solid #333; border-radius:5px; margin-bottom:20px; }
.post-header { display:flex; align-items:center; padding:10px; }
.post-header img { width:40px; height:40px; border-radius:50%; margin-right:10px; }
.post-img img { width:100%; max-height:500px; object-fit:cover; }
.post-actions { display:flex; padding:10px; }
.post-actions img { width:24px; margin-right:10px; cursor:pointer; filter: invert(1); }
.post-caption { padding:0 10px 10px 10px; }

/* Right Sidebar */
.sidebar-right { width:300px; padding:20px; }
.suggested { background:#1e1e1e; border:1px solid #333; border-radius:5px; padding:10px; }
.suggested h4 { margin-bottom:10px; }
.suggested-user { display:flex; align-items:center; margin-bottom:10px; }
.suggested-user img { width:32px; height:32px; border-radius:50%; margin-right:10px; }
.suggested-user button { margin-left:auto; padding:5px 10px; border:none; background:#0095f6; color:white; border-radius:3px; cursor:pointer; }

/* Footer */
.footer { width:100%; text-align:center; padding:20px 0; margin-top:20px; color:#999; font-size:12px; }
.footer a { color:#999; margin:0 8px; text-decoration:none; }
.footer a:hover { text-decoration:underline; }

</style>
</head>
<body>

<div class="container">

    <!-- Left Sidebar -->
    <div class="sidebar-left">
        <a href="#" class="active"><img src="https://cdn-icons-png.flaticon.com/512/25/25694.png" />Home</a>
        <a href="#"><img src="https://cdn-icons-png.flaticon.com/512/622/622669.png" />Search</a>
        <a href="#"><img src="https://cdn-icons-png.flaticon.com/512/483/483356.png" />Explore</a>
        <a href="#"><img src="https://cdn-icons-png.flaticon.com/512/3524/3524635.png" />Reels</a>
        <a href="#"><img src="https://cdn-icons-png.flaticon.com/512/1077/1077035.png" />Messages</a>
        <a href="#"><img src="https://cdn-icons-png.flaticon.com/512/1827/1827392.png" />Notifications</a>
        <a href="#"><img src="https://cdn-icons-png.flaticon.com/512/1828/1828817.png" />Create</a>
        <a href="#"><img src="https://cdn-icons-png.flaticon.com/512/747/747376.png" />Assistant</a>
        <a href="#"><img src="https://cdn-icons-png.flaticon.com/512/61/61112.png" />More</a>
        <form method="POST">
            <button type="submit" name="logout">Logout</button>
        </form>
    </div>

    <!-- Main Feed -->
    <div class="main">
        <div class="feed">
            <!-- Stories -->
            <div class="stories">
                <div class="story"><img src="https://randomuser.me/api/portraits/women/1.jpg"><div>User1</div></div>
                <div class="story"><img src="https://randomuser.me/api/portraits/men/2.jpg"><div>User2</div></div>
                <div class="story"><img src="https://randomuser.me/api/portraits/women/3.jpg"><div>User3</div></div>
                <div class="story"><img src="https://randomuser.me/api/portraits/men/4.jpg"><div>User4</div></div>
            </div>

            <!-- Posts -->
            <?php foreach($posts as $post): ?>
            <div class="post">
                <div class="post-header">
                    <img src="<?= $post['profile'] ?>" alt="Profile Pic">
                    <strong><?= htmlspecialchars($post['username']) ?></strong>
                </div>
                <div class="post-img">
                    <img src="<?= $post['image'] ?>" alt="Post Image">
                </div>
                <div class="post-actions">
                    <img src="https://cdn-icons-png.flaticon.com/512/1077/1077035.png" title="Like" />
                    <img src="https://cdn-icons-png.flaticon.com/512/1380/1380338.png" title="Comment" />
                    <img src="https://cdn-icons-png.flaticon.com/512/786/786205.png" title="Share" />
                </div>
                <div class="post-caption">
                    <strong><?= htmlspecialchars($post['username']) ?></strong> <?= htmlspecialchars($post['caption']) ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Right Sidebar -->
        <div class="sidebar-right">
            <div class="suggested">
                <h4>Suggested</h4>
                <div class="suggested-user">
                    <img src="https://randomuser.me/api/portraits/men/10.jpg">
                    <span>UserA</span>
                    <button>Follow</button>
                </div>
                <div class="suggested-user">
                    <img src="https://randomuser.me/api/portraits/women/11.jpg">
                    <span>UserB</span>
                    <button>Follow</button>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Footer -->
<div class="footer">
    <a href="#">About</a>•
    <a href="#">Help</a>•
    <a href="#">Press</a>•
    <a href="#">API</a>•
    <a href="#">Jobs</a>•
    <a href="#">Privacy</a>•
    <a href="#">Terms</a>•
    <a href="#">Locations</a>•
    <a href="#">Top Accounts</a>•
    <a href="#">Hashtags</a>•
    <a href="#">Language</a>
    <p>&copy; 2025 Instagram from Behind the Spotlight</p>
</div>

</body>
</html>
