<div class="container">
    <div class="row">
        <div class="col-12 col-sm8- offset-sm-2 col-md-6 offset-md-3 mt-5 pt-3 pb-3 bg-white from-wrapper">
            <div class="container">
                <h3><?= isset($user) ? $user['firstname'].' '.$user['lastname'] : '' ?></h3>
                <hr>
                <?php if (session()->get('success')): ?>
                    <div class="alert alert-success" role="alert">
                        <?= session()->get('success') ?>
                    </div>
                <?php endif; ?>
                <form class="" action="/addedituser" method="post">
                    <input type="hidden" name="id" value="<?= isset($user)? set_value('id', $user['id']):'' ?>">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="firstname">First Name</label>
                                <input type="text" class="form-control" name="firstname" id="firstname" value="<?= isset($user)? set_value('firstname', $user['firstname']):'' ?>">
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="lastname">Last Name</label>
                                <input type="text" class="form-control" name="lastname" id="lastname" value="<?= isset($user)?  set_value('lastname', $user['lastname']):'' ?>">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="email">Email address</label>
                                <input type="text" name="email" class="form-control" <?= isset($user)?  'readonly' :'' ?>  id="email" value="<?= isset($user)?  $user['email'] :'' ?>">
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password" id="password" value="">
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="password_confirm">Confirm Password</label>
                                <input type="password" class="form-control" name="password_confirm" id="password_confirm" value="">
                            </div>
                        </div>
                        <?php if (isset($validation)): ?>
                            <div class="col-12">
                                <div class="alert alert-danger" role="alert">
                                    <?= $validation->listErrors() ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <button type="submit" class="btn btn-primary"><?= isset($user)?  'Update' :'Add' ?></button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
