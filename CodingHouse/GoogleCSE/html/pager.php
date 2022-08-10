<div class="search-results-pager">
    <p><?=_('Other results')?></p>
    <ul>
    <?php for ($page = 1; $page <= $numberOfPages; $page++):?>
        <li>
            <a href="?q=<?=htmlspecialchars($this->query)?>&amp;start=<?=($page == 1 ? '' : $page-1)?>0&amp;send=search"<?=(($page == $this->selectedPage) ? ' class="selected-page"' : '')?>><?=$page?></a>
        </li>
    <?php endfor?>
    </ul>
</div>
