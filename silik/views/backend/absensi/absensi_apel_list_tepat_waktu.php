<?php $photo = $this->utility->getUserPhoto($user_id); ?>
<tr class="unread">
    <td class="no-absen"><?php print $no; ?></td>
    <td><img class="rounded-circle" style="width: 40px" src="<?php print $photo; ?>" alt="activity-user"></td>
    <td>
        <h6 class="mb-1 wrap-text"><?php print $nama; ?></h6>
        <p class="m-0">NIP <?php print $nip; ?></p>
    </td>
    <td>
        <h6 class="text-muted"><i class="ti ti-circle-filled text-success f-10 m-r-15"></i><?php print $absen; ?></h6>
    </td>
    <td>
        <div class="text-success">
            <i class="feather icon-check-square f-18"></i>
        </div>
    </td>
</tr>