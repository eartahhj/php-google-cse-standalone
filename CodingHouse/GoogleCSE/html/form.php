<form id="<?=htmlspecialchars($id)?>" action="<?=htmlspecialchars($action)?>" method="<?=htmlspecialchars($method)?>" class="<?=htmlspecialchars($cssClass)?>">
    <label for="google-cse-search"><?=_('Search website')?></label>
    <input id="google-cse-search" type="search" name="<?=$this->queryHttpParam?>" placeholder="<?=_('Search website')?>"<?=($this->query ? ' value="' . htmlspecialchars($this->query) . '"' : '')?> />
    <input type="submit" name="<?=$this->submitName?>" value="<?=_('Search')?>" />
</form>
