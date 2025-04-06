<div>
    <h2><?= lang('header_title') ?></h2>
    <?= form_open() //CSRF included ?>
    
        <input name="usr" id="fld_usr" type="text" placeholder="<?= lang('username') ?>">
        <input name="pwd" type="password" placeholder="<?= lang('password') ?>">

    <?php if(isset($log)) : ?>
        <div class="alert alert-error">
          <button type="button" class="close" data-dismiss="alert" aria-label="close">&times;</button>
          <?= lang($log) ?>
        </div>
    <?php endif;?>

        <label class="checkbox">
          <input type="checkbox" value="remember"> <?= lang('remember_me') ?>
        </label>
        <button class="btn btn-large btn-primary" type="submit"><?= lang('sign_in') ?></button>

    </form>
</div>

<script type="text/javascript">
<!--// SCRIPT ****************************************************************************************/

// focus first field
document.getElementById('fld_usr');

// submit on enter key
if (document.layers) document.captureEvents(Event.KEYDOWN);
document.onkeydown = function (evt){
    var keyCode = evt ? (evt.which ? evt.which : evt.keyCode) : event.keyCode;
    if (keyCode == 13) document.forms[0].submit();
    
    if (keyCode == 27) { 
            //For escape.
            //Your function here.
    }
    else return true;
};

    
//-->
</script>