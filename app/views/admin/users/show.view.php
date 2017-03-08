<?php partial('admin/header')?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Users
        <small>description</small>
    </h1>
    breadcrumb
</section>
<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-md-3">

            <div class="box box-primary">
                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle" src="<?= $user->image?>" alt="User profile picture">
                    <h3 class="profile-username text-center"><?=$user->firstname." ".$user->lastname?></h3>
                    <p class="text-muted text-center"><?=$user->email?></p>
                </div>
                <!-- /.box-body -->
            </div>

        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#activity" data-toggle="tab">Activity</a></li>
                    <li><a href="#settings" data-toggle="tab">Settings</a></li>
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="activity">
                        <?php foreach ($user->requests() as $req):?>
                            <?php partial('admin/request',['req'=>$req])?>
                        <?php endforeach;?>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="settings">
                        <?php start_form('put',"/users/$user->id",['enctype'=>"multipart/form-data"])?>
                        <div class="box box-solid">
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="box-group" id="accordion">
                                    <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                                    <div class="panel box box-primary">
                                        <div class="box-header with-border">
                                            <h4 class="box-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#basicinfo">
                                                    Basic Info
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="basicinfo" class="panel-collapse collapse in">
                                            <div class="box-body">
                                                <div class="form-group">
                                                    <label for="firstname">First Name</label>
                                                    <input type="text" name="firstname" class="form-control" value="<?=$user->firstname?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="lastname">Last Name</label>
                                                    <input type="text" name="lastname" class="form-control" value="<?=$user->lastname?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="gender">Gender</label>
                                                    <select name="gender" id="" class="form-control">
                                                        <option value="male">Male</option>
                                                        <option value="female">Female</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="country">Country</label>
                                                    <select name="country" id="" class="form-control">
                                                        <option value="egypt">Egypt</option>
                                                        <option value="other">Other</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel box box-primary">
                                        <div class="box-header with-border">
                                            <h4 class="box-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#logininfo">
                                                    Login Info
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="logininfo" class="panel-collapse collapse in">
                                            <div class="box-body">
                                                <div class="form-group">
                                                    <label for="username">User Name</label>
                                                    <input type="text" name="username" class="form-control" value="<?=$user->lastname?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="email">Email</label>
                                                    <input type="email" name="email" class="form-control" value="<?=$user->lastname?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="password">Password</label>
                                                    <input type="password" name="password" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label for="confirm">Confirm Password</label>
                                                    <input type="password" name="confirm" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel box box-primary">
                                        <div class="box-header with-border">
                                            <h4 class="box-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#profileinfo">
                                                    Profile Info
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="profileinfo" class="panel-collapse collapse in">
                                            <div class="box-body">
                                                <div class="form-group">
                                                    <label for="image">Profile Photo</label>
                                                    <?php uploaded_image($user->image)?><br>
                                                    <input type="file" name="image" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php if(count($errors)>0):?>
                                    <div class="alert alert-danger">
                                        <ul>
                                            <?php foreach ($errors as $errors):?>
                                                <?php foreach ($errors as $error):?>
                                                    <p><?=$error?></p>
                                                <?php endforeach;?>
                                            <?php endforeach;?>
                                        </ul>
                                    </div>
                                <?php endif;?>
                            </div>
                            <!-- /.box-body -->
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>

                        </div>
                        <?php close_form()?>
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <div style="padding: 10px 0px; text-align: center;"><div class="text-muted">Excuse the ads! We need some help to keep our site up.</div><script async="" src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script><div class="visible-xs visible-sm"><!-- AdminLTE --><ins class="adsbygoogle" style="display:inline-block;width:300px;height:250px" data-ad-client="ca-pub-4495360934352473" data-ad-slot="5866534244"></ins><script>(adsbygoogle = window.adsbygoogle || []).push({});</script></div><div class="hidden-xs hidden-sm"><!-- Home large leaderboard --><ins class="adsbygoogle" style="display:inline-block;width:728px;height:90px" data-ad-client="ca-pub-4495360934352473" data-ad-slot="1170479443"></ins><script>(adsbygoogle = window.adsbygoogle || []).push({});</script></div></div></section>
<?php partial('admin/footer')?>
