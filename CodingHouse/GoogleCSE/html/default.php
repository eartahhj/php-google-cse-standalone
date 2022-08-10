<?php
if ($this->query):
    if ($this->totalResults > 0):
        ?>
        <h2><?php printf(_('Results found for: %s'), '<em>' . htmlspecialchars($this->query) . '</em>')?></h2>
        <p class="result-num">
            <?php
            if ($this->totalResults == 1) {
                printf(_('%d result'), $this->totalResults);
            } elseif ($this->totalResults > 1) {
                printf(_('%d results'), $this->totalResults);
            }
            ?>
        </p>
        <?php
    else:
        ?>
        <p class="result-num"><?=_('No results')?></p>
        <?php
    endif;
else:
    _('No search term entered');
endif;
