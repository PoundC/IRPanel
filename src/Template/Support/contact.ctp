<?php

if($formSubmitted == true) {

    echo $this->element('blank');
}
else {

    echo $this->element('Support/get_contact');
}

?>

<?= $this->element('Support/email_us') ?>