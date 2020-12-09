<nav class="navbar navbar-expand-lg navbar-dark bg-primary justify-content-between">
    <span class="navbar-brand"><img src="../assets/minibb.ico" width="40" height="40" alt=""></span>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarLeft" aria-controls="navbarLeft" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse text-white" id="navbarLeft">
        <ul class="navbar-nav" style="color:aliceblue !important;">
            <li class="nav-item active">
                <a class="nav-link" href="#">Announcements</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="#">Course</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="#">Grade</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="#"></a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown active">
                <a class="nav-link dropdown-toggle" href="#" id="profileLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo $welcomeMsg; ?>
                    <span id="badge" class="badge badge-light">2</span>
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profileLink">
                    <a class="dropdown-item" href="#">Edit Profile</a>
                    <a class="dropdown-item" href="#">Settings</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Sign Out</a>
                </div>
            </li>
        </ul>
    </div>
</nav>