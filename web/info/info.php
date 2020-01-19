

<div style="width: 90%; margin: 0 auto; text-align:center;">
    <table id="infoTbl">
        <tr>
            <td>
                <h1><?php echo h($settings->info['info_title']); ?></h1>
            </td>
        </tr>
        <tr>
            <td>
               <span><?php echo $settings->info['info_msg']; ?></span>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo h($settings->info['info_tel_msg']); ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo $settings->info['info_time_msg']; ?>
            </td>
        </tr>
</div>