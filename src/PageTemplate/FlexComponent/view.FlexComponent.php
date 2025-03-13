<?php

namespace DumpsterfireComponents\PageTemplate\FlexComponent;

/**
 * @var FlexComponent $this
 */

?>

<div class="flex-component">
    <?php foreach($this->getItems() as $item) {
        $item->render();
    } ?>
</div>