<div class="card profile-card">
    <div class="profile-header" style="background-color: #f1c40f;">&nbsp;</div>
    <div class="profile-body">
        <div class="image-area">
            <img src="<?php echo base_url('assets/images/logo.png'); ?>" alt="Profile Image" width="128" height="128" />
        </div>
        <div class="content-area">
            <h3><?php echo $name; ?></h3>
            <p><?php echo $email; ?></p>
            <p><?php echo $user_type; ?></p>
        </div>
    </div>
    <div class="profile-footer">
        <ul>
            <li>
                <span>SEMESTER</span>
                <span>1.234</span>
            </li>
            <li>
                <span>TEACHING LOADS</span>
                <span>1.201</span>
            </li>
            <li>
                <span style="vertical-align: middle;"><i class="material-icons">date_range</i></span>
                <span><?php echo $get_time; ?></span>
            </li>
        </ul>
        <button class="btn btn-primary btn-lg waves-effect btn-block">CHANGE PASSWORD</button>
        <a href="/office-of-admissions/login/logout" class="btn btn-danger btn-lg waves-effect btn-block">LOGOUT</a>
    </div>
</div>