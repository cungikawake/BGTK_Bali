<?php $photo = $this->utility->getUserPhoto($user_id); ?>
<tr class="unread">
    <td class="no-absen"><?php print $no; ?></td>
    <td><img class="rounded-circle" style="width: 40px" src="<?php print $photo; ?>" alt="activity-user"></td>
    <td>
        <h6 class="mb-1 wrap-text"><?php print $nama; ?></h6>
        <p class="m-0">NIP <?php print $nip; ?></p>
    </td>
    <td>
        <?php if (!empty($keterangan)) { ?>
        <a href="javascript:;" class="text-danger keterangan-tidak-hadir" title="Keterangan" data-id="<?php print $id; ?>">
            <i class="feather icon-message-square f-18"></i>
        </a>
        <p class="hide keterangan-apel-<?php print $id; ?>"><?php print $keterangan; ?></p>
         <?php } ?>
    </td>
</tr>