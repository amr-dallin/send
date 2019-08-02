<?php
$this->layout = 'login';

$this->start('title');
echo __('Login');
$this->end();
?>

<div class="well">
    <?php
    echo $this->Form->create('Users', [
        'autocomplete' => 'off',
        'templates' => 'SmartAdmin.app_form'
    ]);
    ?>
    <fieldset>
        <?php
        echo $this->Form->control('username', ['placeholder' => __('Username')]);
        echo $this->Form->control('password', ['placeholder' => __('Password')]);
        ?>
    </fieldset>
    <div class="form-actions">
        <div class="row">
            <div class="col-md-12">
                <?php echo $this->Form->submit(__('Log In')); ?>
            </div>
        </div>
    </div>
    <?php echo $this->Form->end(); ?>
</div>